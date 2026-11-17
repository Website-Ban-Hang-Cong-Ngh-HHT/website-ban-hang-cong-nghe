<?php

/**
 * Công cụ tạo hash mật khẩu để dùng trong MySQL.
 *
 * Cách dùng (chạy bằng PHP CLI):
 *   C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe tools\hash-password.php "matkhau123"
 *
 * Sau đó copy chuỗi $2y$10$... vào cột `password` của bảng `users`
 * (KHÔNG bao giờ lưu mật khẩu dạng chữ thường trong MySQL).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Công cụ này chỉ chạy được bằng dòng lệnh (CLI).');
}

$plainPassword = $argv[1] ?? '';

if ($plainPassword === '') {
    echo "Cách dùng: php tools/hash-password.php \"mat-khau-can-ma-hoa\"" . PHP_EOL;
    exit(1);
}

echo password_hash($plainPassword, PASSWORD_DEFAULT) . PHP_EOL;
