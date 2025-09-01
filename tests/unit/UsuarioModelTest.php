<?php

declare(strict_types=1);

namespace Tests\Unit;

use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use ModeloUsuarios; 

require_once __DIR__ . '/../../modelos/usuarios.modelo.php'; 
require_once __DIR__ . '/../../modelos/conexion.php'; // Required to call Conexion::setTestPdoInstance


class UsuarioModelTest extends TestCase
{
    protected static ?PDO $pdo = null; 
    private static string $tableName = "usuarios"; 

    public static function setUpBeforeClass(): void
    {
        try {
            // 1. Create the in-memory SQLite PDO instance for the test class
            self::$pdo = new PDO('sqlite::memory:');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 2. Pass this PDO instance to the Conexion class for methods under test to use
            \Modelos\Conexion::setTestPdoInstance(self::$pdo);

            // 3. Create the schema in the shared PDO instance
            $sql = "CREATE TABLE IF NOT EXISTS " . self::$tableName . " (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL,
                usuario TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                perfil TEXT NOT NULL,
                foto TEXT,
                estado INTEGER DEFAULT 0, 
                ultimo_login TEXT, 
                fecha TEXT DEFAULT (STRFTIME('%Y-%m-%d %H:%M:%S', 'now'))
            )";
            self::$pdo->exec($sql);

        } catch (PDOException $e) {
            throw new PDOException("Failed to set up the test database in setUpBeforeClass: " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$pdo) {
            try {
                self::$pdo->exec('DROP TABLE IF EXISTS ' . self::$tableName);
            } catch (PDOException $e) {
                // Log error or ignore
            }
            // Clear the test PDO instance from Conexion as well
            // (Requires a method in Conexion or setting to null if accessible)
            // For now, just nullify the local static ref.
            // If Conexion had a `clearTestPdoInstance()`, call it here.
            self::$pdo = null; 
        }
    }

    // Getter for the test-specific PDO connection (used for direct assertions/setup in tests)
    protected function getTestPdo(): PDO
    {
        if (self::$pdo === null) {
            self::setUpBeforeClass(); 
        }
        return self::$pdo;
    }

    protected function setUp(): void
    {
        $pdo = $this->getTestPdo(); 
        try {
            $pdo->exec('DELETE FROM ' . self::$tableName . ';');
            $pdo->exec("DELETE FROM sqlite_sequence WHERE name='" . self::$tableName . "';");
        } catch (PDOException $e) {
            $this->fail("Failed to clear table in setUp: " . $e->getMessage());
        }
    }

    protected function tearDown(): void
    {
        // No specific tearDown needed after each test as setUp clears the table.
    }

    public function testPlaceholderToEnsureSetupRuns(): void
    {
        $this->assertTrue(true, "Placeholder test to ensure setup runs.");
    }

    // --- Helper for inserting user in tests ---
    private function insertTestUser(array $overrideData = []): array
    {
        $defaultPassword = "originalPassword123";
        $defaultData = [
            "nombre" => "Original Name",
            "usuario" => "originaluser" . uniqid(), 
            "password" => password_hash($defaultPassword, PASSWORD_DEFAULT),
            "perfil" => "Vendedor",
            "foto" => "path/original.jpg",
            "estado" => 0, 
            "plainPassword" => $defaultPassword 
        ];
        $userData = array_merge($defaultData, $overrideData);
        
        if (isset($overrideData['password']) && !password_get_info($overrideData['password'])['algo']) {
            $userData['plainPassword'] = $overrideData['password'];
            $userData['password'] = password_hash($overrideData['password'], PASSWORD_DEFAULT);
        } elseif (isset($overrideData['plainPassword'])) {
            $userData['password'] = password_hash($userData['plainPassword'], PASSWORD_DEFAULT);
        }

        // ModeloUsuarios methods will now use the PDO instance set via Conexion::setTestPdoInstance
        $result = ModeloUsuarios::mdlIngresarUsuario(self::$tableName, $userData);
        if ($result !== "ok") {
            $this->fail("Helper: Failed to insert test user. Error: " . $result . " User: " . $userData['usuario']);
        }

        $stmt = $this->getTestPdo()->prepare("SELECT id FROM " . self::$tableName . " WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $userData["usuario"], PDO::PARAM_STR);
        $stmt->execute();
        $fetchedUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fetchedUser || !isset($fetchedUser['id'])) {
            $this->fail("Helper: Could not retrieve ID for inserted test user: " . $userData["usuario"]);
        }
        $userData['id'] = (int)$fetchedUser['id']; 
        return $userData;
    }

