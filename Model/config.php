<?php
// Model/config.php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cameravn');

// Base URL of the website
define('BASE_URL', 'http://localhost/midTerm/');

// Default controller and method
define('DEFAULT_CONTROLLER', 'Home');
define('DEFAULT_METHOD', 'index');

// Admin email
define('ADMIN_EMAIL', 'admin@cameravn.com');

// Payment gateway API keys (example)
define('PAYMENT_API_KEY', 'your_payment_api_key');
define('PAYMENT_SECRET_KEY', 'your_payment_secret_key');

// Email configuration
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your_email@example.com');
define('SMTP_PASS', 'your_email_password');
define('SMTP_FROM', 'no-reply@cameravn.com');
define('SMTP_FROM_NAME', 'CameraVN');

// File upload paths
define('UPLOAD_PATH', 'View/assets/images/uploads/');
define('PRODUCT_IMG_PATH', UPLOAD_PATH . 'products/');
define('USER_IMG_PATH', UPLOAD_PATH . 'users/');
define('REVIEW_IMG_PATH', UPLOAD_PATH . 'reviews/');

// Session settings
define('SESSION_LIFETIME', 7200);