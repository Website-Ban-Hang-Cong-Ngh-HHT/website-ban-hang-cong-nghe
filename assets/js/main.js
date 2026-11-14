/**
 * TECH STORE - JAVASCRIPT XỬ LÝ CHỨC NĂNG WEBSITE
 * -------------------------------------------------------------
 * Đối tượng: Sinh viên mới học Front-End
 * Công nghệ: JavaScript thuần (Vanilla JS), LocalStorage
 * Chức năng:
 *  1. Quản lý dữ liệu sản phẩm mẫu (iPhone, Samsung, MacBook, ASUS, Dell, iPad, Phụ kiện...)
 *  2. Hiển thị sản phẩm theo phân loại (Nổi bật, Mới nhất, Khuyến mãi)
 *  3. Tìm kiếm sản phẩm theo tên
 *  4. Lọc sản phẩm theo danh mục
 *  5. Xem chi tiết sản phẩm qua Modal
 *  6. Quản lý giỏ hàng (Thêm, Xóa, Cập nhật số lượng, Lưu LocalStorage)
 *  7. Xử lý Đăng nhập / Đăng xuất tài khoản Admin bằng LocalStorage
 *  8. Bảo vệ trang Quản trị (Admin) nếu chưa đăng nhập
 */

// =============================================================
// PHẦN 1: DANH SÁCH SẢN PHẨM MẪU (DATABASE FRONT-END MÔ PHỎNG)
// =============================================================
const PRODUCTS = [
    // 1. Nhóm iPhone
    {
        id: 1,
        name: "iPhone 16 Pro Max 256GB Titan Tự Nhiên",
        category: "phone",
        categoryName: "Điện thoại",
        price: 34990000,
        originalPrice: 36990000,
        image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 5.0,
        reviews: 128,
        description: "iPhone 16 Pro Max với chip A18 Pro mạnh mẽ vượt trội, khung viền Titan siêu bền nhẹ, nút Điều khiển camera mới và thời lượng pin xuất sắc nhất từ trước đến nay."
    },
    {
        id: 2,
        name: "iPhone 15 Pro 128GB Titan Xanh",
        category: "phone",
        categoryName: "Điện thoại",
        price: 24990000,
        originalPrice: 28990000,
        image: "https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: false,
        isPromo: true,
        rating: 4.8,
        reviews: 94,
        description: "iPhone 15 Pro trang bị chip Apple A17 Pro tiến trình 3nm đầu tiên trên thế giới, cổng kết nối USB-C tốc độ cao và cụm 3 camera 48MP đỉnh cao."
    },

    // 2. Nhóm Samsung Galaxy
    {
        id: 3,
        name: "Samsung Galaxy S24 Ultra 5G 12GB/256GB",
        category: "phone",
        categoryName: "Điện thoại",
        price: 28990000,
        originalPrice: 33990000,
        image: "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 110,
        description: "Samsung Galaxy S24 Ultra tích hợp quyền năng Galaxy AI, camera zoom 100x siêu sắc nét, bút S-Pen tiện dụng và chip Snapdragon 8 Gen 3 for Galaxy đỉnh cao."
    },
    {
        id: 4,
        name: "Samsung Galaxy Z Fold5 5G 256GB",
        category: "phone",
        categoryName: "Điện thoại",
        price: 35990000,
        originalPrice: 40990000,
        image: "https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: false,
        isPromo: true,
        rating: 4.7,
        reviews: 62,
        description: "Điện thoại màn hình gập cao cấp, bản lề Flex gập khít hoàn hảo, đa nhiệm cực đỉnh như máy tính bảng trong lòng bàn tay."
    },

    // 3. Nhóm MacBook
    {
        id: 5,
        name: "MacBook Pro 14 M3 Pro (18GB / 512GB SSD)",
        category: "laptop",
        categoryName: "Laptop",
        price: 46990000,
        originalPrice: 49990000,
        image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 5.0,
        reviews: 85,
        description: "MacBook Pro 14 inch chip Apple M3 Pro mang lại hiệu năng đồ họa đột phá, màn hình Liquid Retina XDR 120Hz siêu nét và thời lượng pin lên đến 18 giờ."
    },
    {
        id: 6,
        name: "MacBook Air 13 M2 (8GB / 256GB SSD)",
        category: "laptop",
        categoryName: "Laptop",
        price: 22490000,
        originalPrice: 24990000,
        image: "https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: false,
        isPromo: true,
        rating: 4.8,
        reviews: 142,
        description: "Thiết kế mỏng nhẹ siêu di động, chip Apple M2 êm ái không cần quạt tản nhiệt, sạc MagSafe an toàn và bàn phím Magic Keyboard gõ cực êm."
    },

    // 4. Nhóm Laptop ASUS
    {
        id: 7,
        name: "Laptop Gaming ASUS ROG Strix G16 G614JVR",
        category: "laptop",
        categoryName: "Laptop",
        price: 39990000,
        originalPrice: 44990000,
        image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 78,
        description: "Chiến hạm gaming với Intel Core i9 thế hệ 14, card đồ họa NVIDIA RTX 4070 8GB, màn hình 2.5K 240Hz chuẩn màu 100% DCI-P3 cùng tản nhiệt 3 quạt siêu mát."
    },
    {
        id: 8,
        name: "Laptop ASUS Zenbook 14 OLED UX3405",
        category: "laptop",
        categoryName: "Laptop",
        price: 26490000,
        originalPrice: 28990000,
        image: "https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: true,
        isPromo: false,
        rating: 4.7,
        reviews: 45,
        description: "Laptop cao cấp mỏng nhẹ chuẩn doanh nhân, màn hình OLED 3K 120Hz rực rỡ, chip Intel Core Ultra tích hợp AI NPU thông minh."
    },

    // 5. Nhóm Laptop Dell
    {
        id: 9,
        name: "Laptop Dell XPS 15 9530 Core i7-13700H",
        category: "laptop",
        categoryName: "Laptop",
        price: 48990000,
        originalPrice: 53990000,
        image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: false,
        isPromo: true,
        rating: 4.9,
        reviews: 53,
        description: "Kiệt tác thiết kế từ nhôm nguyên khối và sợi carbon, màn hình OLED viền InfinityEdge siêu mỏng, hiệu năng đồ họa mạnh mẽ cho creator chuyên nghiệp."
    },
    {
        id: 10,
        name: "Laptop Dell Inspiron 16 5630 Intel Core i5",
        category: "laptop",
        categoryName: "Laptop",
        price: 19990000,
        originalPrice: 21990000,
        image: "https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: false,
        isPromo: true,
        rating: 4.6,
        reviews: 38,
        description: "Màn hình 16 inch rộng rãi sắc nét tỉ lệ 16:10, hiệu năng ổn định phục vụ tốt học tập và làm việc văn phòng đa nhiệm mượt mà."
    },

    // 6. Nhóm iPad
    {
        id: 11,
        name: "iPad Pro 11 inch M4 Wi-Fi 256GB",
        category: "tablet",
        categoryName: "Máy tính bảng",
        price: 27490000,
        originalPrice: 28990000,
        image: "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 5.0,
        reviews: 89,
        description: "iPad mỏng nhất từng được Apple chế tạo, trang bị chip M4 siêu khủng, màn hình Ultra Retina XDR công nghệ Tandem OLED đỉnh cao."
    },
    {
        id: 12,
        name: "iPad Air 5 10.9 inch M1 Wi-Fi 64GB",
        category: "tablet",
        categoryName: "Máy tính bảng",
        price: 13990000,
        originalPrice: 15490000,
        image: "https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: false,
        isPromo: true,
        rating: 4.8,
        reviews: 120,
        description: "Máy tính bảng hiệu năng xuất sắc với chip Apple M1, hỗ trợ bút Apple Pencil 2 và bàn phím Magic Keyboard tiện lợi."
    },

    // 7. Nhóm Tai nghe Bluetooth
    {
        id: 13,
        name: "Tai nghe Bluetooth Apple AirPods Pro 2 USB-C",
        category: "accessory",
        categoryName: "Phụ kiện",
        price: 5490000,
        originalPrice: 6190000,
        image: "https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 215,
        description: "Khả năng chống ồn chủ động gấp 2 lần, chế độ Xuyên âm thích ứng thông minh, âm thanh không gian cá nhân hóa và cổng sạc USB-C hiện đại."
    },
    {
        id: 14,
        name: "Tai nghe Chống Ồn Cao Cấp Sony WH-1000XM5",
        category: "accessory",
        categoryName: "Phụ kiện",
        price: 6990000,
        originalPrice: 8490000,
        image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: false,
        isPromo: true,
        rating: 4.9,
        reviews: 167,
        description: "Trải nghiệm chống ồn số 1 thế giới với bộ vi xử lý V1 và QN1, chất âm Hi-Res không dây đỉnh cao cùng thời lượng pin 30 giờ liên tục."
    },

    // 8. Nhóm Chuột và Bàn phím máy tính
    {
        id: 15,
        name: "Chuột Không Dây Công Thái Học Logitech MX Master 3S",
        category: "accessory",
        categoryName: "Phụ kiện",
        price: 2090000,
        originalPrice: 2490000,
        image: "https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80",
        isFeatured: true,
        isNew: false,
        isPromo: true,
        rating: 4.9,
        reviews: 310,
        description: "Chuột không dây cao cấp với con lăn từ tính MagSpeed siêu êm, cảm biến 8000 DPI lướt mượt trên mọi bề mặt kể cả kính và kết nối đa thiết bị."
    },
    {
        id: 16,
        name: "Bàn Phím Cơ Không Dây DareU EK87 Pro White RGB",
        category: "accessory",
        categoryName: "Phụ kiện",
        price: 890000,
        originalPrice: 1190000,
        image: "https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80",
        isFeatured: false,
        isNew: true,
        isPromo: true,
        rating: 4.7,
        reviews: 98,
        description: "Bàn phím cơ layout 87 phím gọn gàng, switch độc quyền DareU mượt mà gõ cực êm, đèn LED RGB đa hiệu ứng và 3 chế độ kết nối Bluetooth/2.4G/Dây."
    }
];

