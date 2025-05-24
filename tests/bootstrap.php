<?php
// tests/bootstrap.php

// Define a constant to signal a testing environment.
// This is more reliable for code loaded early in the bootstrap process.
if (!defined('PHPUNIT_TESTING')) {
    define('PHPUNIT_TESTING', true);
}

// Include Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// You can include other global test setup tasks here if needed.
?>
