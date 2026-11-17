<?php

// Tự động nhận diện BASE_URL linh hoạt theo môi trường đang chạy (Laragon / Localhost / PHP server)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseUrl = rtrim($protocol . $host . $scriptDir, '/') . '/';

define('BASE_URL',          $baseUrl);

define('PATH_ROOT',         __DIR__ . '/../');

define('PATH_VIEW',         PATH_ROOT . 'views/');

define('PATH_VIEW_MAIN',    PATH_ROOT . 'views/main.php');

define('BASE_ASSETS_UPLOADS',   BASE_URL . 'assets/uploads/');

define('PATH_ASSETS_UPLOADS',   PATH_ROOT . 'assets/uploads/');

define('PATH_CONTROLLER',       PATH_ROOT . 'controllers/');

define('PATH_MODEL',            PATH_ROOT . 'models/');

define('DB_HOST',     'localhost');
define('DB_PORT',     '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
// Tên CSDL MySQL (đổi tại đây nếu CSDL của bạn có tên khác)
define('DB_NAME',     'hhta');

// Chế độ lưu mật khẩu:
//   'plain' -> lưu chữ/số bình thường trong MySQL (dễ xem, CHỈ dùng cho học tập/demo)
//   'hash'  -> mã hoá bcrypt (an toàn, khuyên dùng khi chạy thật)
define('PASSWORD_MODE', 'plain');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
