<?php

/**
 * Controller xác thực người dùng: Đăng ký - Đăng nhập - Đăng xuất.
 * Toàn bộ tài khoản lưu trong MySQL (bảng `users`), mật khẩu mã hoá bằng password_hash().
 */
class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // =========================================================
    // 1. ĐĂNG NHẬP (hỗ trợ đăng nhập bằng username hoặc email)
    // =========================================================
    public function login(): void
    {
        $redirectUrl = trim((string) ($_POST['redirect'] ?? $_GET['redirect'] ?? ''));

        if (is_logged_in()) {
            if ($redirectUrl !== '' && str_starts_with($redirectUrl, 'index.php')) {
                if (!is_admin() && str_contains($redirectUrl, 'action=admin')) {
                    redirect('index.php');
                }
                redirect($redirectUrl);
            }
            redirect(is_admin() ? 'index.php?action=admin' : 'index.php');
        }

        $error = null;
        $old = ['login' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old['login'] = trim((string) ($_POST['login'] ?? ''));
            $password     = (string) ($_POST['password'] ?? '');

            if (!csrf_verify()) {
                $error = 'Phiên làm việc đã hết hạn, vui lòng thử lại!';
            } elseif ($old['login'] === '' || $password === '') {
                $error = 'Vui lòng nhập đầy đủ tài khoản và mật khẩu!';
            } else {
                $user = $this->userModel->findByLogin($old['login']);

                if (!$user || !verify_password($password, $user['password'])) {
                    $error = 'Sai tài khoản hoặc mật khẩu!';
                } else {
                    // Chống tấn công cố định phiên (session fixation)
                    session_regenerate_id(true);

                    $_SESSION['user'] = [
                        'id'        => (int) $user['id'],
                        'full_name' => $user['full_name'],
                        'username'  => $user['username'],
                        'email'     => $user['email'],
                        'phone'     => $user['phone'],
                        'role'      => $user['role'],
                    ];

                    flash_set('success', 'Xin chào ' . $user['full_name'] . '! Bạn đã đăng nhập thành công.');

                    // Chuyển hướng người dùng về đúng trang mong muốn trước đó
                    $target = $redirectUrl;

                    // Nếu khách hàng đăng nhập mà URL yêu cầu là trang Admin -> chặn và chuyển về trang chủ
                    if ($user['role'] !== 'admin' && str_contains($target, 'action=admin')) {
                        flash_set('warning', 'Tài khoản khách hàng không có quyền truy cập trang Quản trị!');
                        $target = 'index.php';
                    }

                    // Nếu không có URL chuyển hướng hợp lệ, chuyển về Admin (nếu là admin) hoặc Trang chủ
                    if ($target === '' || !str_starts_with($target, 'index.php')) {
                        $target = ($user['role'] === 'admin') ? 'index.php?action=admin' : 'index.php';
                    }

                    redirect($target);
                }
            }
        }

        $title = 'Đăng nhập - TECH STORE';
        $view  = 'login';

        require_once PATH_VIEW . 'main.php';
    }

    // =========================================================
    // 2. ĐĂNG KÝ TÀI KHOẢN KHÁCH HÀNG
    // =========================================================
    public function register(): void
    {
        if (is_logged_in()) {
            redirect('index.php');
        }

        $error = null;
        $old   = [
            'full_name' => '',
            'username'  => '',
            'email'     => '',
            'phone'     => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = [
                'full_name' => trim((string) ($_POST['full_name'] ?? '')),
                'username'  => strtolower(trim((string) ($_POST['username'] ?? ''))),
                'email'     => strtolower(trim((string) ($_POST['email'] ?? ''))),
                'phone'     => trim((string) ($_POST['phone'] ?? '')),
            ];

            $password         = (string) ($_POST['password'] ?? '');
            $confirmPassword  = (string) ($_POST['confirm_password'] ?? '');
            $agree            = isset($_POST['agree']);

            if (!csrf_verify()) {
                $error = 'Phiên làm việc đã hết hạn, vui lòng thử lại!';
            } elseif (
                $old['full_name'] === '' || $old['username'] === '' ||
                $old['email'] === '' || $old['phone'] === '' ||
                $password === '' || $confirmPassword === ''
            ) {
                $error = 'Vui lòng nhập đầy đủ tất cả các trường!';
            } elseif (mb_strlen($old['full_name']) < 2) {
                $error = 'Họ và tên phải có ít nhất 2 ký tự!';
            } elseif (!preg_match('/^[a-z0-9_]{3,30}$/', $old['username'])) {
                $error = 'Tên đăng nhập chỉ gồm chữ không dấu, số, dấu gạch dưới và dài 3 - 30 ký tự!';
            } elseif (in_array($old['username'], ['admin', 'administrator', 'root'], true)) {
                $error = "Tên đăng nhập '{$old['username']}' là tài khoản quản trị hệ thống!";
            } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'Địa chỉ email không hợp lệ!';
            } elseif (!preg_match('/^0\d{9}$/', $old['phone'])) {
                $error = 'Số điện thoại phải bắt đầu bằng số 0 và gồm đúng 10 chữ số!';
            } elseif (mb_strlen($password) < 6) {
                $error = 'Mật khẩu phải có tối thiểu 6 ký tự!';
            } elseif ($password !== $confirmPassword) {
                $error = 'Mật khẩu nhập lại không trùng khớp!';
            } elseif (!$agree) {
                $error = 'Bạn cần đồng ý với điều khoản dịch vụ để tạo tài khoản!';
            } elseif ($this->userModel->findByUsername($old['username'])) {
                $error = "Tên đăng nhập \"{$old['username']}\" đã có người sử dụng!";
            } elseif ($this->userModel->findByEmail($old['email'])) {
                $error = "Địa chỉ email \"{$old['email']}\" đã được đăng ký tài khoản khác!";
            } else {
                try {
                    $this->userModel->create([
                        'full_name' => $old['full_name'],
                        'username'  => $old['username'],
                        'email'     => $old['email'],
                        'phone'     => $old['phone'],
                        'password'  => hash_password($password),
                        'role'      => 'customer',
                    ]);

                    flash_set('success', 'Đăng ký thành công! Vui lòng đăng nhập bằng tài khoản vừa tạo.');
                    $redirectTarget = trim((string) ($_POST['redirect'] ?? $_GET['redirect'] ?? ''));
                    $loginTarget = 'index.php?action=login';
                    if ($redirectTarget !== '' && str_starts_with($redirectTarget, 'index.php')) {
                        $loginTarget .= '&redirect=' . urlencode($redirectTarget);
                    }
                    redirect($loginTarget);
                } catch (PDOException $e) {
                    // Vi phạm ràng buộc UNIQUE (username/email vừa bị người khác đăng ký)
                    $error = ((int) $e->getCode() === 23000)
                        ? 'Tên đăng nhập hoặc email đã được sử dụng, vui lòng chọn thông tin khác!'
                        : 'Không thể tạo tài khoản lúc này. Vui lòng thử lại sau!';
                }
            }
        }

        $title = 'Đăng ký tài khoản - TECH STORE';
        $view  = 'register';

        require_once PATH_VIEW . 'main.php';
    }

    // =========================================================
    // 3. ĐĂNG XUẤT
    // =========================================================
    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
            redirect('index.php');
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        session_start();

        // Xóa hoàn toàn cache để ngăn chặn việc bấm nút Back trình duyệt quay lại trang cần đăng nhập
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        flash_set('success', 'Bạn đã đăng xuất khỏi hệ thống thành công.');
        redirect('index.php?action=login');
    }
}