    // --- Tests for mdlIngresarUsuario ---
    /** @testdox Successfully inserts a new user with valid data. */
    public function testMdlIngresarUsuarioSuccess(): void
    {
        $plainPassword = "password123";
        $datos = [
            "nombre" => "Test User Success", "usuario" => "testsuccess",
            "password" => password_hash($plainPassword, PASSWORD_DEFAULT),
            "perfil" => "Vendedor", "foto" => "vistas/img/usuarios/default/anonymous.png"
        ];
        $this->assertEquals("ok", ModeloUsuarios::mdlIngresarUsuario(self::$tableName, $datos));
        $user = $this->getTestPdo()->query("SELECT * FROM usuarios WHERE usuario = 'testsuccess'")->fetch(PDO::FETCH_ASSOC);
        $this->assertIsArray($user);
        $this->assertEquals($datos["nombre"], $user["nombre"]);
        $this->assertTrue(password_verify($plainPassword, $user["password"]));
        $this->assertEquals(0, $user["estado"]); 
    }
    
    /** @testdox Fails to insert a user if the username already exists. */
    public function testMdlIngresarUsuarioReturnsErrorOnDuplicateUsername(): void
    {
        $this->insertTestUser(['usuario' => 'duplicateuser']);
        $datos2 = ["nombre" => "Second User", "usuario" => "duplicateuser", "password" => "pass", "perfil" => "Admin", "foto" => ""];
        $this->assertEquals("error", ModeloUsuarios::mdlIngresarUsuario(self::$tableName, $datos2));
        $count = $this->getTestPdo()->query("SELECT COUNT(*) FROM usuarios WHERE usuario = 'duplicateuser'")->fetchColumn();
        $this->assertEquals(1, $count);
    }

    /** @testdox Fails to insert a user if essential data (e.g., nombre) is missing. */
    public function testMdlIngresarUsuarioReturnsErrorOnMissingRequiredData(): void
    {
        $datos = ["usuario" => "testmissing", "password" => "pass", "perfil" => "Vendedor", "foto" => ""];
        $this->assertEquals("error", ModeloUsuarios::mdlIngresarUsuario(self::$tableName, $datos));
    }
    
