# FuerzaGestionApp

## Project Description

FuerzaGestionApp is a web application designed to streamline operational management, particularly for businesses in the transportation or logistics sector. It provides modules for handling passengers, managing vehicle units, and tracking sales, thereby helping to optimize core business processes.

## Technologies Used

*   **Backend:** PHP
*   **Libraries:**
    *   phpoffice/phpspreadsheet (for Excel file manipulation)
    *   SweetAlert2 (for interactive alerts)
*   **Frontend:** JavaScript, HTML, CSS
*   **Database:** A relational database (e.g., MySQL, MariaDB). *(Database type inferred from common PHP practices; specific file `modelos/conexion.php` would need inspection for confirmation).*
*   **Testing:** PHPUnit

## Installation Instructions

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    ```
2.  **Install PHP dependencies:**
    Navigate to the project directory and run:
    ```bash
    composer install
    ```
3.  **Install frontend dependencies:**
    If a `package.json` file is present and used for managing frontend packages like SweetAlert2:
    ```bash
    npm install
    ```
4.  **Configure your web server:**
    Set up your web server (e.g., Apache, Nginx) to point its document root to the project's main public directory (this might be the root directory or a specific folder like `vistas/` or `public/`).
5.  **Set up the database:**
    a.  Create a new database in your database management system (e.g., `fuerzadeventa_db`).
    b.  Import the initial database schema. Look for a `.sql` file in the repository (e.g., `heavkfwj_gestion_tp.sql` if present) and import it into your newly created database.
    c.  Configure the database connection details. This is typically done in a configuration file, often found at a path like `modelos/conexion.php`. Update this file with your database host, name, username, and password.
6.  **Access the application:**
    Open your web browser and navigate to the URL configured for your web server (e.g., `http://localhost/FuerzaGestionApp` or your custom domain).

## Examples of Use

After successful installation, you can access FuerzaGestionApp through your web browser.
*   Manage passenger records via the 'Pasajeros' module.
*   Track vehicle units in the 'Unidades' section.
*   Record and view sales transactions under 'Ventas'.
(More specific examples and screenshots to be added as the project develops.)

## Contribution Guide

We welcome contributions to FuerzaGestionApp! Please follow these steps:
1.  Fork the repository.
2.  Create a new branch for your feature or fix:
    ```bash
    git checkout -b feature/YourAmazingFeature
    ```
    or
    ```bash
    git checkout -b fix/SomeBugFix
    ```
3.  Make your changes and ensure they adhere to the existing code style.
4.  Add tests for any new features or significant changes.
5.  Commit your changes with a clear and descriptive commit message:
    ```bash
    git commit -m 'Add some amazing feature'
    ```
6.  Push your changes to your forked repository's branch:
    ```bash
    git push origin feature/YourAmazingFeature
    ```
7.  Open a Pull Request against the main repository's `develop` or `main` branch.

Please ensure your code adheres to existing styling and that tests are added for new features.

## License Information

This project is licensed under the [Specify License Here] License - see the `LICENSE.md` file for details (to be created if not present).

## Contact Details

For questions, support, or to report issues, please contact [Your Name/Organization] at [your-email@example.com or link to the project's issue tracker].
