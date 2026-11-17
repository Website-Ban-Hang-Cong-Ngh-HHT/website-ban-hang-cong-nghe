<!-- ========================================================================== -->
<!-- TECH STORE - GIAO DIỆN QUẢN TRỊ ADMIN CHUYÊN NGHIỆP (ADMIN DASHBOARD)      -->
<!-- Bố cục chuẩn E-commerce: Sidebar cố định bên trái, Header Admin, 10 Tabs   -->
<!-- ========================================================================== -->

<div class="admin-layout-wrapper">

    <!-- Lớp phủ mờ trên màn hình Mobile khi mở Sidebar -->
    <div class="admin-backdrop" id="adminBackdrop" onclick="toggleAdminSidebar()"></div>

    <!-- ========================================================= -->
    <!-- 1. THANH MENU BÊN TRÁI (SIDEBAR CỐ ĐỊNH)                  -->
    <!-- ========================================================= -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Logo thương hiệu Admin -->
        <div class="admin-sidebar-header">
            <a href="index.php?action=admin" class="admin-sidebar-brand">
                <div class="admin-brand-icon">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <div>
                    <div>TECH<span class="text-primary">STORE</span></div>
                    <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 600; letter-spacing: 1px;">ADMIN PORTAL</div>
                </div>
            </a>
            <button class="btn btn-sm text-white d-lg-none p-0" onclick="toggleAdminSidebar()">
                <i class="fa-solid fa-xmark fs-5"></i>
            </button>
        </div>

        <!-- Danh sách các mục điều hướng (10 mục theo yêu cầu) -->
        <div class="admin-sidebar-menu">
            <div class="admin-menu-heading">Bảng Điều Khiển</div>
            <a class="admin-nav-item active" onclick="switchAdminTab('dashboard')" id="nav-dashboard">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Tổng quan Dashboard</span>
            </a>

            <div class="admin-menu-heading">Quản Lý Kinh Doanh</div>
            <a class="admin-nav-item" onclick="switchAdminTab('products')" id="nav-products">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Quản lý sản phẩm</span>
                <span class="badge bg-primary admin-nav-badge" id="sidebarProductCount">16</span>
            </a>
            <a class="admin-nav-item" onclick="switchAdminTab('categories')" id="nav-categories">
                <i class="fa-solid fa-shapes"></i>
                <span>Quản lý danh mục</span>
            </a>
            <a class="admin-nav-item" onclick="switchAdminTab('orders')" id="nav-orders">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Quản lý đơn hàng</span>
                <span class="badge bg-warning text-dark admin-nav-badge">Mới</span>
            </a>
            <a class="admin-nav-item" onclick="switchAdminTab('customers')" id="nav-customers">
                <i class="fa-solid fa-users"></i>
                <span>Quản lý khách hàng</span>
            </a>
            <a class="admin-nav-item" onclick="switchAdminTab('accounts')" id="nav-accounts">
                <i class="fa-solid fa-user-shield"></i>
                <span>Quản lý tài khoản</span>
            </a>

            <div class="admin-menu-heading">Tiếp Thị & Chăm Sóc</div>
            <a class="admin-nav-item" onclick="switchAdminTab('coupons')" id="nav-coupons">
                <i class="fa-solid fa-ticket"></i>
                <span>Quản lý mã giảm giá</span>
            </a>
            <a class="admin-nav-item" onclick="switchAdminTab('comments')" id="nav-comments">
                <i class="fa-solid fa-comments"></i>
                <span>Quản lý bình luận</span>
            </a>
            <a class="admin-nav-item" onclick="switchAdminTab('analytics')" id="nav-analytics">
                <i class="fa-solid fa-chart-line"></i>
                <span>Doanh thu & Thống kê</span>
            </a>

            <div class="admin-menu-heading">Cấu Hình</div>
            <a class="admin-nav-item" onclick="switchAdminTab('settings')" id="nav-settings">
                <i class="fa-solid fa-sliders"></i>
                <span>Cài đặt hệ thống</span>
            </a>
        </div>

        <!-- Chân Sidebar: Nút Đăng xuất -->
        <div class="admin-sidebar-footer">
            <button class="admin-logout-btn" onclick="handleLogout()">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Đăng xuất hệ thống</span>
            </button>
        </div>
    </aside>

    <!-- ========================================================= -->
    <!-- 2. VÙNG NỘI DUNG CHÍNH (MAIN CONTENT AREA)                -->
    <!-- ========================================================= -->
    <div class="admin-main-area">

        <!-- HEADER ADMIN TRÊN CÙNG (TOPBAR) -->
        <header class="admin-topbar">
            <!-- Nút bật menu trên điện thoại & Ô tìm kiếm -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" onclick="toggleAdminSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="admin-search-box d-none d-sm-block">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="admin-search-input" id="adminGlobalSearch" placeholder="Tìm kiếm dữ liệu admin..." oninput="handleAdminGlobalSearch(this.value)">
                </div>
            </div>

            <!-- Các hành động góc phải Header Admin -->
            <div class="admin-topbar-actions">
                <!-- Nút Xem Website bán hàng -->
                <a href="index.php" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                    <i class="fa-solid fa-store me-1"></i>
                    <span class="d-none d-md-inline">Xem Website</span>
                </a>

                <!-- Chuông thông báo -->
                <div class="dropdown">
                    <div class="admin-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Thông báo hệ thống">
                        <i class="fa-regular fa-bell"></i>
                        <span class="notify-dot"></span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="width: 280px;">
                        <li><h6 class="dropdown-header text-uppercase fw-bold">Thông Báo Hệ Thống</h6></li>
                        <li><a class="dropdown-item py-2 small" href="javascript:void(0)"><i class="fa-solid fa-circle-check text-success me-2"></i>Có 1 đơn hàng mới vừa đặt</a></li>
                        <li><a class="dropdown-item py-2 small" href="javascript:void(0)"><i class="fa-solid fa-user-plus text-primary me-2"></i>1 khách hàng mới vừa đăng ký</a></li>
                        <li><a class="dropdown-item py-2 small" href="javascript:void(0)"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Kho MacBook Pro M3 còn 15 chiếc</a></li>
                    </ul>
                </div>

                <!-- Hồ sơ Admin (Avatar + Tên + Badge) -->
                <div class="dropdown">
                    <div class="admin-profile-pill" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="admin-avatar">AD</div>
                        <div class="d-none d-md-block text-start">
                            <div class="fw-bold small text-dark leading-none" id="topbarAdminName"><?= e(current_user()['full_name'] ?? 'Admin') ?></div>
                            <span class="admin-badge" style="font-size: 0.65rem; padding: 1px 6px;">ADMIN</span>
                        </div>
                        <i class="fa-solid fa-chevron-down small text-muted ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                        <li><h6 class="dropdown-header text-uppercase">Tài khoản Quản Trị</h6></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="switchAdminTab('accounts')"><i class="fa-solid fa-user-gear text-primary me-2"></i>Hồ sơ Admin</a></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="switchAdminTab('settings')"><i class="fa-solid fa-sliders text-secondary me-2"></i>Cài đặt hệ thống</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item py-2 text-danger" onclick="handleLogout()"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Đăng xuất</button></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- THÂN NỘI DUNG (CHỨA CÁC TABS) -->
        <main class="admin-content-container">

            <!-- ===================================================== -->
            <!-- TAB 1: TỔNG QUAN DASHBOARD                            -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane active" id="tab-dashboard">
                <!-- Tiêu đề trang Dashboard -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="fa-solid fa-chart-pie text-primary me-2"></i>Tổng Quan Hoạt Động Cửa Hàng
                        </h4>
                        <p class="text-muted small mb-0">Theo dõi doanh thu, đơn hàng và sản phẩm theo thời gian thực</p>
                    </div>
                    <div class="mt-2 mt-sm-0">
                        <span class="badge bg-light text-dark border p-2">
                            <i class="fa-regular fa-calendar-days text-primary me-1"></i> Hôm nay: <b id="dashboardTodayDate">--/--/----</b>
                        </span>
                    </div>
                </div>

                <!-- 4 Thẻ KPI Doanh Thu, Đơn Hàng, Sản Phẩm, Khách Hàng -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="admin-kpi-card">
                            <div class="admin-kpi-icon" style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                            <div class="admin-kpi-info">
                                <h4>548.900.000 ₫</h4>
                                <p>Tổng Doanh Thu</p>
                                <span class="admin-kpi-trend text-success"><i class="fa-solid fa-arrow-trend-up"></i> +12.5% so với tháng trước</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="admin-kpi-card">
                            <div class="admin-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div class="admin-kpi-info">
                                <h4>156 Đơn</h4>
                                <p>Tổng Đơn Hàng</p>
                                <span class="admin-kpi-trend text-success"><i class="fa-solid fa-arrow-trend-up"></i> +8.2% tuần này</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="admin-kpi-card">
                            <div class="admin-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <div class="admin-kpi-info">
                                <h4 id="kpiProductCount">16</h4>
                                <p>Sản Phẩm Trong Kho</p>
                                <span class="admin-kpi-trend text-primary"><i class="fa-solid fa-check"></i> Đang kinh doanh tốt</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="admin-kpi-card">
                            <div class="admin-kpi-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="admin-kpi-info">
                                <h4 id="kpiCustomerCount">89</h4>
                                <p>Khách Hàng Thành Viên</p>
                                <span class="admin-kpi-trend text-success"><i class="fa-solid fa-user-plus"></i> +15 đăng ký mới</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ doanh thu & Thống kê trạng thái đơn hàng -->
                <div class="row g-4 mb-4">
                    <!-- Cột trái: Biểu đồ doanh thu 12 tháng -->
                    <div class="col-12 col-xl-8">
                        <div class="admin-chart-box h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">
                                        <i class="fa-solid fa-chart-simple text-primary me-2"></i>Biểu Đồ Doanh Thu 12 Tháng
                                    </h5>
                                    <p class="text-muted small mb-0">Thống kê doanh số bán hàng công nghệ TECH STORE năm 2026</p>
                                </div>
                                <span class="badge bg-primary px-3 py-2">Đơn vị: Triệu VNĐ</span>
                            </div>

                            <!-- Biểu đồ cột CSS chuyên nghiệp -->
                            <div class="chart-bars-wrapper">
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 45%;"><span class="chart-tooltip">T1: 240tr</span></div><span class="chart-label">T1</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 55%;"><span class="chart-tooltip">T2: 290tr</span></div><span class="chart-label">T2</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 65%;"><span class="chart-tooltip">T3: 350tr</span></div><span class="chart-label">T3</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 50%;"><span class="chart-tooltip">T4: 270tr</span></div><span class="chart-label">T4</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 70%;"><span class="chart-tooltip">T5: 380tr</span></div><span class="chart-label">T5</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 60%;"><span class="chart-tooltip">T6: 320tr</span></div><span class="chart-label">T6</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 80%;"><span class="chart-tooltip">T7: 430tr</span></div><span class="chart-label">T7</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 75%;"><span class="chart-tooltip">T8: 400tr</span></div><span class="chart-label">T8</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 90%;"><span class="chart-tooltip">T9: 490tr</span></div><span class="chart-label">T9</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 85%;"><span class="chart-tooltip">T10: 460tr</span></div><span class="chart-label">T10</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 95%; background: linear-gradient(180deg, #f59e0b, #ea580c);"><span class="chart-tooltip">T11: 548tr</span></div><span class="chart-label fw-bold text-dark">T11</span></div>
                                <div class="chart-bar-item"><div class="chart-bar-fill" style="height: 60%; opacity: 0.5;"><span class="chart-tooltip">T12: Dự kiến</span></div><span class="chart-label">T12</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Thống kê trạng thái đơn hàng & Top bán chạy -->
                    <div class="col-12 col-xl-4">
                        <div class="admin-chart-box h-100">
                            <h5 class="fw-bold mb-3 text-dark">
                                <i class="fa-solid fa-pie-chart text-success me-2"></i>Trạng Thái Đơn Hàng
                            </h5>

                            <!-- Các tiến trình trạng thái đơn -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Đã giao thành công (75%)</span>
                                    <span class="text-success">117 đơn</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Đang vận chuyển (15%)</span>
                                    <span class="text-primary">24 đơn</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 15%"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Chờ xác nhận / xử lý (10%)</span>
                                    <span class="text-warning">15 đơn</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 10%"></div>
                                </div>
                            </div>

                            <hr>

                            <!-- Top sản phẩm bán chạy -->
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-fire text-danger me-2"></i>Top Bán Chạy Nhất</h6>
                            <div class="d-flex align-items-center gap-3 mb-2 pb-2 border-bottom">
                                <span class="badge bg-danger rounded-circle p-2">1</span>
                                <div class="flex-grow-1 small">
                                    <div class="fw-bold text-dark">iPhone 16 Pro Max 256GB</div>
                                    <span class="text-muted">Đã bán 48 chiếc</span>
                                </div>
                                <span class="fw-bold text-primary small">34.990.000 ₫</span>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-2 pb-2 border-bottom">
                                <span class="badge bg-warning text-dark rounded-circle p-2">2</span>
                                <div class="flex-grow-1 small">
                                    <div class="fw-bold text-dark">MacBook Pro 14 M3 Pro</div>
                                    <span class="text-muted">Đã bán 32 chiếc</span>
                                </div>
                                <span class="fw-bold text-primary small">46.990.000 ₫</span>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-info text-dark rounded-circle p-2">3</span>
                                <div class="flex-grow-1 small">
                                    <div class="fw-bold text-dark">AirPods Pro 2 USB-C</div>
                                    <span class="text-muted">Đã bán 65 chiếc</span>
                                </div>
                                <span class="fw-bold text-primary small">5.490.000 ₫</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách đơn hàng mới nhất -->
                <div class="admin-card-table mb-4">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">
                            <i class="fa-solid fa-clock-rotate-left text-primary"></i> Đơn Hàng Mới Nhất
                        </h5>
                        <button class="btn btn-outline-primary btn-sm" onclick="switchAdminTab('orders')">
                            Xem tất cả đơn hàng <i class="fa-solid fa-angle-right ms-1"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Khách Hàng</th>
                                    <th>Sản Phẩm Đặt Mua</th>
                                    <th>Ngày Đặt</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th class="text-end">Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody id="dashboardRecentOrdersBody">
                                <!-- JavaScript render tự động -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 2: QUẢN LÝ SẢN PHẨM & BIẾN THỂ                     -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-products">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Quản Lý Sản Phẩm & Biến Thể
                        </h4>
                        <p class="text-muted small mb-0">Quản lý tập trung từng dòng sản phẩm với các biến thể Màu sắc, Dung lượng, SKU, Giá và Tồn kho</p>
                    </div>
                    <div class="mt-2 mt-sm-0">
                        <button class="btn btn-primary btn-sm px-3 fw-bold" onclick="new bootstrap.Modal(document.getElementById('addProductModal')).show();">
                            <i class="fa-solid fa-plus me-1"></i> Thêm Sản Phẩm Mới
                        </button>
                    </div>
                </div>

                <!-- Thanh tìm kiếm & Bộ lọc sản phẩm -->
                <div class="bg-white p-3 rounded-3 border mb-3 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <div class="d-flex gap-2 flex-grow-1" style="max-width: 480px;">
                        <input type="text" class="form-control form-control-sm" id="adminProductFilterSearch" placeholder="Tìm theo tên sản phẩm, thương hiệu..." oninput="filterAdminProducts()">
                        <select class="form-select form-select-sm" style="max-width: 160px;" id="adminProductFilterCategory" onchange="filterAdminProducts()">
                            <option value="all">Tất cả danh mục</option>
                            <option value="phone">Điện thoại</option>
                            <option value="laptop">Laptop</option>
                            <option value="tablet">Máy tính bảng</option>
                            <option value="accessory">Phụ kiện</option>
                        </select>
                    </div>
                    <div class="text-muted small">
                        Hiển thị: <b id="adminProductFilterCount">0</b> sản phẩm
                    </div>
                </div>

                <!-- Bảng danh sách sản phẩm (Mỗi model 1 dòng duy nhất) -->
                <div class="admin-card-table">
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 65px;">Ảnh</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Danh Mục</th>
                                    <th>Khoảng Giá</th>
                                    <th>Tổng Tồn Kho</th>
                                    <th>Phiên Bản (Variants)</th>
                                    <th>Trạng Thái</th>
                                    <th class="text-end" style="width: 220px;">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody id="adminProductTableBody">
                                <!-- Đổ dữ liệu từ JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 3: QUẢN LÝ DANH MỤC                                -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-categories">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-shapes text-primary me-2"></i>Quản Lý Danh Mục</h4>
                        <p class="text-muted small mb-0">Phân loại các dòng sản phẩm công nghệ của cửa hàng</p>
                    </div>
                    <button class="btn btn-primary btn-sm fw-bold" onclick="alert('Demo: Thêm danh mục mới')">
                        <i class="fa-solid fa-plus me-1"></i> Thêm Danh Mục
                    </button>
                </div>

                <div class="admin-card-table">
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã Danh Mục</th>
                                    <th>Tên Danh Mục</th>
                                    <th>Biểu Tượng</th>
                                    <th>Số Sản Phẩm</th>
                                    <th>Trạng Thái</th>
                                    <th class="text-end">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>phone</code></td>
                                    <td class="fw-bold">Điện thoại di động</td>
                                    <td><i class="fa-solid fa-mobile-screen-button text-primary fs-5"></i></td>
                                    <td><span class="badge bg-light text-dark border fw-bold">4 sản phẩm</span></td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-primary btn-sm" onclick="alert('Sửa danh mục Điện thoại')"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>laptop</code></td>
                                    <td class="fw-bold">Máy tính Laptop</td>
                                    <td><i class="fa-solid fa-laptop text-primary fs-5"></i></td>
                                    <td><span class="badge bg-light text-dark border fw-bold">6 sản phẩm</span></td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-primary btn-sm" onclick="alert('Sửa danh mục Laptop')"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>tablet</code></td>
                                    <td class="fw-bold">Máy tính bảng (iPad)</td>
                                    <td><i class="fa-solid fa-tablet-screen-button text-primary fs-5"></i></td>
                                    <td><span class="badge bg-light text-dark border fw-bold">2 sản phẩm</span></td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-primary btn-sm" onclick="alert('Sửa danh mục Tablet')"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>accessory</code></td>
                                    <td class="fw-bold">Phụ kiện & Âm thanh</td>
                                    <td><i class="fa-solid fa-headphones text-primary fs-5"></i></td>
                                    <td><span class="badge bg-light text-dark border fw-bold">4 sản phẩm</span></td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-primary btn-sm" onclick="alert('Sửa danh mục Phụ kiện')"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 4: QUẢN LÝ ĐƠN HÀNG                                -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-orders">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-cart-shopping text-primary me-2"></i>Quản Lý Đơn Hàng</h4>
                        <p class="text-muted small mb-0">Theo dõi trạng thái giao dịch và xử lý đơn hàng của khách hàng</p>
                    </div>
                    <span class="badge bg-primary px-3 py-2">Tổng số: 6 đơn hàng mẫu</span>
                </div>

                <div class="admin-card-table">
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Liên Hệ</th>
                                    <th>Sản Phẩm</th>
                                    <th>Ngày Đặt</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th class="text-end">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody id="adminAllOrdersTableBody">
                                <!-- Đổ dữ liệu đơn hàng chi tiết từ JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 5: QUẢN LÝ KHÁCH HÀNG                              -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-customers">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-users text-primary me-2"></i>Quản Lý Khách Hàng</h4>
                        <p class="text-muted small mb-0">Danh sách khách hàng đã đăng ký tài khoản tại TECH STORE</p>
                    </div>
                </div>

                <div class="admin-card-table">
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tên Khách Hàng</th>
                                    <th>Tên Đăng Nhập</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Ngày Đăng Ký</th>
                                    <th>Vai Trò</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody id="adminCustomersTableBody">
                                <!-- Đổ dữ liệu từ bảng users (MySQL) -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 6: QUẢN LÝ TÀI KHOẢN & PHÂN QUYỀN                 -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-accounts">
                <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-user-shield text-primary me-2"></i>Hồ Sơ Tài Khoản & Phân Quyền</h4>
                <p class="text-muted small mb-4">Quản lý phiên đăng nhập và các vai trò phân quyền người dùng</p>

                <div class="row g-4">
                    <div class="col-12 col-md-5">
                        <div class="card border-0 shadow-sm rounded-3 p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light text-primary rounded-circle border border-3 border-primary shadow-sm mb-3 mx-auto" style="width: 80px; height: 80px; font-size: 2.2rem;">
                                <i class="fa-solid fa-user-gear"></i>
                            </div>
                            <h5 class="fw-bold mb-1" id="accountsAdminFullName">Quản trị viên (Admin)</h5>
                            <span class="badge bg-warning text-dark px-3 py-1 fw-bold mb-3">Administrator (Toàn quyền)</span>
                            <div class="bg-light p-3 rounded-3 small text-start">
                                <div class="py-1"><b>Tài khoản:</b> <code id="accountsAdminUser">admin</code></div>
                                <div class="py-1"><b>Trạng thái:</b> <span class="text-success fw-bold"><i class="fa-solid fa-circle-dot me-1"></i>Online</span></div>
                                <div class="py-1"><b>Lưu trữ:</b> MySQL (bảng <code>users</code>)</div>
                            </div>
                            <button class="btn btn-danger w-100 mt-3 fw-bold" onclick="handleLogout()">
                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Đăng Xuất
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-7">
                        <div class="card border-0 shadow-sm rounded-3 p-4">
                            <h5 class="fw-bold mb-3 text-dark">Bảng Phân Quyền Hệ Thống</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered small">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Vai trò (Role)</th>
                                            <th>Quyền hạn</th>
                                            <th>Truy cập Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-warning text-dark">admin</span></td>
                                            <td>Xem Dashboard, Sửa sản phẩm, Đơn hàng, Khách hàng, Cài đặt</td>
                                            <td><span class="text-success fw-bold"><i class="fa-solid fa-check"></i> Có quyền</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-info text-dark">customer</span></td>
                                            <td>Xem hàng, Đặt mua, Giỏ hàng, Đánh giá sản phẩm</td>
                                            <td><span class="text-danger fw-bold"><i class="fa-solid fa-xmark"></i> Bị chặn</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 7: QUẢN LÝ MÃ GIẢM GIÁ                             -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-coupons">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-ticket text-primary me-2"></i>Quản Lý Mã Giảm Giá</h4>
                        <p class="text-muted small mb-0">Tạo mã khuyến mãi kích cầu mua sắm công nghệ</p>
                    </div>
                    <button class="btn btn-primary btn-sm fw-bold" onclick="alert('Demo: Thêm mã giảm giá mới')">
                        <i class="fa-solid fa-plus me-1"></i> Tạo Mã Mới
                    </button>
                </div>

                <div class="admin-card-table">
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã Giảm Giá</th>
                                    <th>Mô Tả</th>
                                    <th>Mức Giảm</th>
                                    <th>Đơn Tối Thiểu</th>
                                    <th>Hạn Sử Dụng</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code class="fw-bold fs-6 text-primary">TECH10</code></td>
                                    <td>Giảm 10% cho thành viên mới</td>
                                    <td><span class="badge bg-danger">Giảm 10%</span></td>
                                    <td>5.000.000 ₫</td>
                                    <td>31/12/2026</td>
                                    <td><span class="badge bg-success">Đang kích hoạt</span></td>
                                </tr>
                                <tr>
                                    <td><code class="fw-bold fs-6 text-primary">SALE500K</code></td>
                                    <td>Giảm 500K cho đơn Laptop</td>
                                    <td><span class="badge bg-danger">Giảm 500.000 ₫</span></td>
                                    <td>15.000.000 ₫</td>
                                    <td>30/11/2026</td>
                                    <td><span class="badge bg-success">Đang kích hoạt</span></td>
                                </tr>
                                <tr>
                                    <td><code class="fw-bold fs-6 text-primary">FREESHIP</code></td>
                                    <td>Miễn phí vận chuyển toàn quốc</td>
                                    <td><span class="badge bg-info text-dark">Miễn phí ship</span></td>
                                    <td>0 ₫</td>
                                    <td>Không thời hạn</td>
                                    <td><span class="badge bg-success">Đang kích hoạt</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 8: QUẢN LÝ BÌNH LUẬN & ĐÁNH GIÁ                    -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-comments">
                <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-comments text-primary me-2"></i>Quản Lý Bình Luận & Đánh Giá</h4>
                <p class="text-muted small mb-4">Kiểm duyệt đánh giá của khách hàng đối với các sản phẩm công nghệ</p>

                <div class="admin-card-table">
                    <div class="table-responsive">
                        <table class="table admin-table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Khách Hàng</th>
                                    <th>Sản Phẩm</th>
                                    <th>Đánh Giá</th>
                                    <th>Nội Dung</th>
                                    <th>Thời Gian</th>
                                    <th>Trạng Thái</th>
                                    <th class="text-end">Kiểm Duyệt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Nguyễn Văn An</td>
                                    <td>iPhone 16 Pro Max</td>
                                    <td><span class="text-warning"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span></td>
                                    <td class="small">Máy dùng rất mượt, camera zoom cực kỳ sắc nét!</td>
                                    <td class="small text-muted">Vừa xong</td>
                                    <td><span class="badge bg-success">Đã duyệt</span></td>
                                    <td class="text-end"><button class="btn btn-outline-danger btn-sm" onclick="alert('Đã ẩn bình luận!')"><i class="fa-solid fa-eye-slash"></i></button></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Trần Thị Bích</td>
                                    <td>MacBook Pro 14 M3</td>
                                    <td><span class="text-warning"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span></td>
                                    <td class="small">Lập trình và render video cực êm, pin dùng 2 ngày không hết.</td>
                                    <td class="small text-muted">Hôm qua</td>
                                    <td><span class="badge bg-success">Đã duyệt</span></td>
                                    <td class="text-end"><button class="btn btn-outline-danger btn-sm" onclick="alert('Đã ẩn bình luận!')"><i class="fa-solid fa-eye-slash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 9: DOANH THU & THỐNG KÊ CHI TIẾT                  -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-analytics">
                <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-chart-line text-primary me-2"></i>Báo Cáo Doanh Thu & Thống Kê</h4>
                <p class="text-muted small mb-4">Chi tiết cơ cấu doanh số bán hàng theo từng nhóm sản phẩm</p>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="admin-chart-box">
                            <h5 class="fw-bold text-dark mb-3">Tỷ Trọng Doanh Thu Theo Danh Mục</h5>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Điện thoại di động (iPhone, Samsung)</span>
                                    <span>52% (285.4tr)</span>
                                </div>
                                <div class="progress" style="height: 10px;"><div class="progress-bar bg-primary" style="width: 52%"></div></div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Laptop (MacBook, ASUS, Dell)</span>
                                    <span>33% (181.1tr)</span>
                                </div>
                                <div class="progress" style="height: 10px;"><div class="progress-bar bg-info text-dark" style="width: 33%"></div></div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Máy tính bảng (iPad Pro, iPad Air)</span>
                                    <span>10% (54.8tr)</span>
                                </div>
                                <div class="progress" style="height: 10px;"><div class="progress-bar bg-warning" style="width: 10%"></div></div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Phụ kiện (Tai nghe, Chuột & Phím)</span>
                                    <span>5% (27.4tr)</span>
                                </div>
                                <div class="progress" style="height: 10px;"><div class="progress-bar bg-success" style="width: 5%"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="admin-chart-box">
                            <h5 class="fw-bold text-dark mb-3">Tóm Tắt Tài Chính Tháng Này</h5>
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item d-flex justify-content-between py-2">
                                    <span>Doanh thu gộp:</span>
                                    <strong class="text-primary">548.900.000 ₫</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2">
                                    <span>Tổng số sản phẩm đã bán:</span>
                                    <strong>184 thiết bị</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2">
                                    <span>Giá trị trung bình mỗi đơn:</span>
                                    <strong>3.518.000 ₫</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between py-2">
                                    <span>Tỷ lệ hoàn trả:</span>
                                    <strong class="text-success">0.8% (Rất thấp)</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- TAB 10: CÀI ĐẶT HỆ THỐNG                               -->
            <!-- ===================================================== -->
            <div class="admin-tab-pane" id="tab-settings">
                <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-sliders text-primary me-2"></i>Cài Đặt Hệ Thống</h4>
                <p class="text-muted small mb-4">Cấu hình thông tin cửa hàng TECH STORE</p>

                <div class="card border-0 shadow-sm rounded-3 p-4" style="max-width: 680px;">
                    <form onsubmit="event.preventDefault(); alert('Đã lưu cấu hình hệ thống thành công!');">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Tên Cửa Hàng</label>
                            <input type="text" class="form-control" value="TECH STORE - Thế Giới Công Nghệ Chính Hãng">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Số Hotline</label>
                                <input type="text" class="form-control" value="1800 6868">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Liên Hệ</label>
                                <input type="email" class="form-control" value="contact@techstore.vn">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Địa Chỉ Showroom Trụ Sở</label>
                            <input type="text" class="form-control" value="Tòa nhà FPT Polytechnic, Phố Trịnh Văn Bô, Nam Từ Liêm, Hà Nội">
                        </div>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Lưu Cấu Hình
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL 1: CHỈNH SỬA THÔNG TIN CHUNG SẢN PHẨM               -->
<!-- ========================================================= -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="editProductModalLabel">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Chỉnh Sửa Thông Tin Chung Sản Phẩm
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body p-4">
                <div id="editProductAlert" class="alert alert-danger py-2 small mb-3" style="display: none;" role="alert"></div>

                <form id="editProductForm" onsubmit="event.preventDefault(); saveProductChanges();">
                    <input type="hidden" id="editProductId">

                    <div class="row g-3">
                        <!-- 1. Tên sản phẩm -->
                        <div class="col-12 col-md-6">
                            <label for="editProductName" class="form-label fw-semibold small">
                                Tên sản phẩm <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editProductName" required placeholder="Ví dụ: iPhone 15">
                        </div>

                        <!-- 2. Danh mục sản phẩm -->
                        <div class="col-12 col-md-3">
                            <label for="editProductCategory" class="form-label fw-semibold small">
                                Danh mục <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="editProductCategory">
                                <option value="phone">Điện thoại</option>
                                <option value="laptop">Laptop</option>
                                <option value="tablet">Máy tính bảng</option>
                                <option value="accessory">Phụ kiện</option>
                            </select>
                        </div>

                        <!-- 3. Thương hiệu -->
                        <div class="col-12 col-md-3">
                            <label for="editProductBrand" class="form-label fw-semibold small">
                                Thương hiệu <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editProductBrand" required placeholder="Apple, Samsung...">
                        </div>

                        <!-- 4. Giá tham chiếu -->
                        <div class="col-12 col-md-4">
                            <label for="editProductPrice" class="form-label fw-semibold small">
                                Giá khởi điểm (VNĐ)
                            </label>
                            <input type="number" class="form-control" id="editProductPrice" readonly style="background-color: #f1f5f9;">
                            <div class="form-text small">Tự động lấy theo phiên bản thấp nhất.</div>
                        </div>

                        <!-- 5. Tổng tồn kho -->
                        <div class="col-12 col-md-4">
                            <label for="editProductStock" class="form-label fw-semibold small">
                                Tổng tồn kho (Các phiên bản)
                            </label>
                            <input type="number" class="form-control" id="editProductStock" readonly style="background-color: #f1f5f9;">
                            <div class="form-text small">Quản lý số lượng tại mục "Biến thể".</div>
                        </div>

                        <!-- 6. Trạng thái kinh doanh -->
                        <div class="col-12 col-md-4">
                            <label for="editProductStatus" class="form-label fw-semibold small">
                                Trạng thái kinh doanh <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="editProductStatus">
                                <option value="active">Đang kinh doanh</option>
                                <option value="inactive">Tạm ngừng kinh doanh</option>
                            </select>
                        </div>

                        <!-- 7. Hình ảnh sản phẩm (URL) -->
                        <div class="col-12">
                            <label for="editProductImage" class="form-label fw-semibold small">
                                Đường dẫn hình ảnh đại diện chính (URL)
                            </label>
                            <div class="input-group">
                                <input type="url" class="form-control" id="editProductImage" placeholder="https://images.unsplash.com/..." oninput="previewEditImage()">
                                <button class="btn btn-outline-secondary" type="button" onclick="previewEditImage()">Xem trước</button>
                            </div>
                        </div>

                        <!-- Xem trước ảnh -->
                        <div class="col-12 text-center py-2 bg-light rounded">
                            <span class="small text-muted d-block mb-1">Ảnh đại diện xem trước:</span>
                            <img id="editProductImagePreview" src="" alt="Xem trước" class="rounded border p-1" style="max-height: 110px; max-width: 160px; object-fit: contain;">
                        </div>

                        <!-- 8. Mô tả sản phẩm -->
                        <div class="col-12">
                            <label for="editProductDescription" class="form-label fw-semibold small">
                                Mô tả sản phẩm
                            </label>
                            <textarea class="form-control" id="editProductDescription" rows="3" placeholder="Nhập mô tả tóm tắt tính năng sản phẩm..."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Hủy
                </button>
                <button type="button" class="btn btn-primary px-4 fw-bold" onclick="saveProductChanges()">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL 2: QUẢN LÝ BIẾN THỂ SẢN PHẨM (VARIANTS MANAGER)     -->
<!-- ========================================================= -->
<div class="modal fade" id="variantsManagerModal" tabindex="-1" aria-labelledby="variantsManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="variantsManagerModalLabel">
                    <i class="fa-solid fa-layer-group text-primary me-2"></i> Quản Lý Biến Thể (Màu sắc, Dung lượng, Giá & Kho): <span id="variantModalProductName" class="text-warning">...</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body p-4">
                <div class="alert alert-info py-2 small mb-3">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    Mỗi phiên bản là một tổ hợp <b>Màu sắc</b> và <b>Dung lượng</b> với mã SKU, giá bán và tồn kho riêng biệt. Khách hàng khi chọn mua sẽ thấy giá và tình trạng hàng tương ứng.
                </div>

                <!-- Bảng danh sách các biến thể hiện tại -->
                <div class="table-responsive mb-4 border rounded">
                    <table class="table table-variants align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Mã SKU</th>
                                <th>Màu Sắc</th>
                                <th>Dung Lượng</th>
                                <th>Giá Bán (₫)</th>
                                <th>Giá Gốc (₫)</th>
                                <th>Tồn Kho</th>
                                <th class="text-end" style="width: 70px;">Xóa</th>
                            </tr>
                        </thead>
                        <tbody id="adminVariantsTableBody">
                            <!-- Đổ dữ liệu từ JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Khối Thêm phiên bản mới -->
                <div class="card border-0 bg-light p-3 rounded-3">
                    <h6 class="fw-bold text-dark mb-2">
                        <i class="fa-solid fa-plus-circle text-success me-1"></i> Thêm Phiên Bản Mới Cho Sản Phẩm Này
                    </h6>
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold mb-1">Màu sắc</label>
                            <input type="text" class="form-control form-control-sm" id="newVariantColor" placeholder="VD: Titan Sa Mạc">
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold mb-1">Dung lượng</label>
                            <input type="text" class="form-control form-control-sm" id="newVariantStorage" placeholder="VD: 512GB">
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold mb-1">Mã SKU</label>
                            <input type="text" class="form-control form-control-sm font-monospace" id="newVariantSku" placeholder="Tự sinh nếu trống">
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold mb-1">Giá bán (₫)</label>
                            <input type="number" class="form-control form-control-sm" id="newVariantPrice" placeholder="VD: 20000000" step="50000">
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold mb-1">Tồn kho</label>
                            <input type="number" class="form-control form-control-sm" id="newVariantStock" value="15" min="0">
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="button" class="btn btn-success btn-sm w-100 fw-bold" onclick="addNewVariantToProduct()">
                                <i class="fa-solid fa-plus me-1"></i> Thêm Bản
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light py-2 justify-content-between">
                <span class="small text-muted"><i class="fa-regular fa-lightbulb me-1"></i> Nhấn "Lưu Toàn Bộ Biến Thể" sau khi chỉnh sửa Giá và Tồn kho.</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary px-4 fw-bold" onclick="saveAllVariantsChanges()">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Lưu Toàn Bộ Biến Thể
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL 3: THÊM SẢN PHẨM MỚI KÈM CÁC BIẾN THỂ                -->
<!-- ========================================================= -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="addProductModalLabel">
                    <i class="fa-solid fa-plus me-2"></i> Thêm Sản Phẩm Mới & Tạo Biến Thể Tự Động
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body p-4">
                <form id="addProductForm" onsubmit="handleAddProductWithVariants(event);">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addProductName" required placeholder="Ví dụ: iPhone 15, MacBook Air M3...">
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold small">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select" id="addProductCategory">
                                <option value="phone">Điện thoại</option>
                                <option value="laptop">Laptop</option>
                                <option value="tablet">Máy tính bảng</option>
                                <option value="accessory">Phụ kiện</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold small">Thương hiệu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addProductBrand" required placeholder="Apple, Samsung, ASUS...">
                        </div>

                        <!-- Danh sách Màu sắc -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Danh sách Màu sắc (cách nhau bởi dấu phẩy) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addProductColors" required value="Đen, Xanh dương, Hồng, Vàng">
                            <div class="form-text small">Hệ thống sẽ tạo phiên bản riêng cho từng màu.</div>
                        </div>

                        <!-- Danh sách Dung lượng -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Danh sách Dung lượng / Cấu hình (cách nhau bởi dấu phẩy) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addProductStorages" required value="128GB, 256GB, 512GB">
                            <div class="form-text small">Hệ thống sẽ tạo tổ hợp [Màu x Dung lượng].</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Giá bán khởi điểm (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="addProductBasePrice" required min="100000" step="50000" value="18000000">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Tồn kho mặc định mỗi phiên bản <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="addProductBaseStock" required min="0" value="15">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Đường dẫn hình ảnh sản phẩm (URL)</label>
                            <input type="url" class="form-control" id="addProductImage" placeholder="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="addProductDescription" rows="2" placeholder="Nhập mô tả sản phẩm công nghệ..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold">
                            <i class="fa-solid fa-plus me-1"></i> Tạo Sản Phẩm & Biến Thể
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách khách hàng thật từ MySQL (do HomeController truyền sang) -->
<script>
    window.ADMIN_CUSTOMERS = <?= json_encode(
        $customers ?? [],
        JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    ) ?: '[]' ?>;
</script>

<!-- ========================================================= -->
<!-- SCRIPT ĐIỀU KHIỂN RIÊNG CHO TRANG ADMIN                    -->
<!-- ========================================================= -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Kiểm tra lại quyền Admin (nếu chưa đăng nhập sẽ lập tức bị chặn)
    const user = typeof getCurrentUser === 'function' ? getCurrentUser() : null;
    if (!user || user.role !== 'admin') {
        alert('Cảnh báo: Bạn phải đăng nhập tài khoản Admin để truy cập trang này!');
        window.location.href = 'index.php?action=login';
        return;
    }

    // 2. Cập nhật ngày tháng và tên Admin lên giao diện
    const topName = document.getElementById('topbarAdminName');
    const accName = document.getElementById('accountsAdminFullName');
    const accUser = document.getElementById('accountsAdminUser');
    const todayEl = document.getElementById('dashboardTodayDate');

    if (topName) topName.innerText = user.fullName || 'Admin';
    if (accName) accName.innerText = user.fullName || 'Quản trị viên (Admin)';
    if (accUser) accUser.innerText = user.username || 'admin';
    if (todayEl) todayEl.innerText = new Date().toLocaleDateString('vi-VN');

    // 3. Khởi tạo dữ liệu các bảng
    renderAdminProductTable();
    renderAdminOrdersData();
    renderAdminCustomersData();
});

