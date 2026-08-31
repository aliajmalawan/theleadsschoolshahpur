<?php
// Database Configuration
// DB_HOST / DB_USER / DB_NAME are the same on localhost and the live server,
// so they're safe to commit here as-is.
define('DB_HOST', 'localhost');
define('DB_USER', 'theleads_schoolshahpur');
define('DB_NAME', 'theleads_schoolsystem');

// The real password only differs on the live server, and must never be
// committed to git. If includes/db_credentials.php exists (created once,
// directly on the server, and listed in .gitignore) it defines DB_PASS with
// the real value and is never touched by `git pull`. Locally, where that
// file doesn't exist, DB_PASS falls back to XAMPP's default empty password.
if (file_exists(__DIR__ . '/db_credentials.php')) {
    require __DIR__ . '/db_credentials.php';
} else {
    define('DB_PASS', '');
}

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
