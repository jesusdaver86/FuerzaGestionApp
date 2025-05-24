# Sistema de Gestión de Transporte

Este proyecto es una aplicación web diseñada para la gestión de operaciones relacionadas con el transporte. Permite administrar información sobre pasajeros, unidades de transporte, ventas de boletos y otros aspectos relevantes del negocio.

## Tecnologías y Librerías Principales

Este proyecto utiliza una combinación de tecnologías y librerías para su funcionamiento:

*   **Backend:**
    *   PHP
    *   MySQL (o un sistema de gestión de bases de datos compatible)
*   **Frontend:**
    *   HTML5
    *   CSS3
    *   JavaScript
    *   jQuery
    *   AdminLTE (Plantilla de administración)
    *   Bootstrap (Framework CSS)
    *   DataTables (Plugin de jQuery para tablas interactivas)
    *   Chart.js (Librería para la creación de gráficos)
*   **Generación de Reportes/Exportación:**
    *   TCPDF (Librería PHP para generar archivos PDF)
    *   PHPExcel / PhpSpreadsheet (Librerías PHP para trabajar con archivos Excel)
*   **Gestión de Dependencias:**
    *   Composer (Para dependencias PHP)
    *   NPM (Para dependencias JavaScript/Node.js)

## Estructura del Proyecto

El proyecto sigue una estructura organizada para separar las diferentes responsabilidades de la aplicación:

*   `ajax/`: Contiene scripts PHP que manejan peticiones AJAX desde el frontend.
*   `controladores/`: Incluye los controladores PHP que gestionan la lógica de negocio y la interacción entre los modelos y las vistas.
*   `modelos/`: Contiene los modelos PHP que interactúan con la base de datos y manejan la lógica de datos.
*   `vistas/`: Alberga los archivos de la interfaz de usuario (HTML, PHP para plantillas, CSS, JavaScript del lado del cliente).
    *   `vistas/modulos/`: Componentes reutilizables de la interfaz de usuario.
    *   `vistas/dist/`: Archivos de la plantilla AdminLTE.
    *   `vistas/bower_components/` y `node_modules/`: Dependencias de frontend gestionadas por Bower (aunque `node_modules` sugiere un cambio hacia NPM).
*   `assets/`: Recursos estáticos como imágenes, hojas de estilo CSS y archivos JavaScript globales. Incluye librerías como OrgChart.
*   `extensiones/`: Librerías PHP de terceros, como TCPDF.
*   `vendor/`: Dependencias PHP gestionadas por Composer (ej. PhpSpreadsheet).
*   `index.php`: Punto de entrada principal de la aplicación.
*   `composer.json`: Define las dependencias PHP del proyecto.
*   `package.json`: Define las dependencias JavaScript/Node.js del proyecto.

## Configuración e Instalación (Guía Básica)

1.  **Servidor Web:** Asegúrate de tener un servidor web (como Apache o Nginx) con PHP instalado.
2.  **Base de Datos:** Configura una base de datos MySQL (o compatible). Deberás importar la estructura de la base de datos (generalmente a través de un archivo `.sql` que podría no estar presente en este repositorio y necesitar ser generado o provisto por separado).
3.  **Clonar Repositorio:** Clona este repositorio en tu servidor web:
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    ```
4.  **Dependencias PHP:** Instala las dependencias de PHP usando Composer:
    ```bash
    composer install
    ```
5.  **Dependencias JavaScript/Node.js:** Instala las dependencias de frontend usando NPM:
    ```bash
    npm install
    ```
    *(Nota: La presencia de `vistas/bower_components` sugiere que Bower pudo haber sido usado anteriormente. Si `npm install` no instala todas las dependencias de frontend, podrías necesitar investigar el uso de Bower o migrar esas dependencias a `package.json`.)*
6.  **Configuración de Conexión:** Configura la conexión a la base de datos. Usualmente esto se hace en un archivo de configuración dentro de `modelos/`, como `conexion.php` o `conexionpdo.php`. Deberás actualizar las credenciales de la base de datos (host, nombre de usuario, contraseña, nombre de la base de datos).
7.  **Permisos:** Asegúrate de que el servidor web tenga permisos de escritura para los directorios que lo requieran (por ejemplo, para subida de archivos, logs, o caché).
8.  **Acceso:** Accede a la aplicación a través de tu navegador web.

**Nota Importante:** Esta es una guía genérica. Podrían ser necesarios pasos adicionales o configuraciones específicas dependiendo del entorno y de cómo esté estructurada originalmente la aplicación (especialmente la configuración de la base de datos y cualquier variable de entorno).

## Contribuciones

Las contribuciones a este proyecto son bienvenidas. Si deseas mejorar el código, proponer nuevas funcionalidades o corregir errores, por favor considera:

1.  Hacer un fork del repositorio.
2.  Crear una nueva rama para tus cambios (`git checkout -b feature/nueva-funcionalidad`).
3.  Realizar tus modificaciones y hacer commit (`git commit -am 'Añade nueva funcionalidad'`).
4.  Empujar tus cambios a la rama (`git push origin feature/nueva-funcionalidad`).
5.  Abrir un Pull Request.
