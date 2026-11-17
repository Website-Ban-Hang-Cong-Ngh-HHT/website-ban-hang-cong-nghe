<!-- ========================================================= -->
<!-- TRANG CHỦ TECH STORE (views/home.php) -->
<!-- ========================================================= -->

<div class="container pb-5">

    <!-- 1. BANNER QUẢNG CÁO CÔNG NGHỆ (HERO SLIDER) -->
    <section class="hero-slider-section">
        <div id="techHeroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
            <!-- Chỉ số slide -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#techHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#techHeroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#techHeroCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">
                <!-- Slide 1: iPhone 16 Series -->
                <div class="carousel-item active" data-bs-interval="5000">
                    <div class="hero-slide-item" style="background-image: url('https://images.unsplash.com/photo-1556656793-08538906a9f8?w=1400&auto=format&fit=crop&q=80');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <span class="badge-tag"><i class="fa-solid fa-fire me-1"></i> SIÊU PHẨM CÔNG NGHỆ 2026</span>
                            <h2>iPhone 15 &amp; 16 Series<br><span style="color: #60a5fa;">Đa Sắc Màu - Đỉnh Hiệu Năng</span></h2>
                            <p>Camera 48MP siêu nét, Dynamic Island thông minh, cổng USB-C và trọn bộ phiên bản màu sắc &amp; dung lượng mới nhất.</p>
                            <div class="d-flex gap-3">
                                <a href="javascript:void(0)" onclick="filterCategory('phone')" class="btn btn-primary px-4 py-2 fw-bold">
                                    <i class="fa-solid fa-cart-shopping me-1"></i> Khám phá ngay
                                </a>
                                <a href="javascript:void(0)" onclick="showProductDetail(1)" class="btn btn-outline-light px-4 py-2 fw-bold">
                                    Xem iPhone 15
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Laptop Gaming & MacBook -->
                <div class="carousel-item" data-bs-interval="5000">
                    <div class="hero-slide-item" style="background-image: url('https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=1400&auto=format&fit=crop&q=80');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <span class="badge-tag bg-warning text-dark"><i class="fa-solid fa-bolt me-1"></i> HIỆU NĂNG VƯỢT TRỘI</span>
                            <h2>MacBook Pro M3 &<br><span style="color: #38bdf8;">Laptop ASUS Gaming</span></h2>
                            <p>Mạnh mẽ cho lập trình viên, đồ họa 3D và game thủ hàng đầu. Ưu đãi trả góp 0% lãi suất.</p>
                            <div class="d-flex gap-3">
                                <a href="javascript:void(0)" onclick="filterCategory('laptop')" class="btn btn-primary px-4 py-2 fw-bold">
                                    <i class="fa-solid fa-laptop me-1"></i> Xem danh sách Laptop
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Phụ kiện công nghệ -->
                <div class="carousel-item" data-bs-interval="5000">
                    <div class="hero-slide-item" style="background-image: url('https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=1400&auto=format&fit=crop&q=80');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <span class="badge-tag bg-danger"><i class="fa-solid fa-tag me-1"></i> GIẢM TỚI 50%</span>
                            <h2>Tuần Lễ Phụ Kiện<br><span style="color: #f87171;">Âm Thanh & Gaming Gear</span></h2>
                            <p>AirPods Pro 2, tai nghe Sony WH-1000XM5, chuột Logitech MX Master 3S chính hãng giá sốc.</p>
                            <div class="d-flex gap-3">
                                <a href="javascript:void(0)" onclick="filterCategory('accessory')" class="btn btn-danger px-4 py-2 fw-bold">
                                    <i class="fa-solid fa-gift me-1"></i> Săn Deal Phụ Kiện
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút Next/Prev cho Carousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#techHeroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#techHeroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>

        <!-- 4 Khối cam kết dịch vụ dưới banner -->
        <div class="features-box-wrapper">
            <div class="feature-box">
                <div class="f-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <h6>100% Chính Hãng</h6>
                    <p>Cam kết bồi hoàn 200% nếu phát hiện hàng giả</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="f-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <div>
                    <h6>Miễn Phí Vận Chuyển</h6>
                    <p>Giao hàng toàn quốc cho mọi sản phẩm công nghệ</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="f-icon"><i class="fa-solid fa-arrows-rotate"></i></div>
                <div>
                    <h6>Đổi Trả 30 Ngày</h6>
                    <p>Lỗi 1 đổi 1 tận nơi nhanh chóng trong 30 ngày</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="f-icon"><i class="fa-solid fa-headset"></i></div>
                <div>
                    <h6>Hỗ Trợ 24/7</h6>
                    <p>Tư vấn kỹ thuật và bảo hành chu đáo</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. DANH MỤC SẢN PHẨM (CATEGORY GRID) -->
    <section class="category-section mt-4">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fa-solid fa-shapes"></i> Danh Mục Nổi Bật
            </h3>
            <span class="small text-muted d-none d-sm-inline">Khám phá các dòng sản phẩm công nghệ cao cấp</span>
        </div>

        <div class="category-grid">
            <div class="category-card" onclick="filterCategory('phone')">
                <div class="cat-icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                <h6 class="cat-name">Điện thoại</h6>
                <span class="cat-count">iPhone, Galaxy</span>
            </div>
            <div class="category-card" onclick="filterCategory('laptop')">
                <div class="cat-icon"><i class="fa-solid fa-laptop"></i></div>
                <h6 class="cat-name">Laptop</h6>
                <span class="cat-count">MacBook, ASUS, Dell</span>
            </div>
            <div class="category-card" onclick="filterCategory('tablet')">
                <div class="cat-icon"><i class="fa-solid fa-tablet-screen-button"></i></div>
                <h6 class="cat-name">Máy tính bảng</h6>
                <span class="cat-count">iPad Pro, iPad Air</span>
            </div>
            <div class="category-card" onclick="filterCategory('accessory')">
                <div class="cat-icon"><i class="fa-solid fa-headphones"></i></div>
                <h6 class="cat-name">Tai nghe</h6>
                <span class="cat-count">AirPods, Sony</span>
            </div>
            <div class="category-card" onclick="filterCategory('accessory')">
                <div class="cat-icon"><i class="fa-solid fa-keyboard"></i></div>
                <h6 class="cat-name">Chuột & Phím</h6>
                <span class="cat-count">Logitech, DareU</span>
            </div>
            <div class="category-card" onclick="filterCategory('promo')">
                <div class="cat-icon text-danger" style="background: rgba(239, 68, 68, 0.1);"><i class="fa-solid fa-fire-flame-curved"></i></div>
                <h6 class="cat-name text-danger">Khuyến mãi</h6>
                <span class="cat-count">Giảm tới 50%</span>
            </div>
        </div>
    </section>

    <!-- 3. KHU VỰC KẾT QUẢ TÌM KIẾM HOẶC LỌC DANH MỤC (ẨN MẶC ĐỊNH, HIỆN KHI CẦN) -->
    <section id="categoryFilterSection" class="mt-4" style="display: none;">
        <div class="section-header bg-white p-3 rounded shadow-sm border">
            <h4 class="section-title mb-0" id="filteredCategoryTitle">
                <i class="fa-solid fa-filter text-primary"></i> Kết quả lọc sản phẩm
            </h4>
            <button class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('categoryFilterSection').style.display='none';">
                <i class="fa-solid fa-xmark me-1"></i> Đóng bộ lọc
            </button>
        </div>
        <div class="row mt-3" id="filteredProductsContainer">
            <!-- Sản phẩm lọc sẽ được JavaScript render vào đây -->
        </div>
    </section>

    <!-- 4. KHỐI SẢN PHẨM NỔI BẬT (FEATURED PRODUCTS) -->
    <section class="mt-5">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fa-solid fa-star text-warning"></i> Sản Phẩm Nổi Bật
            </h3>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" onclick="filterCategory('phone')">Điện thoại</button>
                <button class="btn btn-sm btn-outline-primary" onclick="filterCategory('laptop')">Laptop</button>
                <button class="btn btn-sm btn-outline-primary" onclick="filterCategory('all')">Xem tất cả</button>
            </div>
        </div>

        <div class="row" id="featuredProductsContainer">
            <!-- Sản phẩm nổi bật được JavaScript tự động tạo ở đây -->
        </div>
    </section>

    <!-- 5. BANNER QUẢNG CÁO GIỮA TRANG (PROMO STRIP) -->
    <div class="promo-strip-banner d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div style="position: relative; z-index: 2;">
            <span class="badge bg-danger mb-2 px-3 py-2 fw-bold text-uppercase">Flash Sale Trong Ngày</span>
            <h3 class="fw-bold mb-2 text-white">Nâng Tầm Công Nghệ - Giá Rẻ Bất Ngờ</h3>
            <p class="text-light mb-0" style="max-width: 550px;">
                Cơ hội sở hữu siêu phẩm iPhone 16 Pro Max, Samsung Galaxy S24 Ultra và MacBook Pro M3 với voucher giảm thêm 1.000.000đ dành cho học sinh, sinh viên.
            </p>
        </div>
        <div class="mt-3 mt-md-0" style="position: relative; z-index: 2;">
            <button class="btn btn-warning btn-lg px-4 fw-bold shadow" onclick="filterCategory('promo')">
                <i class="fa-solid fa-bolt me-1"></i> Săn Deal Ngay
            </button>
        </div>
    </div>

    <!-- 6. KHỐI SẢN PHẨM MỚI NHẤT (NEWEST PRODUCTS) -->
    <section class="mt-4">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fa-solid fa-sparkles text-primary"></i> Sản Phẩm Mới Nhất
            </h3>
            <span class="small text-muted d-none d-sm-inline">Cập nhật công nghệ mới nhất vừa về hàng tại showroom</span>
        </div>

        <div class="row" id="newestProductsContainer">
            <!-- Sản phẩm mới nhất được JavaScript tự động tạo ở đây -->
        </div>
    </section>

    <!-- 7. KHỐI SẢN PHẨM KHUYẾN MÃI (PROMOTIONAL PRODUCTS) -->
    <section class="mt-5">
        <div class="section-header">
            <div class="d-flex align-items-center gap-3">
                <h3 class="section-title text-danger mb-0">
                    <i class="fa-solid fa-fire text-danger"></i> Sản Phẩm Khuyến Mãi
                </h3>
                <span class="badge bg-danger text-uppercase px-2 py-1">Giảm Sốc</span>
            </div>
            <span class="small text-danger fw-bold">
                <i class="fa-regular fa-clock me-1"></i> Số lượng ưu đãi có hạn
            </span>
        </div>

        <div class="row" id="promoProductsContainer">
            <!-- Sản phẩm khuyến mãi được JavaScript tự động tạo ở đây -->
        </div>
    </section>

</div>
