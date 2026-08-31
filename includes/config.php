<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'theleadschool');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Site Configuration
define('SITE_NAME', 'Leads School System');
define('SITE_URL', 'http://localhost/theleadschoolshahpur/');
define('ADMIN_EMAIL', 'myleadsshahpursadar@gmail.com');
define('SITE_LOCATION', 'Jail Road Gujjar Colony, Sargodha, Pakistan, 40100');
define('SITE_CONTACT', '0302 6000031');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include settings helper functions
require_once __DIR__ . '/settings_helper.php';

// Include theme helper functions
require_once __DIR__ . '/theme_helper.php';
?>
