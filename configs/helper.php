<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('e')) {
    // Escape dữ liệu trước khi in ra HTML (chống XSS)
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void
    {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        }
        echo '<script>window.location.href = ' . json_encode($url) . ';</script>';
        exit;
    }
}

if (!function_exists('current_user')) {
    // Thông tin người dùng đang đăng nhập (lưu trong session sau khi xác thực MySQL)
    function current_user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return !empty($_SESSION['user']);
    }
}

if (!function_exists('is_admin')) {
    function is_admin(): bool
    {
        return (current_user()['role'] ?? '') === 'admin';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf'];
    }
}

if (!function_exists('csrf_field')) {
    // In thẻ hidden chứa token vào form
    function csrf_field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify(): bool
    {
        $token = $_POST['_csrf'] ?? '';

        return is_string($token)
            && !empty($_SESSION['_csrf'])
            && hash_equals($_SESSION['_csrf'], $token);
    }
}

if (!function_exists('flash_set')) {
    // Ghi thông báo dùng một lần (hiển thị sau khi redirect)
    function flash_set(string $type, string $message): void
    {
        $_SESSION['_flash'] = ['type' => $type, 'message' => $message];
    }
}

if (!function_exists('flash_get')) {
    function flash_get(): ?array
    {
        if (empty($_SESSION['_flash'])) {
            return null;
        }

        $flash = $_SESSION['_flash'];
        unset($_SESSION['_flash']);

        return $flash;
    }
}

if (!function_exists('hash_password')) {
    // Mã hoá mật khẩu theo chế độ PASSWORD_MODE trong configs/env.php
    function hash_password(string $plainPassword): string
    {
        if (defined('PASSWORD_MODE') && PASSWORD_MODE === 'hash') {
            return password_hash($plainPassword, PASSWORD_DEFAULT);
        }

        // Chế độ 'plain': lưu nguyên văn để dễ quan sát trong MySQL (chỉ dùng cho demo/học tập)
        return $plainPassword;
    }
}

if (!function_exists('verify_password')) {
    // Kiểm tra mật khẩu nhập vào với dữ liệu đang lưu trong MySQL.
    // Hỗ trợ cả tài khoản cũ đã lưu hash và tài khoản mới lưu chữ thường.
    function verify_password(string $plainPassword, string $storedPassword): bool
    {
        if (password_verify($plainPassword, $storedPassword)) {
            return true;
        }

        return hash_equals($storedPassword, $plainPassword);
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        $targetFile = $folder . '/' . time() . '-' . $file["name"];

        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}