// =============================================================
// PHẦN 2: CÁC TIỆN ÍCH HỖ TRỢ (HELPERS)
// =============================================================

// Định dạng tiền tệ VNĐ (Ví dụ: 32.490.000 ₫)
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Xử lý khi ảnh lỗi: Thay bằng SVG Placeholder chất lượng cao
function handleImageError(imgElement, productName) {
    const safeName = productName ? encodeURIComponent(productName) : "TechStore";
    imgElement.src = `data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300"><rect width="400" height="300" fill="%23f1f5f9"/><text x="50%" y="45%" dominant-baseline="middle" text-anchor="middle" fill="%230d6efd" font-family="sans-serif" font-weight="bold" font-size="20">TECH STORE</text><text x="50%" y="60%" dominant-baseline="middle" text-anchor="middle" fill="%2364748b" font-family="sans-serif" font-size="14">${safeName}</text></svg>`;
}

// Hiển thị thông báo Toast đẹp mắt
function showToast(message, type = 'success') {
    const toastEl = document.getElementById('notificationToast');
    if (!toastEl) {
        alert(message);
        return;
    }
    const toastBody = document.getElementById('toastMessage');
    const toastHeader = document.getElementById('toastHeaderTitle');
    const toastIcon = document.getElementById('toastIcon');

    if (toastBody) toastBody.innerText = message;
    if (toastHeader) {
        toastHeader.innerText = type === 'success' ? 'Thành công' : (type === 'error' ? 'Thông báo lỗi' : 'Thông báo');
    }
    if (toastIcon) {
        toastIcon.className = type === 'success' 
            ? 'fa-solid fa-circle-check text-success me-2' 
            : 'fa-solid fa-circle-exclamation text-danger me-2';
    }

    if (window.bootstrap && bootstrap.Toast) {
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    } else {
        alert(message);
    }
}