// Hàm chuyển đổi các Tab trên Sidebar
function switchAdminTab(tabName) {
    const panes = document.querySelectorAll('.admin-tab-pane');
    panes.forEach(pane => pane.classList.remove('active'));

    const navItems = document.querySelectorAll('.admin-nav-item');
    navItems.forEach(item => item.classList.remove('active'));

    const targetPane = document.getElementById('tab-' + tabName);
    const targetNav = document.getElementById('nav-' + tabName);

    if (targetPane) targetPane.classList.add('active');
    if (targetNav) targetNav.classList.add('active');

    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('adminBackdrop');
    if (sidebar) sidebar.classList.remove('sidebar-open');
    if (backdrop) backdrop.classList.remove('show');
}

// Bật/tắt Sidebar trên màn hình điện thoại
function toggleAdminSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('adminBackdrop');
    if (sidebar) sidebar.classList.toggle('sidebar-open');
    if (backdrop) backdrop.classList.toggle('show');
}

// Hàm render bảng sản phẩm (1 dòng duy nhất cho mỗi dòng model sản phẩm)
function renderAdminProductTable(filterList) {
    const tableBody = document.getElementById('adminProductTableBody');
    if (!tableBody || typeof PRODUCTS === 'undefined') return;

    const list = filterList || PRODUCTS;

    const kpiCount = document.getElementById('kpiProductCount');
    const filterCount = document.getElementById('adminProductFilterCount');
    const sideCount = document.getElementById('sidebarProductCount');

    if (kpiCount) kpiCount.innerText = PRODUCTS.length;
    if (filterCount) filterCount.innerText = list.length;
    if (sideCount) sideCount.innerText = PRODUCTS.length;

    if (list.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-muted">Không tìm thấy sản phẩm nào phù hợp!</td></tr>`;
        return;
    }

    tableBody.innerHTML = list.map(product => {
        const minPrice = getProductMinPrice(product);
        const maxPrice = getProductMaxPrice(product);
        const totalStock = getProductTotalStock(product);
        const variantCount = product.variants ? product.variants.length : 0;

        let priceText = '';
        if (minPrice === maxPrice || maxPrice === 0) {
            priceText = formatCurrency(minPrice);
        } else {
            priceText = `<div class="fw-bold text-danger">${formatCurrency(minPrice)}</div><small class="text-muted">đến ${formatCurrency(maxPrice)}</small>`;
        }

        const statusBadge = (product.status === 'inactive') 
            ? '<span class="badge bg-secondary">Tạm ngừng</span>' 
            : '<span class="badge bg-success">Đang bán</span>';

        return `
            <tr>
                <td class="ps-3 fw-bold text-muted">#${product.id}</td>
                <td>
                    <img src="${product.image}" 
                         alt="${product.name}" 
                         class="rounded border p-1" 
                         style="width: 48px; height: 48px; object-fit: contain;"
                         onerror="handleImageError(this, '${product.name.replace(/'/g, "\\'")}')">
                </td>
                <td>
                    <div class="fw-bold text-dark">${product.name}</div>
                    <span class="badge bg-light text-secondary border small">${product.brand || 'Chính hãng'}</span>
                </td>
                <td><span class="badge bg-light text-dark border">${product.categoryName}</span></td>
                <td>${priceText}</td>
                <td>
                    <span class="badge ${totalStock > 0 ? 'bg-light text-dark border' : 'bg-danger'} fw-bold">
                        ${totalStock > 0 ? totalStock + ' máy' : 'Hết hàng'}
                    </span>
                </td>
                <td>
                    <!-- Nút xem và quản lý các biến thể của sản phẩm -->
                    <button class="btn btn-sm btn-outline-info fw-semibold py-1 px-2" onclick="openVariantsManagerModal(${product.id})" title="Xem chi tiết các phiên bản">
                        <i class="fa-solid fa-layer-group me-1"></i> ${variantCount} phiên bản
                    </button>
                </td>
                <td>${statusBadge}</td>
                <td class="text-end pe-3 text-nowrap">
                    <!-- Nút xem chi tiết và thử chọn phiên bản -->
                    <button class="btn btn-outline-secondary btn-sm me-1" onclick="showProductDetail(${product.id})" title="Xem trước giao diện chọn mua">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                    <!-- Nút Quản lý Biến thể -->
                    <button class="btn btn-info btn-sm text-white me-1 fw-semibold" onclick="openVariantsManagerModal(${product.id})" title="Quản lý biến thể (Màu, Dung lượng, Giá, Kho)">
                        <i class="fa-solid fa-sliders me-1"></i> Biến thể
                    </button>
                    <!-- Nút SỬA thông tin chung -->
                    <button class="btn btn-primary btn-sm me-1 fw-semibold" onclick="openEditProductModal(${product.id})" title="Sửa thông tin sản phẩm">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Sửa
                    </button>
                    <!-- Nút XÓA -->
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteProduct(${product.id})" title="Xóa">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

// Tìm kiếm & Lọc sản phẩm trong trang Quản lý sản phẩm
function filterAdminProducts() {
    const keyword = (document.getElementById('adminProductFilterSearch')?.value || '').trim().toLowerCase();
    const category = document.getElementById('adminProductFilterCategory')?.value || 'all';

    let result = PRODUCTS;

    if (category !== 'all') {
        result = result.filter(p => p.category === category);
    }

    if (keyword) {
        result = result.filter(p => 
            p.name.toLowerCase().includes(keyword) || 
            (p.brand && p.brand.toLowerCase().includes(keyword)) ||
            p.description.toLowerCase().includes(keyword)
        );
    }

    renderAdminProductTable(result);
}

// Tìm kiếm toàn cục từ Topbar Header
function handleAdminGlobalSearch(val) {
    switchAdminTab('products');
    const input = document.getElementById('adminProductFilterSearch');
    if (input) {
        input.value = val;
        filterAdminProducts();
    }
}

// Render dữ liệu Đơn hàng (Đồng bộ với các đơn đặt hàng mới từ khách hàng)
function renderAdminOrdersData() {
    const orders = typeof getStoredOrders === 'function' ? getStoredOrders() : [];

    // 1. Render đơn hàng mới nhất trên Dashboard
    const recentBody = document.getElementById('dashboardRecentOrdersBody');
    if (recentBody) {
        recentBody.innerHTML = orders.slice(0, 5).map(order => {
            let badgeClass = 'bg-success';
            if (order.status === 'shipping') badgeClass = 'bg-primary';
            if (order.status === 'pending') badgeClass = 'bg-warning text-dark';

            return `
                <tr>
                    <td class="fw-bold text-primary">#${order.id}</td>
                    <td class="fw-bold">${order.customer}</td>
                    <td class="small text-truncate" style="max-width: 250px;" title="${order.productSummary}">${order.productSummary}</td>
                    <td class="small text-muted">${order.date}</td>
                    <td class="fw-bold text-danger">${formatCurrency(order.total)}</td>
                    <td><span class="badge ${badgeClass}">${order.statusText}</span></td>
                    <td class="text-end">
                        <button class="btn btn-outline-primary btn-sm py-0 px-2" onclick="alert('Chi tiết đơn hàng #' + '${order.id}' + ':\\n' + '${order.productSummary}')">Xem</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // 2. Render bảng quản lý tất cả đơn hàng (Tab đơn hàng)
    const allBody = document.getElementById('adminAllOrdersTableBody');
    if (allBody) {
        allBody.innerHTML = orders.map(order => {
            let badgeClass = 'bg-success';
            if (order.status === 'shipping') badgeClass = 'bg-primary';
            if (order.status === 'pending') badgeClass = 'bg-warning text-dark';

            return `
                <tr>
                    <td class="fw-bold text-primary">#${order.id}</td>
                    <td class="fw-bold">${order.customer}</td>
                    <td>${order.phone}</td>
                    <td class="small text-truncate" style="max-width: 260px;" title="${order.productSummary}">${order.productSummary}</td>
                    <td>${order.date}</td>
                    <td class="fw-bold text-danger">${formatCurrency(order.total)}</td>
                    <td><span class="badge ${badgeClass}">${order.statusText}</span></td>
                    <td class="text-end">
                        <button class="btn btn-primary btn-sm me-1" onclick="alert('Đã cập nhật trạng thái cho đơn hàng #' + '${order.id}')">Xử lý</button>
                    </td>
                </tr>
            `;
        }).join('');
    }
}

// Render khách hàng
function renderAdminCustomersData() {
    const tableBody = document.getElementById('adminCustomersTableBody');
    if (!tableBody) return;

    const dbCustomers = Array.isArray(window.ADMIN_CUSTOMERS) ? window.ADMIN_CUSTOMERS : [];
    const registeredUsers = dbCustomers.length
        ? dbCustomers
        : (typeof getRegisteredUsers === 'function' ? getRegisteredUsers() : []);

    const defaultCustomers = [
        { fullName: "Nguyễn Văn An", username: "nguyenvana", email: "nguyenvana@gmail.com", phone: "0988123456", createdAt: "2026-11-10T08:30:00Z" },
        { fullName: "Trần Thị Bích", username: "tranbich", email: "tranbich@gmail.com", phone: "0912345678", createdAt: "2026-11-12T10:15:00Z" },
        { fullName: "Lê Hoàng Nam", username: "hoangnam", email: "hoangnam@gmail.com", phone: "0977889900", createdAt: "2026-11-14T14:45:00Z" }
    ];

    const allCustomers = [...registeredUsers, ...defaultCustomers];

    const kpiCustomer = document.getElementById('kpiCustomerCount');
    if (kpiCustomer) kpiCustomer.innerText = allCustomers.length;

    tableBody.innerHTML = allCustomers.map(c => `
        <tr>
            <td class="fw-bold">${c.fullName}</td>
            <td><code>${c.username}</code></td>
            <td>${c.email}</td>
            <td>${c.phone}</td>
            <td class="small text-muted">${new Date(c.createdAt || Date.now()).toLocaleDateString('vi-VN')}</td>
            <td><span class="badge bg-info text-dark">Khách hàng</span></td>
            <td><span class="badge bg-success">Hoạt động</span></td>
        </tr>
    `).join('');
}
</script>
