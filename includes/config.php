<?php
// ============================================================================
// Database Configuration — auto-detects localhost vs. the live cPanel server
// from the request host, so this SAME file works in both places with no
// manual editing when moving between environments.
// ============================================================================
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

// Strip a port suffix (e.g. "localhost:8080" -> "localhost", "[::1]:8080" -> "::1")
// before comparing, without mangling a bare IPv6 address like "::1" — a naive
// ":digits at the end" strip would incorrectly turn "::1" into ":".
if (preg_match('/^\[(.+)\](:\d+)?$/', $host, $m)) {
    $hostWithoutPort = $m[1];                 // bracketed IPv6, e.g. [::1]:8080
} elseif (substr_count($host, ':') === 1) {
    $hostWithoutPort = preg_replace('/:\d+$/', '', $host); // plain host:port
} else {
    $hostWithoutPort = $host;                 // bare hostname or bare IPv6 (::1)
}

$isLocalhost = in_array($hostWithoutPort, ['localhost', '127.0.0.1', '::1'], true)
    || php_sapi_name() === 'cli'; // CLI scripts (migrations, one-off admin scripts) have no HTTP_HOST at all

if ($isLocalhost) {
    // ---- Local development (XAMPP) ----
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'theleadschool');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // ---- Live cPanel / production ----
    // IMPORTANT: replace these three placeholders with the real cPanel
    // database name/username/password before deploying. cPanel typically
    // prefixes both the DB name and username with your account name
    // (e.g. accountname_theleadschool) — enter them exactly as cPanel shows
    // them, do not add another prefix on top.
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'theleads_schoolsystem');
    define('DB_USER', 'theleads_schoolshahpur');

    // The real live password must never be committed to git (see .gitignore).
    // includes/db_credentials.php is created ONCE, directly on the server via
    // cPanel File Manager (never through git), and defines DB_PASS with the
    // real value — see includes/db_credentials.sample.php for the format.
    // Until that file exists, DB_PASS falls back to the visible placeholder
    // below purely so the constant is always defined.
    if (file_exists(__DIR__ . '/db_credentials.php')) {
        require __DIR__ . '/db_credentials.php';
    } else {
        define('DB_PASS', 'PUT_YOUR_LIVE_CPANEL_DATABASE_PASSWORD');
    }
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
define('SITE_NAME', 'Leads School System Shahpur');
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