// =============================================================
// PHẦN 3: TẠO THẺ SẢN PHẨM HTML (PRODUCT CARD TEMPLATE)
// =============================================================
function createProductCardHTML(product) {
    // Tính phần trăm giảm giá nếu có
    let discountPercent = 0;
    if (product.originalPrice && product.originalPrice > product.price) {
        discountPercent = Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100);
    }

    // Các nhãn dán (Badge)
    let badgesHTML = '';
    if (product.isFeatured) {
        badgesHTML += `<span class="badge-pill-custom badge-hot"><i class="fa-solid fa-fire me-1"></i>Hot</span>`;
    }
    if (product.isNew) {
        badgesHTML += `<span class="badge-pill-custom badge-new"><i class="fa-solid fa-sparkles me-1"></i>Mới</span>`;
    }
    if (discountPercent > 0) {
        badgesHTML += `<span class="badge-pill-custom badge-sale">-${discountPercent}%</span>`;
    }

    return `
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <div class="product-card h-100">
            <!-- Nhãn huy hiệu -->
            <div class="product-badge-group">
                ${badgesHTML}
            </div>

            <!-- Hình ảnh sản phẩm -->
            <a href="javascript:void(0)" class="product-thumb-link" onclick="showProductDetail(${product.id})">
                <img src="${product.image}" 
                     alt="${product.name}" 
                     class="product-thumb" 
                     loading="lazy"
                     onerror="handleImageError(this, '${product.name.replace(/'/g, "\\'")}')">
            </a>

            <!-- Thông tin sản phẩm -->
            <div class="product-info">
                <div class="product-category">${product.categoryName}</div>
                <h5 class="product-title" title="${product.name}">
                    <a href="javascript:void(0)" onclick="showProductDetail(${product.id})">${product.name}</a>
                </h5>

                <div class="product-rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span>(${product.reviews})</span>
                </div>

                <!-- Khối giá -->
                <div class="product-price-box">
                    <span class="product-price">${formatCurrency(product.price)}</span>
                    ${product.originalPrice ? `<span class="product-old-price">${formatCurrency(product.originalPrice)}</span>` : ''}
                </div>

                <!-- Nút thao tác -->
                <div class="product-action-group">
                    <button class="btn-detail" type="button" onclick="showProductDetail(${product.id})">
                        <i class="fa-regular fa-eye"></i> Chi tiết
                    </button>
                    <button class="btn-add-cart" type="button" onclick="addToCart(${product.id})">
                        <i class="fa-solid fa-cart-plus"></i> Thêm giỏ
                    </button>
                </div>
            </div>
        </div>
    </div>
    `;
}

// =============================================================
// PHẦN 4: RENDER SẢN PHẨM TRANG CHỦ
// =============================================================
function renderHomePageProducts() {
    // 1. Sản phẩm nổi bật
    const featuredContainer = document.getElementById('featuredProductsContainer');
    if (featuredContainer) {
        const featuredList = PRODUCTS.filter(p => p.isFeatured);
        featuredContainer.innerHTML = featuredList.map(createProductCardHTML).join('');
    }

    // 2. Sản phẩm mới nhất
    const newestContainer = document.getElementById('newestProductsContainer');
    if (newestContainer) {
        const newestList = PRODUCTS.filter(p => p.isNew);
        newestContainer.innerHTML = newestList.map(createProductCardHTML).join('');
    }

    // 3. Sản phẩm khuyến mãi
    const promoContainer = document.getElementById('promoProductsContainer');
    if (promoContainer) {
        const promoList = PRODUCTS.filter(p => p.isPromo && p.originalPrice > p.price);
        promoContainer.innerHTML = promoList.map(createProductCardHTML).join('');
    }
}

// =============================================================
// PHẦN 5: LỌC DANH MỤC VÀ TÌM KIẾM SẢN PHẨM
// =============================================================

// Lọc sản phẩm theo danh mục khi bấm trên Menu hoặc Banner danh mục
function filterCategory(categoryKey) {
    const filterSection = document.getElementById('categoryFilterSection');
    const filterContainer = document.getElementById('filteredProductsContainer');
    const filterTitle = document.getElementById('filteredCategoryTitle');

    if (!filterSection || !filterContainer) return;

    let filtered = [];
    let titleText = "Tất cả sản phẩm";

    if (categoryKey === 'all') {
        filtered = PRODUCTS;
        titleText = "Tất cả sản phẩm công nghệ";
    } else if (categoryKey === 'promo') {
        filtered = PRODUCTS.filter(p => p.isPromo);
        titleText = "Sản phẩm đang khuyến mãi giảm giá";
    } else {
        filtered = PRODUCTS.filter(p => p.category === categoryKey);
        const mapName = {
            phone: "Điện thoại thông minh (iPhone, Samsung)",
            laptop: "Máy tính Laptop (MacBook, ASUS, Dell)",
            tablet: "Máy tính bảng iPad",
            accessory: "Phụ kiện (Tai nghe, Chuột & Bàn phím)"
        };
        titleText = mapName[categoryKey] || "Sản phẩm theo danh mục";
    }

    if (filterTitle) {
        filterTitle.innerHTML = `<i class="fa-solid fa-layer-group text-primary me-2"></i> ${titleText} (${filtered.length})`;
    }

    filterContainer.innerHTML = filtered.length > 0 
        ? filtered.map(createProductCardHTML).join('')
        : `<div class="col-12 text-center py-5"><i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i><p class="text-muted">Không tìm thấy sản phẩm nào trong mục này!</p></div>`;

    // Hiển thị khu vực lọc và cuộn xuống
    filterSection.style.display = 'block';
    filterSection.scrollIntoView({ behavior: 'smooth' });
}

