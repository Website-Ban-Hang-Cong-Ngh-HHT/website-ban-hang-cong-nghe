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
        // 1. Kiểm tra đăng nhập
        if (!is_logged_in()) {
            flash_set('error', 'Vui lòng đăng nhập tài khoản Admin để truy cập trang quản trị!');
            redirect('index.php?action=login&redirect=' . urlencode('index.php?action=admin') . '&msg=' . urlencode('Vui lòng đăng nhập tài khoản Admin để truy cập trang quản trị!'));
            exit;
        }

        // 2. Kiểm tra phân quyền Admin (khách hàng không được phép truy cập)
        if (!is_admin()) {
            flash_set('error', 'Cảnh báo: Bạn không có quyền truy cập trang Quản trị! Chức năng này chỉ dành riêng cho Admin.');
            redirect('index.php');
            exit;
        }

        // Chống lưu bộ nhớ đệm (Cache) để khi đăng xuất không thể back lại bằng nút quay lại trình duyệt
        if (!headers_sent()) {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
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

    // 3. Trang thanh toán Shopee (Shopee Checkout) - Bắt buộc đăng nhập
    public function checkout()
    {
        // Kiểm tra bắt buộc đăng nhập đối với khách hàng
        if (!is_logged_in()) {
            flash_set('error', 'Vui lòng đăng nhập để sử dụng chức năng thanh toán đơn hàng!');
            redirect('index.php?action=login&redirect=' . urlencode('index.php?action=checkout') . '&msg=' . urlencode('Vui lòng đăng nhập để sử dụng chức năng thanh toán đơn hàng!'));
            exit;
        }

        // Chống lưu bộ nhớ đệm
        if (!headers_sent()) {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

        $title = 'Thanh Toán - TECH STORE';
        $view = 'checkout';
        require_once PATH_VIEW . 'main.php';
    }

    // 4. Chuyển hướng về trang thanh toán chính
    public function checkoutConfirm()
    {
        if (!is_logged_in()) {
            flash_set('error', 'Vui lòng đăng nhập để thanh toán đơn hàng!');
            redirect('index.php?action=login&redirect=' . urlencode('index.php?action=checkout') . '&msg=' . urlencode('Vui lòng đăng nhập để thanh toán đơn hàng!'));
            exit;
        }
        if (!headers_sent()) {
            header('Location: index.php?action=checkout');
            exit;
        }
        echo '<script>window.location.href = "index.php?action=checkout";</script>';
        exit;
    }

    // 5. Trang theo dõi giao hàng dành cho khách hàng - Bắt buộc đăng nhập
    public function orderTracking()
    {
        // 1. Kiểm tra đăng nhập bắt buộc
        if (!is_logged_in()) {
            $redirectTarget = 'index.php?action=order-tracking';
            if (!empty($_GET['id'])) {
                $redirectTarget .= '&id=' . urlencode($_GET['id']);
            }
            flash_set('error', 'Vui lòng đăng nhập để theo dõi tình trạng giao hàng!');
            redirect('index.php?action=login&redirect=' . urlencode($redirectTarget) . '&msg=' . urlencode('Vui lòng đăng nhập để theo dõi tình trạng giao hàng!'));
            exit;
        }

        // 2. Chống lưu cache trình duyệt
        if (!headers_sent()) {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

        $title = 'Theo Dõi Giao Hàng - TECH STORE';
        $view = 'order_tracking';
        require_once PATH_VIEW . 'main.php';
    }
}