    // --- Tests for mdlEditarUsuario ---
    /** @testdox Successfully edits user details without changing the password. */
    public function testMdlEditarUsuarioSuccessNoPasswordChange(): void
    {
        $initialUser = $this->insertTestUser();
        $datosUpdate = ["id" => $initialUser["id"], "nombre" => "Updated Name", "usuario" => $initialUser["usuario"], "perfil" => "Admin", "foto" => "new.jpg", "password" => null];
        $this->assertEquals("ok", ModeloUsuarios::mdlEditarUsuario(self::$tableName, $datosUpdate));
        $updatedUser = $this->getTestPdo()->query("SELECT * FROM usuarios WHERE id = {$initialUser['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals("Updated Name", $updatedUser["nombre"]);
        $this->assertEquals($initialUser['password'], $updatedUser["password"]); // Password unchanged
    }

    /** @testdox Successfully edits user details including the password. */
    public function testMdlEditarUsuarioSuccessWithPasswordChange(): void
    {
        $initialUser = $this->insertTestUser();
        $newPlainPassword = "newSecurePassword456";
        $datosUpdate = ["id" => $initialUser["id"], "nombre" => "Name NewPass", "usuario" => $initialUser["usuario"], "password" => password_hash($newPlainPassword, PASSWORD_DEFAULT), "perfil" => "Especial", "foto" => "newpass.jpg"];
        $this->assertEquals("ok", ModeloUsuarios::mdlEditarUsuario(self::$tableName, $datosUpdate));
        $updatedUser = $this->getTestPdo()->query("SELECT password FROM usuarios WHERE id = {$initialUser['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertTrue(password_verify($newPlainPassword, $updatedUser["password"]));
    }

    /** @testdox Successfully edits a user's username to a new unique username. */
    public function testMdlEditarUsuarioSuccessWithUsernameChange(): void
    {
        $initialUser = $this->insertTestUser(['usuario' => 'olduser' . uniqid()]);
        $newUsername = 'newuser' . uniqid();
        $datosUpdate = ["id" => $initialUser["id"], "nombre" => "UserNewName", "usuario" => $newUsername, "password" => null, "perfil" => "Vendedor", "foto" => ""];
        $this->assertEquals("ok", ModeloUsuarios::mdlEditarUsuario(self::$tableName, $datosUpdate));
        $updatedUser = $this->getTestPdo()->query("SELECT usuario FROM usuarios WHERE id = {$initialUser['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals($newUsername, $updatedUser["usuario"]);
        $countOld = $this->getTestPdo()->query("SELECT COUNT(*) FROM usuarios WHERE usuario = '{$initialUser['usuario']}'")->fetchColumn();
        $this->assertEquals(0, $countOld);
    }
    
    /** @testdox Fails to edit a user's username if the new username already exists. */
    public function testMdlEditarUsuarioFailsOnDuplicateUsernameChange(): void
    {
        $userA = $this->insertTestUser(['usuario' => 'userA' . uniqid()]);
        $userB = $this->insertTestUser(['usuario' => 'userB' . uniqid()]); 
        $datosUpdateUserA = ["id" => $userA["id"], "nombre" => "TryBeUserB", "usuario" => $userB['usuario'], "password" => null, "perfil" => "Vendedor", "foto" => ""];
        $this->assertEquals("error", ModeloUsuarios::mdlEditarUsuario(self::$tableName, $datosUpdateUserA));
        $currentUserA = $this->getTestPdo()->query("SELECT usuario FROM usuarios WHERE id = {$userA['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals($userA['usuario'], $currentUserA['usuario']);
    }

    /** @testdox Returns 'ok' when attempting to update a user with a non-existent ID. */
    public function testMdlEditarUsuarioNonExistentId(): void
    {
        $datosUpdate = ["id" => 99999, "nombre" => "Ghost", "usuario" => "ghost" . uniqid(), "password" => "pass", "perfil" => "None", "foto" => ""];
        $this->assertEquals("ok", ModeloUsuarios::mdlEditarUsuario(self::$tableName, $datosUpdate));
    }

    // --- Tests for mdlActualizarUsuario ---
    /** @testdox Successfully updates user 'estado' using mdlActualizarUsuario. */
    public function testMdlActualizarUsuarioSuccessEstado(): void
    {
        $initialUser = $this->insertTestUser(['estado' => 0]); 
        $this->assertEquals("ok", ModeloUsuarios::mdlActualizarUsuario(self::$tableName, 'estado', 1, 'id', $initialUser['id']));
        $updatedUser = $this->getTestPdo()->query("SELECT estado FROM usuarios WHERE id = {$initialUser['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals(1, $updatedUser['estado']);
    }

    /** @testdox Successfully updates user 'ultimo_login' using mdlActualizarUsuario. */
    public function testMdlActualizarUsuarioSuccessUltimoLogin(): void
    {
        $initialUser = $this->insertTestUser();
        $newLoginTime = date('Y-m-d H:i:s'); 
        $this->assertEquals("ok", ModeloUsuarios::mdlActualizarUsuario(self::$tableName, 'ultimo_login', $newLoginTime, 'id', $initialUser['id']));
        $updatedUser = $this->getTestPdo()->query("SELECT ultimo_login FROM usuarios WHERE id = {$initialUser['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals($newLoginTime, $updatedUser['ultimo_login']);
    }

    /** @testdox Returns 'ok' when mdlActualizarUsuario attempts to update a non-existent user. */
    public function testMdlActualizarUsuarioNonExistentUser(): void
    {
        $this->assertEquals("ok", ModeloUsuarios::mdlActualizarUsuario(self::$tableName, 'estado', 1, 'id', 99999));
    }

    // --- Tests for mdlBorrarUsuario ---
    /** @testdox Successfully deletes an existing user. */
    public function testMdlBorrarUsuarioSuccess(): void
    {
        $userToDelete = $this->insertTestUser();
        $countBefore = $this->getTestPdo()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $this->assertEquals("ok", ModeloUsuarios::mdlBorrarUsuario(self::$tableName, $userToDelete['id']));
        $deletedUser = $this->getTestPdo()->query("SELECT * FROM usuarios WHERE id = {$userToDelete['id']}")->fetch(PDO::FETCH_ASSOC);
        $this->assertFalse($deletedUser);
        $countAfter = $this->getTestPdo()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $this->assertEquals($countBefore - 1, $countAfter);
    }

    /** @testdox Returns 'ok' when attempting to delete a non-existent user. */
    public function testMdlBorrarUsuarioNonExistentUser(): void
    {
        $this->insertTestUser(); 
        $countBefore = $this->getTestPdo()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $this->assertEquals("ok", ModeloUsuarios::mdlBorrarUsuario(self::$tableName, 99999));
        $countAfter = $this->getTestPdo()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $this->assertEquals($countBefore, $countAfter);
    }
}
?>
