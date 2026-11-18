<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TECH STORE - Siêu Thị Đồ Công Nghệ Chính Hãng' ?></title>

    <!-- Token CSRF dùng cho các request POST (đăng xuất...) -->
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">

    <!-- 1. Phông chữ hiện đại Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- 2. Thư viện biểu tượng Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- 3. Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 4. File CSS tùy biến chính của TECH STORE -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php
$isAdminPage  = (isset($view) && $view === 'admin');
$authUser     = current_user();
$isAdminUser  = ($authUser['role'] ?? '') === 'admin';
$authName     = $authUser['full_name'] ?? ($authUser['username'] ?? 'Khách');
?>

<?php if ($isAdminPage): ?>
    <!-- ========================================================= -->
    <!-- GIAO DIỆN CHUYÊN BIỆT DÀNH CHO TRANG QUẢN TRỊ ADMIN -->
    <!-- ========================================================= -->
    <?php require_once PATH_VIEW . 'admin.php'; ?>

<?php else: ?>
    <!-- ========================================================= -->
    <!-- GIAO DIỆN DÀNH CHO KHÁCH HÀNG (TRANG CHỦ, ĐĂNG NHẬP, ĐĂNG KÝ) -->
    <!-- ========================================================= -->

    <!-- PHẦN 1: THANH THÔNG TIN TRÊN CÙNG (TOP BAR) -->
    <div class="top-bar d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="me-3"><i class="fa-solid fa-phone me-1 text-primary"></i> Hotline: <b>1800.6868</b> (Miễn phí)</span>
                <span><i class="fa-solid fa-location-dot me-1 text-primary"></i> Hệ thống 50 Showroom toàn quốc</span>
            </div>
            <div class="d-flex gap-3">
                <a href="javascript:void(0)"><i class="fa-solid fa-shield-heart me-1"></i> Chính sách bảo hành</a>
                <a href="javascript:void(0)"><i class="fa-solid fa-headset me-1"></i> Hỗ trợ kỹ thuật 24/7</a>
            </div>
        </div>
    </div>

    <!-- PHẦN 2: HEADER CHÍNH (LOGO, TÌM KIẾM, GIỎ HÀNG, TÀI KHOẢN) -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <!-- 2.1. Logo TECH STORE -->
                <div class="col-6 col-lg-3">
                    <a href="index.php" class="brand-logo text-decoration-none">
                        <div class="logo-icon">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <div>
                            <span>TECH<span class="brand-highlight">STORE</span></span>
                            <div style="font-size: 0.65rem; font-weight: 500; color: #64748b; letter-spacing: 1px; text-transform: uppercase;">World of Tech</div>
                        </div>
                    </a>
                </div>

                <!-- 2.2. Thanh tìm kiếm sản phẩm -->
                <div class="col-12 col-lg-5 order-3 order-lg-2 mt-2 mt-lg-0">
                    <form id="searchForm" class="search-wrapper mx-auto">
                        <input type="text" 
                               id="searchInput" 
                               class="form-control search-input" 
                               placeholder="Tìm kiếm iPhone, MacBook, Laptop ASUS, Dell..." 
                               autocomplete="off">
                        <button type="submit" class="search-btn" title="Tìm kiếm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <!-- 2.3. Khu vực Giỏ hàng và Tài khoản Đăng nhập / Đăng xuất -->
                <div class="col-6 col-lg-4 order-2 order-lg-3 d-flex justify-content-end align-items-center gap-2">
                    
                    <!-- Nút Giỏ Hàng -->
                    <button type="button" class="header-action-btn cart-btn" data-bs-toggle="modal" data-bs-target="#cartModal" title="Xem giỏ hàng">
                        <i class="fa-solid fa-cart-shopping fa-lg"></i>
                        <span class="d-none d-sm-inline">Giỏ hàng</span>
                        <span id="cartBadgeCount" class="cart-badge" style="display: none;">0</span>
                    </button>

                    <!-- Khối hiển thị khi CHƯA đăng nhập -->
                    <div id="authGuestBox" class="auth-guest-box" style="<?= $authUser ? 'display: none;' : 'display: flex;' ?>">
                        <a href="index.php?action=login" class="header-action-btn btn-login-nav">
                            <i class="fa-regular fa-user fa-lg text-primary"></i>
                            <span>Đăng nhập</span>
                        </a>
                    </div>

                    <!-- Khối hiển thị khi ĐÃ đăng nhập (Admin hoặc Khách hàng) -->
                    <div id="authUserBox" class="user-info-box" style="<?= $authUser ? 'display: flex;' : 'display: none;' ?>">
                        <div class="dropdown">
                            <button class="header-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid <?= $isAdminUser ? 'fa-user-shield' : 'fa-circle-user' ?> text-primary" id="authUserIcon"></i>
                                <span id="authUserName"><?= e($authName) ?></span>
                                <span class="<?= $isAdminUser ? 'admin-badge' : 'customer-badge' ?> ms-1" id="authUserBadge"><?= $isAdminUser ? 'ADMIN' : 'KHÁCH HÀNG' ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <h6 class="dropdown-header text-uppercase" id="authDropdownHeader"><?= $isAdminUser ? 'Bảng điều khiển' : 'Tài khoản của tôi' ?></h6>
                                </li>
                                <li id="adminDashboardLink" style="<?= $isAdminUser ? '' : 'display: none;' ?>">
                                    <a class="dropdown-item py-2" href="index.php?action=admin">
                                        <i class="fa-solid fa-gauge-high text-primary me-2"></i> Trang quản trị Admin
                                    </a>
                                </li>
                                <?php if ($authUser && !$isAdminUser): ?>
                                    <li>
                                        <button class="dropdown-item py-2" type="button" data-bs-toggle="modal" data-bs-target="#orderHistoryModal" onclick="renderOrderHistory()">
                                            <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Lịch sử đơn hàng
                                        </button>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item py-2" href="index.php">
                                        <i class="fa-solid fa-store text-success me-2"></i> Xem trang bán hàng
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item py-2 text-danger" type="button" onclick="handleLogout()">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <!-- PHẦN 3: MENU ĐIỀU HƯỚNG CHÍNH (NAVBAR) -->
    <nav class="navbar navbar-expand-lg main-nav p-0">
        <div class="container">
            <!-- Nút bật menu trên điện thoại -->
            <button class="navbar-toggler text-white border-0 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#techStoreNav">
                <i class="fa-solid fa-bars fa-lg"></i> <span class="small ms-2">Danh mục sản phẩm</span>
            </button>

            <!-- Danh sách menu điều hướng -->
            <div class="collapse navbar-collapse" id="techStoreNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= (!isset($_GET['action']) || $_GET['action'] == '/') ? 'active' : '' ?>" href="index.php">
                            <i class="fa-solid fa-house"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" onclick="filterCategory('phone'); return false;">
                            <i class="fa-solid fa-mobile-screen-button"></i> Điện thoại
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" onclick="filterCategory('laptop'); return false;">
                            <i class="fa-solid fa-laptop"></i> Laptop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" onclick="filterCategory('tablet'); return false;">
                            <i class="fa-solid fa-tablet-screen-button"></i> Máy tính bảng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" onclick="filterCategory('accessory'); return false;">
                            <i class="fa-solid fa-headphones"></i> Phụ kiện
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hot-deal" href="index.php" onclick="filterCategory('promo'); return false;">
                            <i class="fa-solid fa-bolt"></i> Khuyến mãi HOT
                        </a>
                    </li>
                    <!-- Menu Quản trị chỉ hiển thị khi đã đăng nhập Admin -->
                    <li class="nav-item" id="adminNavLink" style="<?= $isAdminUser ? 'display: block;' : 'display: none;' ?>">
                        <a class="nav-link text-warning fw-bold" href="index.php?action=admin">
                            <i class="fa-solid fa-gear"></i> Quản trị hệ thống
                        </a>
                    </li>
                </ul>

                <!-- Hotline hỗ trợ nhanh bên phải menu -->
                <div class="d-none d-xl-flex align-items-center text-white small">
                    <i class="fa-solid fa-truck-fast text-warning me-2 fa-lg"></i>
                    <span>Giao hàng siêu tốc <b>2 Giờ</b></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- PHẦN 4: NỘI DUNG CHÍNH (VIEW CONTENT) -->
    <main>
        <?php
        if (isset($view)) {
            require_once PATH_VIEW . $view . '.php';
        }
        ?>
    </main>

    <!-- PHẦN 5: FOOTER CHÂN TRANG CHO KHÁCH HÀNG -->
    <footer class="main-footer">
        <div class="container">
            <div class="row g-4">
                <!-- Cột 1: Giới thiệu cửa hàng -->
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="index.php" class="footer-brand text-decoration-none">
                        TECH<span>STORE</span>
                    </a>
                    <p class="footer-desc">
                        TECH STORE là chuỗi bán lẻ thiết bị công nghệ hàng đầu, chuyên cung cấp điện thoại thông minh, laptop, máy tính bảng và phụ kiện chính hãng với giá tốt nhất thị trường.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="javascript:void(0)" class="btn btn-outline-light btn-sm rounded-circle" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="javascript:void(0)" class="btn btn-outline-light btn-sm rounded-circle" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-youtube"></i></a>
                        <a href="javascript:void(0)" class="btn btn-outline-light btn-sm rounded-circle" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Cột 2: Danh mục sản phẩm -->
                <div class="col-6 col-md-6 col-lg-2">
                    <h5 class="footer-title">Danh mục</h5>
                    <ul class="footer-links">
                        <li><a href="javascript:void(0)" onclick="filterCategory('phone')"><i class="fa-solid fa-angle-right"></i> Điện thoại</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCategory('laptop')"><i class="fa-solid fa-angle-right"></i> Laptop</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCategory('tablet')"><i class="fa-solid fa-angle-right"></i> Máy tính bảng</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCategory('accessory')"><i class="fa-solid fa-angle-right"></i> Phụ kiện cao cấp</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCategory('promo')"><i class="fa-solid fa-angle-right"></i> Khuyến mãi sốc</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Chính sách khách hàng -->
                <div class="col-6 col-md-6 col-lg-3">
                    <h5 class="footer-title">Chính sách & Hỗ trợ</h5>
                    <ul class="footer-links">
                        <li><a href="javascript:void(0)"><i class="fa-solid fa-angle-right"></i> Chính sách bảo hành 12 tháng</a></li>
                        <li><a href="javascript:void(0)"><i class="fa-solid fa-angle-right"></i> Chính sách đổi trả 1 - 1</a></li>
                        <li><a href="javascript:void(0)"><i class="fa-solid fa-angle-right"></i> Hướng dẫn mua hàng trả góp 0%</a></li>
                        <li><a href="javascript:void(0)"><i class="fa-solid fa-angle-right"></i> Vận chuyển & Giao nhận hàng</a></li>
                        <li><a href="javascript:void(0)"><i class="fa-solid fa-angle-right"></i> Bảo mật thông tin khách hàng</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Thông tin liên hệ và địa chỉ -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 class="footer-title">Thông tin liên hệ</h5>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Địa chỉ: Tòa nhà FPT Polytechnic, Phố Trịnh Văn Bô, Nam Từ Liêm, Hà Nội</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>Tổng đài tư vấn: <b>1800 6868</b> (8:00 - 21:30)</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Email liên hệ: <b>contact@techstore.vn</b></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-clock"></i>
                        <span>Thời gian mở cửa: 08:00 - 22:00 hàng ngày</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bản quyền cuối trang -->
        <div class="footer-bottom text-center">
            <div class="container">
                <p class="mb-0">
                    © 2026 <b>TECH STORE</b> - Dự án thực hành thiết kế Website Bán Hàng Công Nghệ Front-End. Giữ toàn quyền.
                </p>
            </div>
        </div>
    </footer>

