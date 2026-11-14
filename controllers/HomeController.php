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

    // 2. Trang đăng nhập tài khoản (Admin demo)
    public function login()
    {
        $title = 'Đăng nhập - TECH STORE';
        $view = 'login';
        require_once PATH_VIEW . 'main.php';
    }

    // 3. Trang đăng ký tài khoản khách hàng mới
    public function register()
    {
        $title = 'Đăng ký tài khoản - TECH STORE';
        $view = 'register';
        require_once PATH_VIEW . 'main.php';
    }

    // 4. Trang quản trị hệ thống dành cho Admin
    public function admin()
    {
        $title = 'Trang Quản Trị Hệ Thống - TECH STORE';
        $view = 'admin';
        require_once PATH_VIEW . 'main.php';
    }
}