// Tìm kiếm sản phẩm theo tên
function handleSearch(event) {
    if (event) event.preventDefault();

    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    const keyword = searchInput.value.trim().toLowerCase();
    if (!keyword) {
        showToast('Vui lòng nhập từ khóa để tìm kiếm!', 'error');
        return;
    }

    const matchedProducts = PRODUCTS.filter(p => 
        p.name.toLowerCase().includes(keyword) || 
        p.categoryName.toLowerCase().includes(keyword) ||
        p.description.toLowerCase().includes(keyword)
    );

    const filterSection = document.getElementById('categoryFilterSection');
    const filterContainer = document.getElementById('filteredProductsContainer');
    const filterTitle = document.getElementById('filteredCategoryTitle');

    if (filterSection && filterContainer && filterTitle) {
        filterSection.style.display = 'block';
        filterTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-primary me-2"></i> Kết quả tìm kiếm cho: "${keyword}" (${matchedProducts.length})`;

        filterContainer.innerHTML = matchedProducts.length > 0 
            ? matchedProducts.map(createProductCardHTML).join('')
            : `<div class="col-12 text-center py-5">
                    <i class="fa-regular fa-face-frown fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy sản phẩm nào khớp với "${keyword}"</h5>
                    <p class="text-muted">Hãy thử tìm kiếm với các từ khóa như "iPhone", "MacBook", "Dell", "Chuột"...</p>
               </div>`;

        filterSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// =============================================================
// PHẦN 6: XEM CHI TIẾT SẢN PHẨM (MODAL POPUP)
// =============================================================
function showProductDetail(productId) {
    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    const modalBody = document.getElementById('productDetailModalBody');
    if (!modalBody) return;

    let discountPercent = 0;
    if (product.originalPrice && product.originalPrice > product.price) {
        discountPercent = Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100);
    }

    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6 text-center mb-3 mb-md-0">
                <img src="${product.image}" 
                     alt="${product.name}" 
                     class="img-fluid rounded" 
                     style="max-height: 320px; object-fit: contain;"
                     onerror="handleImageError(this, '${product.name.replace(/'/g, "\\'")}')">
            </div>
            <div class="col-md-6">
                <span class="badge bg-primary mb-2">${product.categoryName}</span>
                <h4 class="fw-bold mb-2">${product.name}</h4>
                <div class="text-warning mb-2">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span class="text-muted ms-1">(${product.reviews} đánh giá)</span>
                </div>
                <div class="mb-3">
                    <span class="h3 fw-bold text-danger me-2">${formatCurrency(product.price)}</span>
                    ${product.originalPrice ? `<span class="text-muted text-decoration-line-through">${formatCurrency(product.originalPrice)}</span>` : ''}
                    ${discountPercent > 0 ? `<span class="badge bg-danger ms-2">Tiết kiệm ${discountPercent}%</span>` : ''}
                </div>
                <p class="text-secondary mb-3">${product.description}</p>
                
                <div class="p-3 bg-light rounded mb-3 small">
                    <div class="mb-1"><i class="fa-solid fa-shield-halved text-success me-2"></i>Bảo hành chính hãng 12 tháng</div>
                    <div class="mb-1"><i class="fa-solid fa-truck-fast text-primary me-2"></i>Miễn phí vận chuyển toàn quốc</div>
                    <div><i class="fa-solid fa-arrows-rotate text-info me-2"></i>Lỗi 1 đổi 1 trong 30 ngày</div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1" onclick="addToCart(${product.id}); bootstrap.Modal.getInstance(document.getElementById('productDetailModal')).hide();">
                        <i class="fa-solid fa-cart-plus me-1"></i> Thêm vào giỏ hàng
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    `;

    // Mở modal
    const modalEl = document.getElementById('productDetailModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

// =============================================================
// PHẦN 7: QUẢN LÝ GIỎ HÀNG VỚI LOCALSTORAGE
// =============================================================
const CART_STORAGE_KEY = 'techstore_cart';

// Lấy danh sách giỏ hàng từ LocalStorage
function getCart() {
    const data = localStorage.getItem(CART_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

// Lưu danh sách giỏ hàng vào LocalStorage
function saveCart(cart) {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
    updateCartUI();
}

// Cập nhật số lượng trên icon giỏ hàng và danh sách trong Modal
function updateCartUI() {
    const cart = getCart();
    
    // Cập nhật số lượng trên header badge
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartBadgeCount');
    if (cartBadge) {
        cartBadge.innerText = totalCount;
        cartBadge.style.display = totalCount > 0 ? 'flex' : 'none';
    }

    // Cập nhật nội dung hiển thị trong modal/offcanvas giỏ hàng
    renderCartModal(cart);
}

// Thêm sản phẩm vào giỏ hàng
function addToCart(productId) {
    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    let cart = getCart();
    const existingIndex = cart.findIndex(item => item.id === productId);

    if (existingIndex > -1) {
        cart[existingIndex].quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }

    saveCart(cart);
    showToast(`Đã thêm "${product.name}" vào giỏ hàng!`, 'success');
}

// Tăng / Giảm số lượng sản phẩm trong giỏ hàng
function changeCartQuantity(productId, delta) {
    let cart = getCart();
    const item = cart.find(i => i.id === productId);
    if (!item) return;

    item.quantity += delta;
    if (item.quantity <= 0) {
        cart = cart.filter(i => i.id !== productId);
    }

    saveCart(cart);
}

// Xóa sản phẩm khỏi giỏ hàng
function removeCartItem(productId) {
    let cart = getCart();
    cart = cart.filter(i => i.id !== productId);
    saveCart(cart);
    showToast('Đã xóa sản phẩm khỏi giỏ hàng!', 'info');
}

// Xóa sạch toàn bộ giỏ hàng
function clearCart() {
    if (confirm('Bạn có chắc chắn muốn làm trống giỏ hàng?')) {
        saveCart([]);
        showToast('Giỏ hàng đã được làm trống!', 'info');
    }
}

// Render dữ liệu giỏ hàng vào Modal
function renderCartModal(cart) {
    const cartContainer = document.getElementById('cartItemsContainer');
    const cartTotalPrice = document.getElementById('cartTotalPrice');
    const cartActionFooter = document.getElementById('cartActionFooter');

    if (!cartContainer) return;

    if (cart.length === 0) {
        cartContainer.innerHTML = `
            <div class="text-center py-5">
                <i class="fa-solid fa-cart-shopping fa-3x text-muted mb-3 opacity-50"></i>
                <h6 class="text-muted">Giỏ hàng của bạn đang trống!</h6>
                <p class="small text-muted mb-3">Hãy chọn thêm các sản phẩm công nghệ yêu thích nhé.</p>
                <button class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Tiếp tục mua sắm</button>
            </div>
        `;
        if (cartTotalPrice) cartTotalPrice.innerText = formatCurrency(0);
        if (cartActionFooter) cartActionFooter.style.display = 'none';
        return;
    }

    let total = 0;
    cartContainer.innerHTML = cart.map(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        return `
            <div class="d-flex align-items-center justify-content-between p-2 border-bottom">
                <img src="${item.image}" alt="${item.name}" class="rounded me-3" style="width: 55px; height: 55px; object-fit: contain;" onerror="handleImageError(this, '${item.name.replace(/'/g, "\\'")}')">
                <div class="flex-grow-1 me-2">
                    <h6 class="mb-1 text-truncate" style="max-width: 220px;" title="${item.name}">${item.name}</h6>
                    <div class="text-danger small fw-bold">${formatCurrency(item.price)}</div>
                </div>
                <div class="d-flex align-items-center gap-1 me-3">
                    <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeCartQuantity(${item.id}, -1)">-</button>
                    <span class="px-2 fw-bold small">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeCartQuantity(${item.id}, 1)">+</button>
                </div>
                <div class="text-end">
                    <div class="fw-bold small text-primary mb-1">${formatCurrency(itemTotal)}</div>
                    <button class="btn btn-sm text-danger p-0 border-0" onclick="removeCartItem(${item.id})" title="Xóa">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');

    if (cartTotalPrice) cartTotalPrice.innerText = formatCurrency(total);
    if (cartActionFooter) cartActionFooter.style.display = 'flex';
}