<?php endif; ?>

    <!-- ========================================================= -->
    <!-- PHẦN 6: CÁC MODAL & TOAST TIỆN ÍCH -->
    <!-- ========================================================= -->

    <!-- Modal 1: Chi tiết sản phẩm & Chọn phiên bản biến thể -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="productDetailModalLabel">
                        <i class="fa-solid fa-mobile-screen-button text-primary me-2"></i>Chi Tiết Sản Phẩm & Chọn Phiên Bản
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-4" id="productDetailModalBody">
                    <!-- Nội dung chi tiết sản phẩm được JavaScript điền tự động vào đây -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Giỏ hàng & Phiên bản đã chọn -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="cartModalLabel">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Giỏ Hàng Của Bạn (Chi Tiết Từng Phiên Bản)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-3" id="cartItemsContainer" style="max-height: 450px; overflow-y: auto;">
                    <!-- Danh sách sản phẩm trong giỏ được JavaScript render vào đây -->
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center" id="cartActionFooter">
                    <div>
                        <span class="small text-muted d-block">Tổng tiền thanh toán:</span>
                        <span class="h4 fw-bold text-danger mb-0" id="cartTotalPrice">0 ₫</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearCart()">
                            <i class="fa-regular fa-trash-can me-1"></i> Xóa hết
                        </button>
                        <button type="button" class="btn btn-primary btn-sm px-4 fw-bold" onclick="handleCheckoutDemo()">
                            <i class="fa-solid fa-credit-card me-1"></i> Đặt hàng ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($authUser && !$isAdminUser): ?>
    <div class="modal fade" id="orderHistoryModal" tabindex="-1" aria-labelledby="orderHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="orderHistoryModalLabel"><i class="fa-solid fa-clock-rotate-left me-2"></i>Lịch sử đơn hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-3" id="orderHistoryContent"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Toast thông báo góc màn hình -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
        <div id="notificationToast" class="toast align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2">
                <div class="toast-body d-flex align-items-center">
                    <i id="toastIcon" class="fa-solid fa-circle-check text-success fa-lg me-2"></i>
                    <div>
                        <strong id="toastHeaderTitle" class="d-block small">Thông báo</strong>
                        <span id="toastMessage" class="small">Thao tác thành công!</span>
                    </div>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- PHẦN 7: NHÚNG CÁC TẬP TIN JAVASCRIPT -->
    <!-- ========================================================= -->
    <!-- Bootstrap 5.3.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Trạng thái đăng nhập do PHP (session MySQL) truyền sang JavaScript -->
    <script>
        window.CURRENT_USER = <?php
            $jsUser = $authUser ? [
                'id'       => (int) $authUser['id'],
                'fullName' => $authName,
                'username' => $authUser['username'],
                'email'    => $authUser['email'],
                'phone'    => $authUser['phone'],
                'role'     => $authUser['role'],
            ] : null;

            echo json_encode(
                $jsUser,
                JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
            ) ?: 'null';
        ?>;
    </script>

    <!-- File JavaScript chính điều khiển toàn bộ chức năng -->
    <script src="assets/js/main.js"></script>

</body>

</html>
