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

// Khởi tạo kết nối PDO
global $db; // Khai báo biến $db là global
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    // Ghi log lỗi hoặc xử lý theo cách phù hợp
    error_log("Lỗi kết nối database: " . $e->getMessage());
    // Tùy chọn: hiển thị lỗi cho admin hoặc chuyển hướng đến trang lỗi
    // die("Lỗi kết nối database.");
}