// Xử lý nút thanh toán Demo
function handleCheckoutDemo() {
    const cart = getCart();
    if (cart.length === 0) {
        showToast('Giỏ hàng trống!', 'error');
        return;
    }
    alert('Cảm ơn bạn đã trải nghiệm TECH STORE!\nĐây là website demo bài tập Front-End, giỏ hàng của bạn đã được xử lý mô phỏng thành công.');
    saveCart([]);
    const modalEl = document.getElementById('cartModal');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }
}

// =============================================================
// PHẦN 8: XỬ LÝ ĐĂNG KÝ / ĐĂNG NHẬP / ĐĂNG XUẤT VỚI LOCALSTORAGE
// =============================================================
const AUTH_STORAGE_KEY = 'techstore_user';             // Lưu phiên người dùng hiện tại đang đăng nhập
const REGISTERED_USERS_KEY = 'techstore_registered_users'; // Lưu danh sách các tài khoản khách hàng đã đăng ký

// Thông tin tài khoản Admin mặc định cố định
const ADMIN_CREDENTIALS = {
    username: "admin",
    password: "admin123",
    fullName: "Quản trị viên (Admin)",
    role: "admin"
};

// 1. Lấy thông tin phiên người dùng đang đăng nhập
function getCurrentUser() {
    const data = localStorage.getItem(AUTH_STORAGE_KEY);
    return data ? JSON.parse(data) : null;
}

// 2. Lấy danh sách toàn bộ khách hàng đã đăng ký trong LocalStorage
function getRegisteredUsers() {
    const data = localStorage.getItem(REGISTERED_USERS_KEY);
    return data ? JSON.parse(data) : [];
}

// 3. Lưu một khách hàng mới vào danh sách trong LocalStorage
function saveRegisteredUser(newUser) {
    const users = getRegisteredUsers();
    users.push(newUser);
    localStorage.setItem(REGISTERED_USERS_KEY, JSON.stringify(users));
}

