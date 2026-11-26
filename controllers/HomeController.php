<?php

/**
 * Controller chính xử lý điều hướng các trang
 * Phù hợp bài thực hành Front-End kết hợp MVC PHP cơ bản
 */
class HomeController
{
    // 1. Trang chủ TECH STORE
    public function index()
    {
        $title = 'TECH STORE - Siêu Thị Đồ Công Nghệ Chính Hãng';
        $view = 'home';
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Trang quản trị hệ thống dành cho Admin (bắt buộc đăng nhập quyền admin)
    public function admin()
    {
        if (!is_admin()) {
            flash_set('error', 'Bạn cần đăng nhập bằng tài khoản Admin để truy cập trang quản trị!');
            redirect('index.php?action=login');
        }

        // Danh sách khách hàng thật từ MySQL để hiển thị ở tab "Quản lý khách hàng"
        $customers = array_map(static function (array $user): array {
            return [
                'fullName'  => $user['full_name'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'phone'     => $user['phone'],
                'createdAt' => $user['created_at'],
            ];
        }, (new UserModel)->allCustomers());

        $title = 'Trang Quản Trị Hệ Thống - TECH STORE';
        $view = 'admin';
        require_once PATH_VIEW . 'main.php';
    }

    // 3. Trang thanh toán Shopee (Shopee Checkout)
    public function checkout()
    {
        $title = 'Thanh Toán - TECH STORE';
        $view = 'checkout';
        require_once PATH_VIEW . 'main.php';
    }

    // 4. Chuyển hướng về trang thanh toán chính
    public function checkoutConfirm()
    {
        header('Location: index.php?action=checkout');
        exit;
    }
}
