<?php
// Secure Session Initialization
if (session_status() === PHP_SESSION_NONE) {
    // Set cookie path to root to ensure sessions persist across subdirectories (/auth, /admin, etc)
    session_set_cookie_params([
        'path' => '/NexPLAY/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// Global root path helper
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}
?>