// 4. Cập nhật hiển thị giao diện Header theo trạng thái đăng nhập và phân quyền
function updateAuthUI() {
    const user = getCurrentUser();

    // Các phần tử hiển thị trên Header
    const guestBox = document.getElementById('authGuestBox');             // Box chứa nút Đăng nhập
    const userBox = document.getElementById('authUserBox');               // Box chứa Tên + Nút Đăng xuất
    const userNameSpan = document.getElementById('authUserName');         // Thẻ span tên người dùng
    const userBadge = document.getElementById('authUserBadge');           // Huy hiệu (ADMIN hoặc KHÁCH HÀNG)
    const userIcon = document.getElementById('authUserIcon');             // Biểu tượng bên cạnh tên
    const adminNavLink = document.getElementById('adminNavLink');         // Link menu Quản trị trên Navbar
    const adminDashboardLink = document.getElementById('adminDashboardLink'); // Link menu Quản trị trong Dropdown

    if (user) {
        // =======================================================
        // TRƯỜNG HỢP 1: ĐÃ ĐĂNG NHẬP (ADMIN HOẶC KHÁCH HÀNG)
        // =======================================================
        // 1.1. Ẩn hoàn toàn nút Đăng nhập
        if (guestBox) {
            guestBox.style.setProperty('display', 'none', 'important');
            guestBox.classList.add('d-none');
        }

        // 1.2. Hiển thị khối thông tin người dùng
        if (userBox) {
            userBox.style.setProperty('display', 'flex', 'important');
            userBox.classList.remove('d-none');
        }

        // 1.3. Cập nhật tên hiển thị
        if (userNameSpan) {
            userNameSpan.innerText = user.fullName || user.username;
        }

        // 1.4. Phân quyền hiển thị theo Vai trò (Role)
        if (user.role === 'admin') {
            // --- TÀI KHOẢN ADMIN ---
            if (userBadge) {
                userBadge.innerText = 'ADMIN';
                userBadge.className = 'admin-badge ms-1';
            }
            if (userIcon) {
                userIcon.className = 'fa-solid fa-user-shield text-primary';
            }
            // Hiện chức năng quản trị
            if (adminNavLink) {
                adminNavLink.style.setProperty('display', 'block', 'important');
                adminNavLink.classList.remove('d-none');
            }
            if (adminDashboardLink) {
                adminDashboardLink.style.display = 'block';
            }
        } else {
            // --- TÀI KHOẢN KHÁCH HÀNG (CUSTOMER) ---
            if (userBadge) {
                userBadge.innerText = 'KHÁCH HÀNG';
                userBadge.className = 'customer-badge ms-1';
            }
            if (userIcon) {
                userIcon.className = 'fa-solid fa-circle-user text-primary';
            }
            // Khách hàng KHÔNG được thấy menu Quản trị
            if (adminNavLink) {
                adminNavLink.style.setProperty('display', 'none', 'important');
                adminNavLink.classList.add('d-none');
            }
            if (adminDashboardLink) {
                adminDashboardLink.style.display = 'none';
            }
        }
    } else {
        // =======================================================
        // TRƯỜNG HỢP 2: CHƯA ĐĂNG NHẬP HOẶC ĐÃ ĐĂNG XUẤT
        // =======================================================
        // 2.1. Hiển thị lại nút Đăng nhập
        if (guestBox) {
            guestBox.style.setProperty('display', 'flex', 'important');
            guestBox.classList.remove('d-none');
        }

        // 2.2. Ẩn hoàn toàn khối thông tin người dùng
        if (userBox) {
            userBox.style.setProperty('display', 'none', 'important');
            userBox.classList.add('d-none');
        }

        // 2.3. Ẩn menu Quản trị trên thanh điều hướng
        if (adminNavLink) {
            adminNavLink.style.setProperty('display', 'none', 'important');
            adminNavLink.classList.add('d-none');
        }
    }
}

