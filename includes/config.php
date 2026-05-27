<?php
/**
 * Database Configuration
 * Update these values based on your MAMP/Server setup
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'otoku_circle');
define('DB_USER', 'root');
define('DB_PASS', 'root'); // Default MAMP password is 'root'

// Application settings
define('APP_NAME', 'Otoku Circle');
define('APP_URL', 'http://localhost:8888'); // Adjust port if needed

// Upload settings
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Session settings
define('SESSION_LIFETIME', 3600); // 1 hour

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