// 5. Hàm xử lý khi người dùng nhấn submit Form Đăng Ký
function handleRegisterFormSubmit(event) {
    if (event) event.preventDefault();

    const fullNameInput = document.getElementById('registerFullName');
    const usernameInput = document.getElementById('registerUsername');
    const emailInput = document.getElementById('registerEmail');
    const phoneInput = document.getElementById('registerPhone');
    const passwordInput = document.getElementById('registerPassword');
    const confirmPasswordInput = document.getElementById('registerConfirmPassword');
    const agreeCheckbox = document.getElementById('registerAgree');
    const alertBox = document.getElementById('registerAlert');

    if (!fullNameInput || !usernameInput || !emailInput || !phoneInput || !passwordInput || !confirmPasswordInput) {
        return;
    }

    const fullName = fullNameInput.value.trim();
    const username = usernameInput.value.trim().toLowerCase();
    const email = emailInput.value.trim().toLowerCase();
    const phone = phoneInput.value.trim();
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    // Helper hiển thị thông báo lỗi
    function showError(message) {
        if (alertBox) {
            alertBox.className = 'alert alert-danger mb-3';
            alertBox.innerHTML = `<i class="fa-solid fa-triangle-exclamation me-2"></i> ${message}`;
            alertBox.style.display = 'block';
            alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            alert(message);
        }
    }

    // --- BƯỚC 1: KIỂM TRA KHÔNG ĐƯỢC ĐỂ TRỐNG THÔNG TIN ---
    if (!fullName) {
        showError('Vui lòng nhập Họ và tên của bạn!');
        fullNameInput.focus();
        return;
    }
    if (!username) {
        showError('Vui lòng nhập Tên đăng nhập!');
        usernameInput.focus();
        return;
    }
    if (!email) {
        showError('Vui lòng nhập Địa chỉ Email!');
        emailInput.focus();
        return;
    }
    if (!phone) {
        showError('Vui lòng nhập Số điện thoại!');
        phoneInput.focus();
        return;
    }
    if (!password) {
        showError('Vui lòng nhập Mật khẩu!');
        passwordInput.focus();
        return;
    }
    if (!confirmPassword) {
        showError('Vui lòng nhập Xác nhận lại mật khẩu!');
        confirmPasswordInput.focus();
        return;
    }

    // --- BƯỚC 2: KIỂM TRA HỌ VÀ TÊN HỢP LỆ ---
    if (fullName.length < 2) {
        showError('Họ và tên phải có ít nhất 2 ký tự!');
        fullNameInput.focus();
        return;
    }

    // --- BƯỚC 3: KIỂM TRA TÊN ĐĂNG NHẬP ---
    // Không được là 'admin'
    if (username === ADMIN_CREDENTIALS.username.toLowerCase()) {
        showError("Tên đăng nhập 'admin' là tài khoản quản trị hệ thống, bạn không thể đăng ký tên này!");
        usernameInput.focus();
        return;
    }
    // Độ dài tối thiểu 3 ký tự, chỉ gồm chữ cái, số, dấu gạch dưới
    const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
    if (!usernameRegex.test(username)) {
        showError('Tên đăng nhập từ 3 đến 20 ký tự, viết liền không dấu, không chứa ký tự đặc biệt!');
        usernameInput.focus();
        return;
    }

    // --- BƯỚC 4: KIỂM TRA EMAIL HỢP LỆ ---
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('Địa chỉ email không đúng định dạng (Ví dụ: name@example.com)!');
        emailInput.focus();
        return;
    }

    // --- BƯỚC 5: KIỂM TRA SỐ ĐIỆN THOẠI HỢP LỆ (10 số, bắt đầu số 0) ---
    const phoneRegex = /^0[0-9]{9}$/;
    if (!phoneRegex.test(phone)) {
        showError('Số điện thoại không hợp lệ! Vui lòng nhập đúng 10 chữ số bắt đầu bằng số 0 (Ví dụ: 0988123456).');
        phoneInput.focus();
        return;
    }

    // --- BƯỚC 6: KIỂM TRA TRÙNG LẶP TRONG DANH SÁCH KHÁCH HÀNG ĐÃ ĐĂNG KÝ ---
    const registeredUsers = getRegisteredUsers();

    // Kiểm tra trùng username
    const isUsernameTaken = registeredUsers.some(u => u.username.toLowerCase() === username);
    if (isUsernameTaken) {
        showError(`Tên đăng nhập "${username}" đã có người sử dụng! Vui lòng chọn tên đăng nhập khác.`);
        usernameInput.focus();
        return;
    }

    // Kiểm tra trùng email
    const isEmailTaken = registeredUsers.some(u => u.email.toLowerCase() === email);
    if (isEmailTaken) {
        showError(`Địa chỉ email "${email}" đã được đăng ký tài khoản khác! Vui lòng dùng email khác hoặc Đăng nhập.`);
        emailInput.focus();
        return;
    }

    // --- BƯỚC 7: KIỂM TRA MẬT KHẨU TỐI THIỂU 6 KÝ TỰ ---
    if (password.length < 6) {
        showError('Mật khẩu phải có tối thiểu 6 ký tự để đảm bảo an toàn!');
        passwordInput.focus();
        return;
    }

    // --- BƯỚC 8: KIỂM TRA MẬT KHẨU NHẬP LẠI PHẢI TRÙNG KHỚP ---
    if (password !== confirmPassword) {
        showError('Mật khẩu nhập lại không trùng khớp với mật khẩu đã nhập!');
        confirmPasswordInput.focus();
        return;
    }

    // --- BƯỚC 9: KIỂM TRA ĐIỀU KHOẢN ---
    if (agreeCheckbox && !agreeCheckbox.checked) {
        showError('Vui lòng đánh dấu đồng ý với Điều khoản dịch vụ của TECH STORE!');
        return;
    }

    // --- BƯỚC 10: TẤT CẢ HỢP LỆ -> LƯU TÀI KHOẢN VÀO LOCALSTORAGE ---
    const newCustomer = {
        fullName: fullName,
        username: username,
        email: email,
        phone: phone,
        password: password,
        role: 'customer', // Mặc định là quyền Khách hàng (không bao giờ là Admin)
        createdAt: new Date().toISOString()
    };

    saveRegisteredUser(newCustomer);

    // Hiển thị thông báo thành công
    if (alertBox) {
        alertBox.className = 'alert alert-success mb-3';
        alertBox.innerHTML = `
            <i class="fa-solid fa-circle-check me-2"></i>
            <strong>Đăng ký tài khoản thành công!</strong><br>
            Tài khoản <b>${username}</b> đã sẵn sàng. Đang chuyển hướng về trang Đăng nhập...
        `;
        alertBox.style.display = 'block';
    }

    showToast(`Chúc mừng ${fullName}! Bạn đã đăng ký tài khoản thành công.`, 'success');

    // Chuyển hướng về trang đăng nhập sau 1.2 giây
    setTimeout(() => {
        window.location.href = 'index.php?action=login';
    }, 1200);
}

// 6. Hàm xử lý khi người dùng nhấn submit Form Đăng Nhập (Hỗ trợ cả Admin và Khách Hàng)
function handleLoginFormSubmit(event) {
    if (event) event.preventDefault();

    const usernameInput = document.getElementById('loginUsername');
    const passwordInput = document.getElementById('loginPassword');
    const alertBox = document.getElementById('loginAlert');

    if (!usernameInput || !passwordInput) return;

    const inputAccount = usernameInput.value.trim().toLowerCase();
    const inputPassword = passwordInput.value.trim();

    // 1. Kiểm tra để trống
    if (!inputAccount || !inputPassword) {
        if (alertBox) {
            alertBox.className = 'alert alert-warning mb-3';
            alertBox.innerText = 'Vui lòng nhập đầy đủ tài khoản và mật khẩu!';
            alertBox.style.display = 'block';
        }
        return;
    }

    // 2. TRƯỜNG HỢP A: ĐĂNG NHẬP VỚI TÀI KHOẢN ADMIN (admin / admin123)
    if (inputAccount === ADMIN_CREDENTIALS.username.toLowerCase() && inputPassword === ADMIN_CREDENTIALS.password) {
        const adminData = {
            username: ADMIN_CREDENTIALS.username,
            fullName: ADMIN_CREDENTIALS.fullName,
            role: ADMIN_CREDENTIALS.role, // role: 'admin'
            loginAt: new Date().toISOString()
        };
        localStorage.setItem(AUTH_STORAGE_KEY, JSON.stringify(adminData));

        if (alertBox) {
            alertBox.className = 'alert alert-success mb-3';
            alertBox.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Đăng nhập Admin thành công! Đang chuyển hướng...';
            alertBox.style.display = 'block';
        }

        updateAuthUI();

        setTimeout(() => {
            window.location.href = 'index.php';
        }, 800);
        return;
    }

    // 3. TRƯỜNG HỢP B: ĐĂNG NHẬP VỚI TÀI KHOẢN KHÁCH HÀNG VỪA ĐĂNG KÝ
    const registeredUsers = getRegisteredUsers();
    // Cho phép khách hàng đăng nhập bằng Tên đăng nhập HOẶC Email
    const matchedCustomer = registeredUsers.find(u => 
        (u.username.toLowerCase() === inputAccount || u.email.toLowerCase() === inputAccount) && 
        u.password === inputPassword
    );

    if (matchedCustomer) {
        const customerData = {
            username: matchedCustomer.username,
            fullName: matchedCustomer.fullName,
            email: matchedCustomer.email,
            phone: matchedCustomer.phone,
            role: 'customer', // Luôn luôn là quyền Khách hàng
            loginAt: new Date().toISOString()
        };
        localStorage.setItem(AUTH_STORAGE_KEY, JSON.stringify(customerData));

        if (alertBox) {
            alertBox.className = 'alert alert-success mb-3';
            alertBox.innerHTML = `<i class="fa-solid fa-circle-check me-2"></i> Đăng nhập thành công! Xin chào <b>${matchedCustomer.fullName}</b>...`;
            alertBox.style.display = 'block';
        }

        updateAuthUI();

        setTimeout(() => {
            window.location.href = 'index.php';
        }, 800);
        return;
    }

    // 4. TRƯỜNG HỢP C: SAI TÀI KHOẢN HOẶC MẬT KHẨU
    if (alertBox) {
        alertBox.className = 'alert alert-danger mb-3';
        alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i> Sai tài khoản hoặc mật khẩu! Vui lòng kiểm tra lại hoặc nhấn <b>Đăng ký ngay</b>.';
        alertBox.style.display = 'block';
    }
    passwordInput.value = '';
    passwordInput.focus();
}

// 7. Hàm xử lý Đăng xuất
function handleLogout() {
    if (confirm('Bạn có chắc chắn muốn đăng xuất tài khoản?')) {
        // Xóa trạng thái đăng nhập khỏi LocalStorage
        localStorage.removeItem(AUTH_STORAGE_KEY);

        // Cập nhật giao diện ngay lập tức
        updateAuthUI();

        showToast('Đã đăng xuất thành công!', 'info');

        // Nếu đang ở trang Quản trị (Admin), điều hướng về trang chủ
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('action') === 'admin') {
            window.location.href = 'index.php';
        }
    }
}

// 8. Kiểm tra bảo vệ trang Quản trị (Admin Page Guard)
function checkAdminAccess() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'admin') {
        const user = getCurrentUser();
        // 1. Chưa đăng nhập
        if (!user) {
            alert('Bạn chưa đăng nhập! Vui lòng đăng nhập với tài khoản Admin.');
            window.location.href = 'index.php?action=login';
            return false;
        }
        // 2. Đã đăng nhập nhưng là Khách hàng (không phải Admin)
        if (user.role !== 'admin') {
            alert('Cảnh báo: Tài khoản khách hàng không có quyền truy cập trang quản trị Admin!');
            window.location.href = 'index.php';
            return false;
        }
    }
    return true;
}

// =============================================================
// PHẦN 9: KHỞI TẠO ỨNG DỤNG KHI TẢI TRANG (INIT ON DOM READY)
// =============================================================
document.addEventListener('DOMContentLoaded', () => {
    // 1. Kiểm tra quyền truy cập nếu đang ở trang Admin
    if (!checkAdminAccess()) return;

    // 2. Cập nhật trạng thái đăng nhập trên giao diện Header
    updateAuthUI();

    // 3. Cập nhật giỏ hàng trên giao diện
    updateCartUI();

    // 4. Render sản phẩm trang chủ nếu đang ở trang chủ
    renderHomePageProducts();

    // 5. Lắng nghe sự kiện form tìm kiếm
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }

    // 6. Lắng nghe sự kiện form đăng nhập nếu đang ở trang login
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLoginFormSubmit);
    }

    // 7. Lắng nghe sự kiện form đăng ký nếu đang ở trang register
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegisterFormSubmit);
    }
});
