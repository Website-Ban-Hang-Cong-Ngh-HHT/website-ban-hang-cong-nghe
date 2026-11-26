/**
 * TECH STORE - JAVASCRIPT XỬ LÝ CHỨC NĂNG WEBSITE
 * -------------------------------------------------------------
 * Đối tượng: Sinh viên mới học Front-End & Phát triển dự án với AI
 * Công nghệ: JavaScript thuần (Vanilla JS), LocalStorage
 * Chức năng:
 *  1. Quản lý sản phẩm theo mô hình biến thể (Product Variants: Màu sắc, Dung lượng, SKU, Giá, Tồn kho)
 *  2. Trang chủ hiển thị 1 sản phẩm duy nhất cho mỗi model (ví dụ: iPhone 15)
 *  3. Modal xem chi tiết và chọn biến thể: Tự động đổi giá, ảnh, tình trạng kho theo Màu & Dung lượng
 *  4. Giỏ hàng lưu và phân biệt từng phiên bản biến thể riêng biệt
 *  5. Đặt hàng kiểm tra và trừ tồn kho của đúng phiên bản
 *  6. Quản trị Admin: Xem 1 dòng cho mỗi model, xem và quản lý tất cả các biến thể (Thêm, Sửa, Xóa biến thể)
 *  7. Đăng ký, đăng nhập tài khoản Khách hàng và Admin (admin / admin123)
 */

// =============================================================
// PHẦN 1: DANH SÁCH SẢN PHẨM MẪU VỚI BIẾN THỂ (PRODUCT VARIANTS)
// =============================================================
const DEFAULT_PRODUCTS = [
    // ---------------------------------------------------------
    // 1. iPhone 15 (Mô hình sản phẩm chuẩn theo yêu cầu đề bài)
    // ---------------------------------------------------------
    {
        id: 1,
        name: "iPhone 15",
        brand: "Apple",
        category: "phone",
        categoryName: "Điện thoại",
        image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80",
        description: "iPhone 15 đột phá với màn hình Dynamic Island thông minh, camera chính 48MP sắc nét gấp 4 lần, cổng sạc USB-C hiện đại và mặt lưng kính pha màu bền bỉ tuyệt đẹp.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 245,
        // Danh sách màu sắc
        colors: [
            { name: "Đen", hex: "#1f2937", image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80" },
            { name: "Xanh dương", hex: "#38bdf8", image: "https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80" },
            { name: "Hồng", hex: "#f472b6", image: "https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=600&auto=format&fit=crop&q=80" },
            { name: "Vàng", hex: "#facc15", image: "https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=600&auto=format&fit=crop&q=80" }
        ],
        // Danh sách dung lượng
        storages: ["128GB", "256GB", "512GB"],
        // Danh sách các tổ hợp biến thể thực tế (SKU, Màu, Dung lượng, Giá bán, Giá gốc, Tồn kho)
        variants: [
            {
                sku: "IP15-BLK-128",
                color: "Đen",
                storage: "128GB",
                price: 18000000,
                originalPrice: 20000000,
                stock: 20,
                image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-BLK-256",
                color: "Đen",
                storage: "256GB",
                price: 20000000,
                originalPrice: 22500000,
                stock: 15,
                image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-BLK-512",
                color: "Đen",
                storage: "512GB",
                price: 24000000,
                originalPrice: 26500000,
                stock: 8,
                image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-BLU-128",
                color: "Xanh dương",
                storage: "128GB",
                price: 18000000,
                originalPrice: 20000000,
                stock: 18,
                image: "https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-BLU-256",
                color: "Xanh dương",
                storage: "256GB",
                price: 20500000,
                originalPrice: 23000000,
                stock: 12,
                image: "https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-PNK-128",
                color: "Hồng",
                storage: "128GB",
                price: 18500000,
                originalPrice: 20500000,
                stock: 10,
                image: "https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-PNK-256",
                color: "Hồng",
                storage: "256GB",
                price: 21000000,
                originalPrice: 23500000,
                stock: 7,
                image: "https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=600&auto=format&fit=crop&q=80"
            },
            {
                sku: "IP15-YEL-128",
                color: "Vàng",
                storage: "128GB",
                price: 18000000,
                originalPrice: 20000000,
                stock: 0, // Hết hàng để kiểm tra trường hợp tồn kho = 0!
                image: "https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=600&auto=format&fit=crop&q=80"
            }
        ]
    },

    // ---------------------------------------------------------
    // 2. iPhone 16 Pro Max
    // ---------------------------------------------------------
    {
        id: 2,
        name: "iPhone 16 Pro Max",
        brand: "Apple",
        category: "phone",
        categoryName: "Điện thoại",
        image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80",
        description: "iPhone 16 Pro Max với chip A18 Pro mạnh mẽ, khung viền Titan siêu bền nhẹ, nút Điều khiển Camera tiện lợi và màn hình 6.9 inch lớn nhất từng có.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 5.0,
        reviews: 312,
        colors: [
            { name: "Titan Tự Nhiên", hex: "#9ca3af", image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80" },
            { name: "Titan Sa Mạc", hex: "#d97706", image: "https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600&auto=format&fit=crop&q=80" },
            { name: "Titan Đen", hex: "#111827", image: "https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["256GB", "512GB", "1TB"],
        variants: [
            { sku: "IP16PM-NAT-256", color: "Titan Tự Nhiên", storage: "256GB", price: 34990000, originalPrice: 36990000, stock: 25, image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80" },
            { sku: "IP16PM-NAT-512", color: "Titan Tự Nhiên", storage: "512GB", price: 40990000, originalPrice: 42990000, stock: 15, image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80" },
            { sku: "IP16PM-DES-256", color: "Titan Sa Mạc", storage: "256GB", price: 35490000, originalPrice: 37490000, stock: 20, image: "https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600&auto=format&fit=crop&q=80" },
            { sku: "IP16PM-BLK-256", color: "Titan Đen", storage: "256GB", price: 34990000, originalPrice: 36990000, stock: 18, image: "https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 3. Samsung Galaxy S24 Ultra
    // ---------------------------------------------------------
    {
        id: 3,
        name: "Samsung Galaxy S24 Ultra",
        brand: "Samsung",
        category: "phone",
        categoryName: "Điện thoại",
        image: "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80",
        description: "Điện thoại quyền năng Galaxy AI, khung viền Titan chuẩn quân đội, bút S-Pen đa năng và camera zoom 100x siêu sắc nét.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 180,
        colors: [
            { name: "Xám Titan", hex: "#6b7280", image: "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80" },
            { name: "Đen Titan", hex: "#1f2937", image: "https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&auto=format&fit=crop&q=80" },
            { name: "Vàng Titan", hex: "#eab308", image: "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["256GB", "512GB"],
        variants: [
            { sku: "S24U-GRY-256", color: "Xám Titan", storage: "256GB", price: 28990000, originalPrice: 33990000, stock: 30, image: "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80" },
            { sku: "S24U-GRY-512", color: "Xám Titan", storage: "512GB", price: 33490000, originalPrice: 37990000, stock: 14, image: "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80" },
            { sku: "S24U-BLK-256", color: "Đen Titan", storage: "256GB", price: 28990000, originalPrice: 33990000, stock: 22, image: "https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 4. MacBook Pro 14 M3
    // ---------------------------------------------------------
    {
        id: 4,
        name: "MacBook Pro 14 M3",
        brand: "Apple",
        category: "laptop",
        categoryName: "Laptop",
        image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80",
        description: "MacBook Pro 14 inch trang bị vi xử lý Apple M3 Pro, màn hình Liquid Retina XDR 120Hz siêu nét, thời lượng pin lên đến 18 giờ làm việc liên tục.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 5.0,
        reviews: 96,
        colors: [
            { name: "Xám Không Gian", hex: "#4b5563", image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80" },
            { name: "Bạc Silver", hex: "#e2e8f0", image: "https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["18GB / 512GB", "36GB / 1TB"],
        variants: [
            { sku: "MBP14-GRY-512", color: "Xám Không Gian", storage: "18GB / 512GB", price: 46990000, originalPrice: 49990000, stock: 15, image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80" },
            { sku: "MBP14-GRY-1TB", color: "Xám Không Gian", storage: "36GB / 1TB", price: 58990000, originalPrice: 62990000, stock: 8, image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80" },
            { sku: "MBP14-SLV-512", color: "Bạc Silver", storage: "18GB / 512GB", price: 46990000, originalPrice: 49990000, stock: 10, image: "https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 5. Laptop Gaming ASUS ROG Strix G16
    // ---------------------------------------------------------
    {
        id: 5,
        name: "Laptop ASUS ROG Strix G16",
        brand: "ASUS",
        category: "laptop",
        categoryName: "Laptop",
        image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80",
        description: "Chiến hạm gaming với Intel Core i9 thế hệ 14, card đồ họa NVIDIA RTX 4070, màn hình 2.5K 240Hz chuẩn màu 100% DCI-P3 cùng tản nhiệt 3 quạt siêu mát.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 82,
        colors: [
            { name: "Eclipse Gray", hex: "#374151", image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80" },
            { name: "Volt Green", hex: "#15803d", image: "https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["16GB / 512GB SSD", "32GB / 1TB SSD"],
        variants: [
            { sku: "ROG-G16-16G", color: "Eclipse Gray", storage: "16GB / 512GB SSD", price: 39990000, originalPrice: 44990000, stock: 16, image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80" },
            { sku: "ROG-G16-32G", color: "Eclipse Gray", storage: "32GB / 1TB SSD", price: 47990000, originalPrice: 52990000, stock: 10, image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 6. Laptop Dell XPS 15 9530
    // ---------------------------------------------------------
    {
        id: 6,
        name: "Laptop Dell XPS 15 9530",
        brand: "Dell",
        category: "laptop",
        categoryName: "Laptop",
        image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80",
        description: "Kiệt tác thiết kế từ nhôm nguyên khối và sợi carbon cao cấp, màn hình OLED viền InfinityEdge siêu mỏng, hiệu năng đồ họa mạnh mẽ cho creator chuyên nghiệp.",
        status: "active",
        isFeatured: true,
        isNew: false,
        isPromo: true,
        rating: 4.8,
        reviews: 64,
        colors: [
            { name: "Bạc Bạch Kim", hex: "#cbd5e1", image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["i7 / 16GB / 512GB", "i9 / 32GB / 1TB"],
        variants: [
            { sku: "XPS15-I7-512", color: "Bạc Bạch Kim", storage: "i7 / 16GB / 512GB", price: 48990000, originalPrice: 53990000, stock: 12, image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80" },
            { sku: "XPS15-I9-1TB", color: "Bạc Bạch Kim", storage: "i9 / 32GB / 1TB", price: 62990000, originalPrice: 67990000, stock: 6, image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 7. iPad Pro 11 inch M4
    // ---------------------------------------------------------
    {
        id: 7,
        name: "iPad Pro 11 inch M4",
        brand: "Apple",
        category: "tablet",
        categoryName: "Máy tính bảng",
        image: "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80",
        description: "iPad mỏng nhất từng được Apple chế tạo, trang bị chip Apple M4 siêu tốc độ và màn hình Ultra Retina XDR Tandem OLED đỉnh cao.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 5.0,
        reviews: 110,
        colors: [
            { name: "Bạc Silver", hex: "#e2e8f0", image: "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80" },
            { name: "Đen Không Gian", hex: "#1f2937", image: "https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["256GB", "512GB"],
        variants: [
            { sku: "IPAD-M4-SLV-256", color: "Bạc Silver", storage: "256GB", price: 27490000, originalPrice: 28990000, stock: 24, image: "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80" },
            { sku: "IPAD-M4-SLV-512", color: "Bạc Silver", storage: "512GB", price: 32490000, originalPrice: 34990000, stock: 15, image: "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80" },
            { sku: "IPAD-M4-BLK-256", color: "Đen Không Gian", storage: "256GB", price: 27490000, originalPrice: 28990000, stock: 18, image: "https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 8. Tai nghe Apple AirPods Pro 2 USB-C
    // ---------------------------------------------------------
    {
        id: 8,
        name: "Tai nghe Apple AirPods Pro 2 USB-C",
        brand: "Apple",
        category: "accessory",
        categoryName: "Phụ kiện",
        image: "https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop&q=80",
        description: "Khả năng chống ồn chủ động gấp 2 lần, chế độ Xuyên âm thông minh, âm thanh không gian cá nhân hóa và cổng sạc USB-C hiện đại.",
        status: "active",
        isFeatured: true,
        isNew: true,
        isPromo: true,
        rating: 4.9,
        reviews: 215,
        colors: [
            { name: "Trắng", hex: "#ffffff", image: "https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["Tiêu chuẩn"],
        variants: [
            { sku: "APP2-USBC", color: "Trắng", storage: "Tiêu chuẩn", price: 5490000, originalPrice: 6190000, stock: 50, image: "https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop&q=80" }
        ]
    },

    // ---------------------------------------------------------
    // 9. Chuột Không Dây Logitech MX Master 3S
    // ---------------------------------------------------------
    {
        id: 9,
        name: "Chuột Không Dây Logitech MX Master 3S",
        brand: "Logitech",
        category: "accessory",
        categoryName: "Phụ kiện",
        image: "https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80",
        description: "Chuột không dây cao cấp công thái học với con lăn từ tính MagSpeed siêu êm, cảm biến 8000 DPI lướt mượt trên mọi bề mặt kể cả kính.",
        status: "active",
        isFeatured: true,
        isNew: false,
        isPromo: true,
        rating: 4.9,
        reviews: 310,
        colors: [
            { name: "Đen Graphite", hex: "#1f2937", image: "https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80" },
            { name: "Xám Pale Gray", hex: "#e2e8f0", image: "https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80" }
        ],
        storages: ["Không dây Bluetooth / Bolt"],
        variants: [
            { sku: "MXM3S-BLK", color: "Đen Graphite", storage: "Không dây Bluetooth / Bolt", price: 2090000, originalPrice: 2490000, stock: 45, image: "https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80" },
            { sku: "MXM3S-GRY", color: "Xám Pale Gray", storage: "Không dây Bluetooth / Bolt", price: 2190000, originalPrice: 2590000, stock: 25, image: "https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80" }
        ]
    }
];

// =============================================================
// QUẢN LÝ DỮ LIỆU SẢN PHẨM & MIGRATION TỰ ĐỘNG VỚI LOCALSTORAGE
// =============================================================
const PRODUCTS_STORAGE_KEY = 'techstore_products_v2'; // Sử dụng key mới để đảm bảo dữ liệu biến thể đồng bộ chuẩn xác

// Lấy danh sách sản phẩm từ LocalStorage (hoặc nạp mặc định nếu lần đầu)
function getStoredProducts() {
    const data = localStorage.getItem(PRODUCTS_STORAGE_KEY);
    if (data) {
        try {
            const parsed = JSON.parse(data);
            // Kiểm tra xem sản phẩm có cấu trúc variants hay chưa
            if (Array.isArray(parsed) && parsed.length > 0 && parsed[0].variants) {
                return parsed;
            }
        } catch (e) {
            console.error('Lỗi đọc dữ liệu sản phẩm từ LocalStorage:', e);
        }
    }
    // Nếu chưa có hoặc là dữ liệu cũ, khởi tạo từ danh sách mẫu ban đầu
    localStorage.setItem(PRODUCTS_STORAGE_KEY, JSON.stringify(DEFAULT_PRODUCTS));
    return DEFAULT_PRODUCTS;
}

// Lưu danh sách sản phẩm vào LocalStorage
function saveStoredProducts(list) {
    PRODUCTS = list;
    localStorage.setItem(PRODUCTS_STORAGE_KEY, JSON.stringify(list));
}

// Biến toàn cục chứa danh sách sản phẩm của ứng dụng
let PRODUCTS = getStoredProducts();

// =============================================================
// PHẦN 2: CÁC TIỆN ÍCH HỖ TRỢ XỬ LÝ BIẾN THỂ (VARIANT HELPERS)
// =============================================================

// Định dạng tiền tệ VNĐ (Ví dụ: 18.000.000 ₫)
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount || 0);
}

// Lấy giá thấp nhất trong tất cả các biến thể của sản phẩm
function getProductMinPrice(product) {
    if (!product.variants || product.variants.length === 0) return product.price || 0;
    return Math.min(...product.variants.map(v => v.price));
}

// Lấy giá cao nhất trong các biến thể của sản phẩm
function getProductMaxPrice(product) {
    if (!product.variants || product.variants.length === 0) return product.price || 0;
    return Math.max(...product.variants.map(v => v.price));
}

// Lấy tổng số lượng tồn kho của toàn bộ biến thể thuộc sản phẩm
function getProductTotalStock(product) {
    if (!product.variants || product.variants.length === 0) return product.stock || 0;
    return product.variants.reduce((sum, v) => sum + (v.stock || 0), 0);
}

// Lấy một biến thể theo màu sắc và dung lượng
function getProductVariant(product, colorName, storageName) {
    if (!product || !product.variants || product.variants.length === 0) return null;
    return product.variants.find(v => v.color === colorName && v.storage === storageName) 
        || product.variants[0];
}

// Xử lý khi ảnh lỗi: Thay bằng SVG Placeholder chất lượng cao
function handleImageError(imgElement, productName) {
    const safeName = productName ? encodeURIComponent(productName) : "TechStore";
    imgElement.src = `data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300"><rect width="400" height="300" fill="%23f1f5f9"/><text x="50%" y="45%" dominant-baseline="middle" text-anchor="middle" fill="%230d6efd" font-family="sans-serif" font-weight="bold" font-size="20">TECH STORE</text><text x="50%" y="60%" dominant-baseline="middle" text-anchor="middle" fill="%2364748b" font-family="sans-serif" font-size="14">${safeName}</text></svg>`;
}

// Hiển thị thông báo Toast góc màn hình
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
        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
    } else {
        alert(message);
    }
}

// =============================================================
// PHẦN 3: TẠO THẺ SẢN PHẨM TRANG CHỦ (CHỈ 1 SẢN PHẨM DUY NHẤT)
// =============================================================
function createProductCardHTML(product) {
    const minPrice = getProductMinPrice(product);
    const maxPrice = getProductMaxPrice(product);
    const totalStock = getProductTotalStock(product);

    // Tính phần trăm giảm giá theo giá khởi điểm
    const defaultVariant = product.variants ? product.variants[0] : null;
    let discountPercent = 0;
    if (defaultVariant && defaultVariant.originalPrice > defaultVariant.price) {
        discountPercent = Math.round(((defaultVariant.originalPrice - defaultVariant.price) / defaultVariant.originalPrice) * 100);
    }

    // Nhãn huy hiệu
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

    // Hiển thị giá: Nếu có nhiều mức giá khác nhau thì hiển thị "Từ ...", nếu bằng nhau thì hiển thị giá duy nhất
    let priceHTML = '';
    if (minPrice === maxPrice || maxPrice === 0) {
        priceHTML = `<span class="product-price">${formatCurrency(minPrice)}</span>`;
    } else {
        priceHTML = `<span class="product-price"><small class="text-muted fw-normal" style="font-size: 0.8rem;">Từ </small>${formatCurrency(minPrice)}</span>`;
    }

    // Nhãn số lượng biến thể
    const colorCount = product.colors ? product.colors.length : 1;
    const storageCount = product.storages ? product.storages.length : 1;

    return `
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
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
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="product-category">${product.categoryName}</span>
                    <span class="badge bg-light text-secondary border small">${product.brand || 'Chính hãng'}</span>
                </div>

                <h5 class="product-title" title="${product.name}">
                    <a href="javascript:void(0)" onclick="showProductDetail(${product.id})">${product.name}</a>
                </h5>

                <!-- Nhãn thể hiện sản phẩm có nhiều biến thể (Màu & Dung lượng) -->
                <div class="product-variants-tag">
                    <i class="fa-solid fa-palette text-primary"></i>
                    <span>${colorCount} màu sắc • ${storageCount} phiên bản</span>
                </div>

                <div class="product-rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span>(${product.reviews || 99})</span>
                </div>

                <!-- Khối giá bán -->
                <div class="product-price-box">
                    ${priceHTML}
                    ${defaultVariant && defaultVariant.originalPrice ? `<span class="product-old-price">${formatCurrency(defaultVariant.originalPrice)}</span>` : ''}
                </div>

                <!-- Nút xem chi tiết & chọn phiên bản -->
                <div class="product-action-group">
                    <button class="btn-detail flex-grow-1" type="button" onclick="showProductDetail(${product.id})">
                        <i class="fa-regular fa-eye me-1"></i> Xem chi tiết
                    </button>
                    <button class="btn-add-cart" type="button" onclick="showProductDetail(${product.id})" title="Chọn phiên bản & Đặt hàng">
                        <i class="fa-solid fa-cart-plus me-1"></i> Chọn mua
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
        const promoList = PRODUCTS.filter(p => p.isPromo);
        promoContainer.innerHTML = promoList.map(createProductCardHTML).join('');
    }
}

// =============================================================
// PHẦN 5: LỌC DANH MỤC VÀ TÌM KIẾM SẢN PHẨM
// =============================================================
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
        titleText = "Sản phẩm khuyến mãi giảm giá";
    } else {
        filtered = PRODUCTS.filter(p => p.category === categoryKey);
        const mapName = {
            phone: "Điện thoại thông minh (iPhone, Samsung)",
            laptop: "Máy tính Laptop (MacBook, ASUS, Dell)",
            tablet: "Máy tính bảng iPad",
            accessory: "Phụ kiện (AirPods, Chuột & Bàn phím)"
        };
        titleText = mapName[categoryKey] || "Sản phẩm theo danh mục";
    }

    if (filterTitle) {
        filterTitle.innerHTML = `<i class="fa-solid fa-layer-group text-primary me-2"></i> ${titleText} (${filtered.length})`;
    }

    filterContainer.innerHTML = filtered.length > 0 
        ? filtered.map(createProductCardHTML).join('')
        : `<div class="col-12 text-center py-5"><i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i><p class="text-muted">Không tìm thấy sản phẩm nào trong mục này!</p></div>`;

    filterSection.style.display = 'block';
    filterSection.scrollIntoView({ behavior: 'smooth' });
}

function handleSearch(event) {
    if (event) event.preventDefault();

    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    const keyword = searchInput.value.trim().toLowerCase();
    if (!keyword) {
        showToast('Vui lòng nhập từ khóa tìm kiếm!', 'error');
        return;
    }

    const matchedProducts = PRODUCTS.filter(p => 
        p.name.toLowerCase().includes(keyword) || 
        p.categoryName.toLowerCase().includes(keyword) ||
        p.description.toLowerCase().includes(keyword) ||
        (p.brand && p.brand.toLowerCase().includes(keyword))
    );

    const filterSection = document.getElementById('categoryFilterSection');
    const filterContainer = document.getElementById('filteredProductsContainer');
    const filterTitle = document.getElementById('filteredCategoryTitle');

    if (filterSection && filterContainer && filterTitle) {
        filterSection.style.display = 'block';
        filterTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-primary me-2"></i> Kết quả tìm kiếm: "${keyword}" (${matchedProducts.length})`;

        filterContainer.innerHTML = matchedProducts.length > 0 
            ? matchedProducts.map(createProductCardHTML).join('')
            : `<div class="col-12 text-center py-5">
                    <i class="fa-regular fa-face-frown fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy sản phẩm khớp với "${keyword}"</h5>
                    <p class="text-muted">Gợi ý từ khóa: "iPhone 15", "Samsung", "MacBook", "Dell", "Chuột"...</p>
               </div>`;

        filterSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// =============================================================
// PHẦN 6: MODAL CHI TIẾT SẢN PHẨM & CHỌN BIẾN THỂ (PRODUCT DETAIL & VARIANT SELECTOR)
// =============================================================
let CURRENT_DETAIL_PRODUCT_ID = null;
let SELECTED_COLOR = null;
let SELECTED_STORAGE = null;

// Mở Modal xem chi tiết sản phẩm và chọn phiên bản
function showProductDetail(productId) {
    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    CURRENT_DETAIL_PRODUCT_ID = productId;

    // Chọn mặc định màu đầu tiên và dung lượng đầu tiên
    const defaultColor = (product.colors && product.colors.length > 0) ? product.colors[0].name : "Tiêu chuẩn";
    const defaultStorage = (product.storages && product.storages.length > 0) ? product.storages[0] : "Tiêu chuẩn";

    SELECTED_COLOR = defaultColor;
    SELECTED_STORAGE = defaultStorage;

    renderProductDetailModalContent(product);

    // Mở Bootstrap Modal
    const modalEl = document.getElementById('productDetailModal');
    if (modalEl && window.bootstrap) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Render nội dung bên trong Modal chi tiết sản phẩm
function renderProductDetailModalContent(product) {
    const modalBody = document.getElementById('productDetailModalBody');
    if (!modalBody) return;

    // Tìm biến thể đang chọn
    const activeVariant = getProductVariant(product, SELECTED_COLOR, SELECTED_STORAGE);
    const displayImage = (activeVariant && activeVariant.image) ? activeVariant.image : product.image;
    const currentPrice = activeVariant ? activeVariant.price : getProductMinPrice(product);
    const originalPrice = activeVariant ? activeVariant.originalPrice : 0;
    const stock = activeVariant ? activeVariant.stock : 0;
    const sku = activeVariant ? activeVariant.sku : `SKU-${product.id}`;

    // Tính % giảm giá nếu có
    let discountPercent = 0;
    if (originalPrice && originalPrice > currentPrice) {
        discountPercent = Math.round(((originalPrice - currentPrice) / originalPrice) * 100);
    }

    // Danh sách nút chọn Màu sắc
    let colorsHTML = '';
    if (product.colors && product.colors.length > 0) {
        colorsHTML = `
            <div class="mb-3">
                <div class="variant-group-title">
                    <span>1. Chọn Màu sắc: <b class="text-primary">${SELECTED_COLOR}</b></span>
                </div>
                <div class="variant-color-list">
                    ${product.colors.map(c => {
                        const isActive = (c.name === SELECTED_COLOR) ? 'active' : '';
                        return `
                            <button type="button" 
                                    class="variant-color-btn ${isActive}" 
                                    onclick="selectVariantColor('${c.name.replace(/'/g, "\\'")}')">
                                <span class="variant-color-dot" style="background-color: ${c.hex || '#ccc'};"></span>
                                <span>${c.name}</span>
                            </button>
                        `;
                    }).join('')}
                </div>
            </div>
        `;
    }

    // Danh sách nút chọn Dung lượng / Cấu hình
    let storagesHTML = '';
    if (product.storages && product.storages.length > 0) {
        storagesHTML = `
            <div class="mb-3">
                <div class="variant-group-title">
                    <span>2. Chọn Dung lượng / Cấu hình: <b class="text-primary">${SELECTED_STORAGE}</b></span>
                </div>
                <div class="variant-storage-list">
                    ${product.storages.map(s => {
                        const isActive = (s === SELECTED_STORAGE) ? 'active' : '';
                        // Kiểm tra xem biến thể với màu hiện tại + dung lượng này còn hàng không
                        const testVariant = getProductVariant(product, SELECTED_COLOR, s);
                        const isOutOfStock = (testVariant && testVariant.stock <= 0);
                        const outOfStockClass = isOutOfStock ? 'out-of-stock' : '';

                        return `
                            <button type="button" 
                                    class="variant-storage-btn ${isActive} ${outOfStockClass}" 
                                    onclick="selectVariantStorage('${s.replace(/'/g, "\\'")}')"
                                    title="${isOutOfStock ? 'Phiên bản này tạm hết hàng' : ''}">
                                <span>${s}</span>
                                ${isOutOfStock ? '<small class="text-danger fw-normal" style="font-size: 0.65rem;">Hết hàng</small>' : ''}
                            </button>
                        `;
                    }).join('')}
                </div>
            </div>
        `;
    }

    // Khối trạng thái tồn kho
    let stockBadgeHTML = '';
    if (stock > 0) {
        stockBadgeHTML = `<span class="stock-status-badge stock-in-stock"><i class="fa-solid fa-circle-check"></i> Còn hàng (${stock} sản phẩm sẵn có)</span>`;
    } else {
        stockBadgeHTML = `<span class="stock-status-badge stock-out-of-stock"><i class="fa-solid fa-circle-xmark"></i> Tạm hết hàng</span>`;
    }

    // Nút mua hàng (bị disable nếu hết hàng)
    let actionButtonsHTML = '';
    if (stock > 0 && activeVariant) {
        actionButtonsHTML = `
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary py-2 px-3 fw-bold flex-grow-1" 
                        onclick="addToCartVariant(${product.id}, '${activeVariant.sku}')">
                    <i class="fa-solid fa-cart-plus me-1"></i> Thêm vào giỏ
                </button>
                <button type="button" class="btn btn-primary py-2 px-3 fw-bold flex-grow-1" 
                        onclick="buyNowVariant(${product.id}, '${activeVariant.sku}')">
                    <i class="fa-solid fa-bolt me-1"></i> Mua ngay
                </button>
            </div>
        `;
    } else {
        actionButtonsHTML = `
            <button type="button" class="btn btn-secondary w-100 py-2 fw-bold" disabled>
                <i class="fa-solid fa-ban me-1"></i> Phiên bản này tạm hết hàng - Vui lòng chọn màu hoặc dung lượng khác
            </button>
        `;
    }

    modalBody.innerHTML = `
        <div class="row g-4">
            <!-- Cột trái: Ảnh lớn của biến thể được chọn -->
            <div class="col-12 col-md-5 text-center">
                <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-center" style="min-height: 320px;">
                    <img id="detailMainProductImage" 
                         src="${displayImage}" 
                         alt="${product.name}" 
                         class="img-fluid rounded" 
                         style="max-height: 300px; object-fit: contain; transition: all 0.3s ease;"
                         onerror="handleImageError(this, '${product.name.replace(/'/g, "\\'")}')">
                </div>
                <div class="mt-2 text-muted small">
                    <i class="fa-solid fa-camera me-1"></i> Ảnh phiên bản màu: <b>${SELECTED_COLOR}</b>
                </div>
            </div>

            <!-- Cột phải: Thông tin, lựa chọn biến thể, giá bán -->
            <div class="col-12 col-md-7">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary">${product.categoryName}</span>
                    <span class="badge bg-light text-dark border">${product.brand || 'Chính Hãng'}</span>
                </div>
                
                <h4 class="fw-bold text-dark mb-1">${product.name}</h4>

                <!-- Đánh giá sao -->
                <div class="text-warning small mb-3">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span class="text-muted ms-1">(${product.reviews || 120} đánh giá chính hãng)</span>
                </div>

                <!-- Khối hiển thị Giá bán tương ứng với biến thể đã chọn -->
                <div class="variant-details-card">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="variant-sku-tag">Mã SKU: ${sku}</span>
                        ${stockBadgeHTML}
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mt-2">
                        <span class="h3 fw-bold text-danger mb-0">${formatCurrency(currentPrice)}</span>
                        ${originalPrice ? `<span class="text-muted text-decoration-line-through small">${formatCurrency(originalPrice)}</span>` : ''}
                        ${discountPercent > 0 ? `<span class="badge bg-danger">Tiết kiệm ${discountPercent}%</span>` : ''}
                    </div>
                </div>

                <!-- 1. Danh sách chọn Màu sắc -->
                ${colorsHTML}

                <!-- 2. Danh sách chọn Dung lượng -->
                ${storagesHTML}

                <!-- Mô tả ngắn gọn -->
                <p class="text-secondary small mb-3">${product.description}</p>

                <!-- Cam kết dịch vụ -->
                <div class="p-2 bg-light rounded-3 mb-3 small">
                    <div class="row g-1">
                        <div class="col-6"><i class="fa-solid fa-shield-check text-success me-1"></i>Bảo hành 12 tháng</div>
                        <div class="col-6"><i class="fa-solid fa-truck-fast text-primary me-1"></i>Miễn phí vận chuyển</div>
                        <div class="col-6"><i class="fa-solid fa-arrows-rotate text-info me-1"></i>Đổi mới trong 30 ngày</div>
                        <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i>Hàng mới nguyên seal</div>
                    </div>
                </div>

                <!-- Nút thao tác thêm giỏ hoặc mua ngay -->
                ${actionButtonsHTML}
            </div>
        </div>
    `;
}

// Khách hàng bấm chọn màu sắc khác
function selectVariantColor(colorName) {
    SELECTED_COLOR = colorName;
    const product = PRODUCTS.find(p => p.id === CURRENT_DETAIL_PRODUCT_ID);
    if (product) {
        renderProductDetailModalContent(product);
    }
}

// Khách hàng bấm chọn dung lượng khác
function selectVariantStorage(storageName) {
    SELECTED_STORAGE = storageName;
    const product = PRODUCTS.find(p => p.id === CURRENT_DETAIL_PRODUCT_ID);
    if (product) {
        renderProductDetailModalContent(product);
    }
}

// =============================================================
// PHẦN 7: QUẢN LÝ GIỎ HÀNG VỚI BIẾN THỂ (CART WITH VARIANTS)
// =============================================================
// Khóa lưu giỏ hàng trong localStorage phân biệt theo từng tài khoản đăng nhập (Bảo vệ dữ liệu khách hàng)
function getCartStorageKey() {
    const user = (typeof getCurrentUser === 'function') ? getCurrentUser() : null;
    return (user && user.id) ? `techstore_cart_v2_u${user.id}` : 'techstore_cart_v2_guest';
}

// Lấy danh sách giỏ hàng
function getCart() {
    const key = getCartStorageKey();
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : [];
}

// Lưu danh sách giỏ hàng
function saveCart(cart) {
    const key = getCartStorageKey();
    localStorage.setItem(key, JSON.stringify(cart));
    // Lưu song song vào key chung để tương thích với các view khác
    localStorage.setItem('techstore_cart_v2', JSON.stringify(cart));
    updateCartUI();
}

// Cập nhật số lượng trên icon giỏ hàng và danh sách trong Modal
function updateCartUI() {
    // Nếu chưa đăng nhập: ẩn số lượng giỏ hàng trên Header
    if (typeof kiemTraDangNhap === 'function' && !kiemTraDangNhap()) {
        const cartBadge = document.getElementById('cartBadgeCount');
        if (cartBadge) cartBadge.style.display = 'none';
        return;
    }

    const cart = getCart();
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartBadgeCount');
    if (cartBadge) {
        cartBadge.innerText = totalCount;
        cartBadge.style.display = totalCount > 0 ? 'flex' : 'none';
    }
    renderCartModal(cart);
}

// Thêm đúng biến thể vào giỏ hàng (BẮT BUỘC ĐĂNG NHẬP)
function addToCartVariant(productId, sku) {
    if (typeof kiemTraDangNhap === 'function' && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    const variant = product.variants ? product.variants.find(v => v.sku === sku) : null;
    if (!variant) {
        showToast('Không tìm thấy thông tin phiên bản này!', 'error');
        return;
    }

    // Kiểm tra còn hàng hay không
    if (variant.stock <= 0) {
        showToast(`Rất tiếc! Phiên bản "${variant.color} - ${variant.storage}" đã tạm hết hàng!`, 'error');
        return;
    }

    let cart = getCart();
    // Tạo cartKey duy nhất kết hợp giữa productId và SKU để phân biệt các biến thể khác nhau
    const cartKey = `${productId}_${sku}`;
    const existingIndex = cart.findIndex(item => item.cartKey === cartKey);

    if (existingIndex > -1) {
        // Nếu đã có trong giỏ hàng, kiểm tra giới hạn tồn kho
        if (cart[existingIndex].quantity + 1 > variant.stock) {
            showToast(`Bạn đã có ${cart[existingIndex].quantity} sản phẩm trong giỏ. Kho chỉ còn ${variant.stock} sản phẩm!`, 'error');
            return;
        }
        cart[existingIndex].quantity += 1;
    } else {
        // Thêm mục mới vào giỏ hàng với thông tin đầy đủ về Màu sắc và Dung lượng
        cart.push({
            cartKey: cartKey,
            id: product.id,
            sku: variant.sku,
            name: product.name,
            color: variant.color,
            storage: variant.storage,
            price: variant.price,
            originalPrice: variant.originalPrice,
            image: variant.image || product.image,
            maxStock: variant.stock,
            quantity: 1
        });
    }

    saveCart(cart);
    showToast(`Đã thêm "${product.name} (${variant.color} - ${variant.storage})" vào giỏ hàng!`, 'success');
}

// Nút "Mua ngay": BẮT BUỘC ĐĂNG NHẬP
function buyNowVariant(productId, sku) {
    if (typeof kiemTraDangNhap === 'function' && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để mua hàng!');
        return;
    }

    addToCartVariant(productId, sku);

    // Đóng modal chi tiết
    const detailModalEl = document.getElementById('productDetailModal');
    if (detailModalEl && window.bootstrap) {
        const detailModal = bootstrap.Modal.getInstance(detailModalEl);
        if (detailModal) detailModal.hide();
    }

    // Mở modal giỏ hàng
    const cartModalEl = document.getElementById('cartModal');
    if (cartModalEl && window.bootstrap) {
        const cartModal = new bootstrap.Modal(cartModalEl);
        cartModal.show();
    }
}

// Thay đổi số lượng sản phẩm trong giỏ hàng
function changeCartQuantity(cartKey, delta) {
    let cart = getCart();
    const item = cart.find(i => i.cartKey === cartKey);
    if (!item) return;

    if (delta > 0) {
        if (item.quantity + delta > item.maxStock) {
            showToast(`Số lượng trong kho của phiên bản này chỉ còn tối đa ${item.maxStock} sản phẩm!`, 'error');
            return;
        }
    }

    item.quantity += delta;
    if (item.quantity <= 0) {
        cart = cart.filter(i => i.cartKey !== cartKey);
    }

    saveCart(cart);
}

function toggleCartItem(cartKey, checked) {
    const cart = getCart();
    const item = cart.find(i => i.cartKey === cartKey);
    if (!item) return;
    item.selected = checked;
    saveCart(cart);
}

function toggleSelectAllCart(checked) {
    saveCart(getCart().map(item => ({ ...item, selected: checked })));
}

// Xóa 1 phiên bản khỏi giỏ hàng
function removeCartItem(cartKey) {
    let cart = getCart();
    cart = cart.filter(i => i.cartKey !== cartKey);
    saveCart(cart);
    showToast('Đã xóa phiên bản khỏi giỏ hàng!', 'info');
}

// Xóa sạch giỏ hàng
function clearCart() {
    if (confirm('Bạn có chắc chắn muốn làm trống toàn bộ giỏ hàng?')) {
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
                <h6 class="text-muted fw-bold">Giỏ hàng của bạn đang trống!</h6>
                <p class="small text-muted mb-3">Hãy chọn các sản phẩm công nghệ với phiên bản màu và dung lượng yêu thích nhé.</p>
                <button class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Tiếp tục xem sản phẩm</button>
            </div>
        `;
        if (cartTotalPrice) cartTotalPrice.innerText = formatCurrency(0);
        if (cartActionFooter) cartActionFooter.style.display = 'none';
        return;
    }

    let total = 0;
    cartContainer.innerHTML = cart.map(item => {
        const itemTotal = item.price * item.quantity;
        if (item.selected !== false) total += itemTotal;
        return `
            <div class="d-flex align-items-center justify-content-between p-2 border-bottom">
                <input class="form-check-input me-2" type="checkbox" aria-label="Chọn ${item.name}" ${item.selected !== false ? 'checked' : ''} onchange="toggleCartItem('${item.cartKey}', this.checked)">
                <img src="${item.image}" alt="${item.name}" class="rounded me-3" style="width: 55px; height: 55px; object-fit: contain;" onerror="handleImageError(this, '${item.name.replace(/'/g, "\\'")}')">
                <div class="flex-grow-1 me-2">
                    <h6 class="mb-1 text-truncate" style="max-width: 200px;" title="${item.name}">${item.name}</h6>
                    <div class="d-flex flex-wrap gap-1 mb-1">
                        <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">Màu: ${item.color}</span>
                        <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">${item.storage}</span>
                        <span class="badge bg-secondary-subtle text-secondary font-monospace" style="font-size: 0.65rem;">${item.sku}</span>
                    </div>
                    <div class="text-danger small fw-bold">${formatCurrency(item.price)}</div>
                </div>
                <div class="d-flex align-items-center gap-1 me-3">
                    <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeCartQuantity('${item.cartKey}', -1)">-</button>
                    <span class="px-2 fw-bold small">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeCartQuantity('${item.cartKey}', 1)">+</button>
                </div>
                <div class="text-end">
                    <div class="fw-bold small text-primary mb-1">${formatCurrency(itemTotal)}</div>
                    <button class="btn btn-sm text-danger p-0 border-0" onclick="removeCartItem('${item.cartKey}')" title="Xóa">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');

    const allSelected = cart.every(item => item.selected !== false);
    cartContainer.insertAdjacentHTML('afterbegin', `<div class="form-check mb-2 ps-4"><input class="form-check-input" type="checkbox" id="cartSelectAll" ${allSelected ? 'checked' : ''} onchange="toggleSelectAllCart(this.checked)"><label class="form-check-label fw-semibold" for="cartSelectAll">Chọn tất cả</label></div>`);

    if (cartTotalPrice) cartTotalPrice.innerText = formatCurrency(total);
    if (cartActionFooter) cartActionFooter.style.display = 'flex';
}

// =============================================================
// PHẦN 8: ĐẶT HÀNG & TRỪ TỒN KHO CỦA ĐÚNG PHIÊN BẢN (CHECKOUT)
// =============================================================
const ORDERS_STORAGE_KEY = 'techstore_orders_v2';

// Danh sách đơn hàng mẫu ban đầu
const DEFAULT_DEMO_ORDERS = [
    { 
        id: "DH105", 
        customer: "Nguyễn Văn An", 
        phone: "0988123456", 
        address: "Số 123 Đường Cầu Giấy, Phường Dịch Vọng, Quận Cầu Giấy, Hà Nội",
        productSummary: "iPhone 15 (Đen - 128GB) x 1", 
        total: 18030000, 
        shippingMethod: "standard",
        shippingMethodName: "Giao thường",
        shippingFee: 30000,
        orderDate: "17/11/2026",
        orderTime: "09:30",
        estimatedDeliveryDate: "17/11/2026",
        estimatedDeliveryTime: "Trước 18:00",
        actualDeliveryTime: "17/11/2026 15:45",
        deliveryHistory: [],
        date: "17/11/2026 09:30", 
        status: "completed", 
        statusText: "Đã giao hàng",
        paymentMethod: "Thanh toán khi nhận hàng (COD)",
        items: [
            { name: "iPhone 15", color: "Đen", storage: "128GB", sku: "IP15-BLK-128", price: 18000000, quantity: 1 }
        ]
    },
    { 
        id: "DH104", 
        customer: "Lê Hoàng Nam", 
        phone: "0912345678", 
        address: "Tòa nhà Landmark 81, 720A Điện Biên Phủ, Phường 22, Quận Bình Thạnh, TP. Hồ Chí Minh",
        productSummary: "MacBook Pro 14 M3 (Xám - 18GB/512GB) x 1", 
        total: 47040000, 
        shippingMethod: "express",
        shippingMethodName: "Giao hỏa tốc",
        shippingFee: 50000,
        orderDate: "17/11/2026",
        orderTime: "07:15",
        estimatedDeliveryDate: "17/11/2026",
        estimatedDeliveryTime: "Trước 09:15",
        actualDeliveryTime: null,
        deliveryHistory: [],
        date: "17/11/2026 07:15", 
        status: "shipping", 
        statusText: "Đang vận chuyển",
        paymentMethod: "Chuyển khoản ngân hàng",
        items: [
            { name: "MacBook Pro 14 M3", color: "Xám Không Gian", storage: "18GB / 512GB", sku: "MBP14-GRY-512", price: 46990000, quantity: 1 }
        ]
    },
    { 
        id: "DH103", 
        customer: "Trần Thị Mai", 
        phone: "0977889900", 
        address: "Số 45 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh",
        productSummary: "iPhone 15 (Xanh dương - 256GB) x 1", 
        total: 20530000, 
        shippingMethod: "standard",
        shippingMethodName: "Giao thường",
        shippingFee: 30000,
        orderDate: "16/11/2026",
        orderTime: "14:20",
        estimatedDeliveryDate: "16/11/2026",
        estimatedDeliveryTime: "Trước 18:00",
        actualDeliveryTime: null,
        deliveryHistory: [],
        date: "16/11/2026 14:20", 
        status: "pending", 
        statusText: "Chờ xác nhận",
        paymentMethod: "Thanh toán khi nhận hàng (COD)",
        items: [
            { name: "iPhone 15", color: "Xanh dương", storage: "256GB", sku: "IP15-BLU-256", price: 20500000, quantity: 1 }
        ]
    }
];

function getStoredOrders() {
    const data = localStorage.getItem(ORDERS_STORAGE_KEY);
    return data ? JSON.parse(data) : DEFAULT_DEMO_ORDERS;
}

function getCurrentUserOrders() {
    const user = getCurrentUser();
    if (!user || user.role === 'admin') return [];
    return getStoredOrders().filter(order => Number(order.userId) === Number(user.id));
}

function escapeOrderHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    })[char]);
}

let activeOrderHistoryFilter = 'all';

function filterOrderHistory(status) {
    activeOrderHistoryFilter = status;
    renderOrderHistory();
}

// Xử lý hủy đơn hàng từ phía khách hàng (BẮT BUỘC ĐĂNG NHẬP & CHỈ ĐƯỢC HỦY ĐƠN CỦA CHÍNH MÌNH)
// Quy định: Chỉ được hủy khi đơn ở trạng thái pending (Chờ xác nhận), confirmed (Đã xác nhận), processing (Đang chuẩn bị hàng)
// Không được hủy khi đơn đang vận chuyển (shipping), đã giao (completed) hoặc đã hủy (cancelled)
function cancelCustomerOrder(orderId) {
    if (typeof kiemTraDangNhap === 'function' && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để hủy đơn hàng!');
        return;
    }
    const user = getCurrentUser();
    if (!user || user.role === 'admin') return;
    const orders = getStoredOrders();
    // Khách hàng này tuyệt đối không xem hoặc hủy được đơn hàng của khách hàng khác
    const order = orders.find(item => String(item.id) === String(orderId) && Number(item.userId) === Number(user.id));
    if (!order) {
        alert('Không tìm thấy đơn hàng hoặc bạn không có quyền thao tác trên đơn hàng này!');
        return;
    }

    const cancellableStatuses = ['pending', 'confirmed', 'processing'];
    if (!cancellableStatuses.includes(order.status)) {
        alert(`Không thể hủy đơn hàng #${order.id} vì đơn đang ở trạng thái "${order.statusText || order.status}"!`);
        return;
    }

    if (!window.confirm(`Bạn có chắc chắn muốn hủy đơn hàng #${order.id}?`)) return;

    order.status = 'cancelled';
    order.statusText = 'Đã hủy';
    saveStoredOrders(orders);
    renderOrderHistory();
    if (typeof showToast === 'function') {
        showToast(`Đã hủy đơn hàng #${order.id} thành công!`, 'info');
    }
}

function renderOrderHistory() {
    const container = document.getElementById('orderHistoryContent');
    if (!container) return;

    const orders = getCurrentUserOrders();
    const filteredOrders = activeOrderHistoryFilter === 'all' ? orders : orders.filter(order => order.status === activeOrderHistoryFilter);
    const filters = `
        <div class="d-flex flex-wrap gap-2 mb-3" role="group" aria-label="Lọc đơn hàng theo trạng thái">
            <button type="button" class="btn btn-sm ${activeOrderHistoryFilter === 'all' ? 'btn-primary' : 'btn-outline-primary'}" onclick="filterOrderHistory('all')">Tất cả</button>
            <button type="button" class="btn btn-sm ${activeOrderHistoryFilter === 'pending' ? 'btn-warning' : 'btn-outline-warning'}" onclick="filterOrderHistory('pending')">Chờ xác nhận</button>
            <button type="button" class="btn btn-sm ${activeOrderHistoryFilter === 'processing' ? 'btn-info' : 'btn-outline-info'}" onclick="filterOrderHistory('processing')">Đang xử lý</button>
            <button type="button" class="btn btn-sm ${activeOrderHistoryFilter === 'shipping' ? 'btn-primary' : 'btn-outline-primary'}" onclick="filterOrderHistory('shipping')">Đang vận chuyển</button>
            <button type="button" class="btn btn-sm ${activeOrderHistoryFilter === 'completed' ? 'btn-success' : 'btn-outline-success'}" onclick="filterOrderHistory('completed')">Đã giao hàng</button>
            <button type="button" class="btn btn-sm ${activeOrderHistoryFilter === 'cancelled' ? 'btn-secondary' : 'btn-outline-secondary'}" onclick="filterOrderHistory('cancelled')">Đã hủy</button>
        </div>`;
    if (!orders.length) {
        container.innerHTML = '<div class="text-center text-muted py-5"><i class="fa-solid fa-box-open fa-3x mb-3 d-block"></i>Bạn chưa có đơn hàng nào.</div>';
        return;
    }

    if (!filteredOrders.length) {
        container.innerHTML = filters + '<div class="text-center text-muted py-4">Không có đơn hàng ở trạng thái này.</div>';
        return;
    }

    container.innerHTML = filters + filteredOrders.map(order => {
        let statusClass = 'bg-warning text-dark';
        if (order.status === 'completed') statusClass = 'bg-success';
        else if (order.status === 'shipping') statusClass = 'bg-primary';
        else if (order.status === 'processing') statusClass = 'bg-info text-dark';
        else if (order.status === 'confirmed') statusClass = 'bg-primary';
        else if (order.status === 'cancelled') statusClass = 'bg-secondary';

        // Huy hiệu phương thức vận chuyển (Giao thường hoặc Giao hỏa tốc)
        const isExpress = (order.shippingMethod === 'express');
        const shipBadge = isExpress 
            ? '<span class="badge bg-warning text-dark border"><i class="fa-solid fa-bolt me-1"></i> Giao hỏa tốc (50.000 ₫)</span>' 
            : '<span class="badge bg-light text-primary border"><i class="fa-solid fa-truck me-1"></i> Giao thường (30.000 ₫)</span>';

        // Thời gian giao hàng dự kiến (cố định theo đơn hàng)
        const estDelivery = order.estimatedDeliveryDate 
            ? `${escapeOrderHtml(order.estimatedDeliveryDate)} (${escapeOrderHtml(order.estimatedDeliveryTime || 'Trong ngày')})` 
            : 'Trong ngày';

        // Thời gian giao thực tế (nếu đơn đã hoàn thành)
        const actualDeliveryHtml = (order.status === 'completed' && order.actualDeliveryTime)
            ? `<div class="mt-1 text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i><strong>Thời gian giao thực tế:</strong> ${escapeOrderHtml(order.actualDeliveryTime)}</div>`
            : '';

        // Thông báo nếu Admin có cập nhật thời gian giao hàng kèm lý do
        let adminUpdateAlert = '';
        if (order.deliveryHistory && Array.isArray(order.deliveryHistory) && order.deliveryHistory.length > 0) {
            const lastChange = order.deliveryHistory[order.deliveryHistory.length - 1];
            adminUpdateAlert = `
                <div class="alert alert-warning py-2 px-3 small mt-2 mb-2 rounded-2">
                    <div class="fw-bold text-dark"><i class="fa-solid fa-bell text-warning me-1"></i> Cập nhật thời gian giao từ cửa hàng:</div>
                    <div class="mt-1">Thời gian mới: <strong class="text-danger">${escapeOrderHtml(order.estimatedDeliveryDate)} (${escapeOrderHtml(order.estimatedDeliveryTime)})</strong></div>
                    <div class="text-muted fst-italic mt-1">Lý do: "${escapeOrderHtml(lastChange.reason || 'Điều chỉnh kế hoạch giao hàng')}" <span class="small">(${escapeOrderHtml(lastChange.changedAt || '')})</span></div>
                </div>
            `;
        }

        const items = (order.items || []).map(item => {
            const product = (typeof PRODUCTS !== 'undefined' ? PRODUCTS : []).find(p => p.name === item.name || (p.variants || []).some(variant => variant.sku === item.sku));
            const variant = product && (product.variants || []).find(candidate => candidate.sku === item.sku);
            const image = item.image || (variant && variant.image) || (product && product.image) || '';
            const variantText = (item.color || item.storage) ? `(${escapeOrderHtml(item.color || '')} · ${escapeOrderHtml(item.storage || '')})` : '';
            return `
            <div class="d-flex justify-content-between align-items-center gap-3 py-2 border-top small">
                <span class="d-flex align-items-center gap-2">
                    <img src="${escapeOrderHtml(image)}" alt="${escapeOrderHtml(item.name)}" class="rounded border p-1" style="width:48px;height:48px;object-fit:contain" onerror="this.style.display='none'">
                    <span>${escapeOrderHtml(item.name)} <span class="text-muted">${variantText} × ${Number(item.quantity) || 1}</span></span>
                </span>
                <span class="text-nowrap fw-semibold">${formatCurrency((Number(item.price) || 0) * (Number(item.quantity) || 1))}</span>
            </div>`;
        }).join('');

        // Quy định hủy đơn: chỉ cho phép hủy khi đang pending, confirmed, hoặc processing
        const canCancel = ['pending', 'confirmed', 'processing'].includes(order.status);
        const cancelBtnHtml = canCancel 
            ? `<button type="button" class="btn btn-outline-danger btn-sm" onclick="cancelCustomerOrder('${escapeOrderHtml(order.id)}')"><i class="fa-solid fa-xmark me-1"></i> Hủy đơn hàng</button>` 
            : '';

        return `<article class="border rounded-3 p-3 mb-3 bg-white shadow-sm">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                <div>
                    <strong class="text-primary fs-6">#${escapeOrderHtml(order.id)}</strong>
                    <span class="text-muted ms-2 small"><i class="fa-regular fa-clock me-1"></i>${escapeOrderHtml(order.date || (order.orderDate + ' ' + order.orderTime))}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    ${shipBadge}
                    <span class="badge ${statusClass}">${escapeOrderHtml(order.statusText || 'Chờ xác nhận')}</span>
                </div>
            </div>

            ${adminUpdateAlert}

            ${items || `<div class="small text-muted py-2">${escapeOrderHtml(order.productSummary)}</div>`}

            <div class="small text-muted border-top pt-2 mt-2">
                <div class="row g-1">
                    <div class="col-12 col-md-6"><strong>Phương thức vận chuyển:</strong> ${shipBadge}</div>
                    <div class="col-12 col-md-6 text-md-end"><strong>Dự kiến giao:</strong> <span class="text-dark fw-bold">${estDelivery}</span></div>
                    <div class="col-12"><strong>Hình thức thanh toán:</strong> ${escapeOrderHtml(order.paymentMethod || 'COD (Thanh toán khi nhận hàng)')}</div>
                    <div class="col-12"><strong>Địa chỉ nhận hàng:</strong> ${escapeOrderHtml(order.address || 'Chưa cập nhật')}</div>
                    ${order.note ? `<div class="col-12"><strong>Ghi chú:</strong> ${escapeOrderHtml(order.note)}</div>` : ''}
                    ${actualDeliveryHtml ? `<div class="col-12">${actualDeliveryHtml}</div>` : ''}
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                <span class="text-muted small">Phí ship: <b class="text-dark">${formatCurrency(order.shippingFee || 30000)}</b></span>
                <div>
                    <span class="fw-bold me-2">Tổng thanh toán:</span>
                    <span class="h6 fw-bold text-danger mb-0">${formatCurrency(Number(order.total) || 0)}</span>
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center gap-2 mt-3 pt-2 border-top">
                ${cancelBtnHtml}
                <a href="index.php?action=order-tracking&id=${escapeOrderHtml(order.id)}" class="btn btn-warning btn-sm fw-bold">
                    <i class="fa-solid fa-truck-fast me-1"></i> Theo dõi giao hàng
                </a>
            </div>
        </article>`;
    }).join('');
}

function saveStoredOrders(orders) {
    localStorage.setItem(ORDERS_STORAGE_KEY, JSON.stringify(orders));
    localStorage.setItem('techstore_orders', JSON.stringify(orders));
}

// =============================================================
// PHẦN 8: ĐIỀU HƯỚNG TỪ GIỎ HÀNG SANG TRANG THANH TOÁN (CHECKOUT)
// =============================================================
// Chuyển hướng từ modal giỏ hàng sang trang thanh toán riêng biệt (BẮT BUỘC ĐĂNG NHẬP)
function goToCheckout() {
    if (typeof kiemTraDangNhap === 'function' && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để tiến hành thanh toán đơn hàng!', 'index.php?action=checkout');
        return;
    }

    const cart = getCart();
    if (!cart || !cart.some(item => item.selected !== false)) {
        showToast('Vui lòng chọn ít nhất một sản phẩm để thanh toán.', 'warning');
        return;
    }

    // Đóng Modal giỏ hàng nếu đang mở
    const modalEl = document.getElementById('cartModal');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    // Chuyển hướng sang trang thanh toán
    window.location.href = 'index.php?action=checkout';
}

// Giữ lại hàm handleCheckoutDemo để tương thích ngược
function handleCheckoutDemo() {
    goToCheckout();
}

// =============================================================
// PHẦN 9: CÁC HÀM XÁC THỰC VÀ PHÂN QUYỀN ĐĂNG NHẬP (RBAC)
// Dành cho học viên mới học Front-End (HTML, CSS, JavaScript cơ bản)
// =============================================================

/**
 * 1. Lấy thông tin tài khoản người dùng hiện tại
 * Trạng thái đăng nhập được PHP truyền sang qua window.CURRENT_USER (từ session + MySQL)
 */
function getCurrentUser() {
    return (typeof window.CURRENT_USER !== 'undefined' && window.CURRENT_USER) ? window.CURRENT_USER : null;
}

/**
 * 2. kiemTraDangNhap(): Kiểm tra người dùng đã đăng nhập hay chưa
 * Trả về: true (đã đăng nhập) hoặc false (chưa đăng nhập)
 */
function kiemTraDangNhap() {
    const user = getCurrentUser();
    // Đã đăng nhập khi có thông tin đối tượng user và có id hợp lệ > 0
    return (user !== null && typeof user === 'object' && Number(user.id) > 0);
}

/**
 * 3. kiemTraQuyenAdmin(): Kiểm tra có quyền Quản trị viên (Admin) hay không
 * Trả về: true nếu là Admin, false nếu không phải
 */
function kiemTraQuyenAdmin() {
    const user = getCurrentUser();
    return (kiemTraDangNhap() && user.role === 'admin');
}

/**
 * 4. kiemTraQuyenKhachHang(): Kiểm tra có phải Khách hàng thông thường hay không
 * Trả về: true nếu là Khách hàng (đã đăng nhập và role !== 'admin')
 */
function kiemTraQuyenKhachHang() {
    const user = getCurrentUser();
    return (kiemTraDangNhap() && user.role !== 'admin');
}

/**
 * 5. chuyenDenTrangDangNhap(thongBao, urlQuayLai): Chuyển đến trang Đăng nhập
 * Hiển thị alert thông báo lý do và truyền URL quay lại sau khi đăng nhập thành công
 */
function chuyenDenTrangDangNhap(thongBao, urlQuayLai) {
    const msg = thongBao || 'Vui lòng đăng nhập để sử dụng chức năng này.';
    const redirectUrl = urlQuayLai || window.location.href;
    alert(msg);
    // Chuyển hướng sang trang đăng nhập, đính kèm thông báo và URL quay lại
    window.location.href = 'index.php?action=login&msg=' + encodeURIComponent(msg) + '&redirect=' + encodeURIComponent(redirectUrl);
}

/**
 * 6. dangXuat(): Đăng xuất tài khoản an toàn
 */
function dangXuat() {
    handleLogout();
}

/**
 * 7. moModalGioHang(): Mở modal giỏ hàng (BẮT BUỘC ĐĂNG NHẬP)
 */
function moModalGioHang() {
    if (!kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để xem giỏ hàng của bạn!');
        return;
    }
    const cartModalEl = document.getElementById('cartModal');
    if (cartModalEl && window.bootstrap) {
        const cartModal = new bootstrap.Modal(cartModalEl);
        cartModal.show();
    }
}

/**
 * 8. xemLichSuDonHang(): Mở modal xem đơn hàng của tôi (BẮT BUỘC ĐĂNG NHẬP)
 */
function xemLichSuDonHang() {
    if (!kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để xem danh sách đơn hàng của bạn!');
        return;
    }
    const modalEl = document.getElementById('orderHistoryModal');
    if (modalEl && window.bootstrap) {
        if (typeof renderOrderHistory === 'function') {
            renderOrderHistory();
        }
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

/**
 * 9. Các chức năng khách hàng khác: Đánh giá, Bình luận, Yêu thích, Thông tin tài khoản
 * Tất cả đều bắt buộc kiểm tra đăng nhập trước khi thực hiện
 */
function danhGiaSanPham(productId) {
    if (!kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để đánh giá sản phẩm!');
        return;
    }
    showToast('Cảm ơn bạn! Đánh giá sản phẩm đã được ghi nhận.', 'success');
}

function binhLuanSanPham(productId) {
    if (!kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để bình luận về sản phẩm!');
        return;
    }
    showToast('Bình luận của bạn đã được gửi thành công.', 'success');
}

function quanLyYeuThich(productId) {
    if (!kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để quản lý danh sách yêu thích!');
        return;
    }
    showToast('Đã lưu sản phẩm vào danh sách yêu thích!', 'success');
}

function quanLyThongTinTaiKhoan() {
    if (!kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để quản lý thông tin tài khoản!');
        return;
    }
    showToast('Thông tin tài khoản đang hoạt động.', 'info');
}

// Cập nhật hiển thị giao diện đăng nhập / đăng xuất trên Header
function updateAuthUI() {
    const user = getCurrentUser();

    const guestBox = document.getElementById('authGuestBox');
    const userBox = document.getElementById('authUserBox');
    const userNameSpan = document.getElementById('authUserName');
    const userBadge = document.getElementById('authUserBadge');
    const userIcon = document.getElementById('authUserIcon');
    const adminNavLink = document.getElementById('adminNavLink');
    const adminDashboardLink = document.getElementById('adminDashboardLink');

    if (user) {
        if (guestBox) {
            guestBox.style.setProperty('display', 'none', 'important');
            guestBox.classList.add('d-none');
        }
        if (userBox) {
            userBox.style.setProperty('display', 'flex', 'important');
            userBox.classList.remove('d-none');
        }
        if (userNameSpan) {
            userNameSpan.innerText = user.fullName || user.username;
        }

        if (user.role === 'admin') {
            if (userBadge) {
                userBadge.innerText = 'ADMIN';
                userBadge.className = 'admin-badge ms-1';
            }
            if (userIcon) {
                userIcon.className = 'fa-solid fa-user-shield text-primary';
            }
            if (adminNavLink) {
                adminNavLink.style.setProperty('display', 'block', 'important');
                adminNavLink.classList.remove('d-none');
            }
            if (adminDashboardLink) {
                adminDashboardLink.style.display = 'block';
            }
        } else {
            if (userBadge) {
                userBadge.innerText = 'KHÁCH HÀNG';
                userBadge.className = 'customer-badge ms-1';
            }
            if (userIcon) {
                userIcon.className = 'fa-solid fa-circle-user text-primary';
            }
            if (adminNavLink) {
                adminNavLink.style.setProperty('display', 'none', 'important');
                adminNavLink.classList.add('d-none');
            }
            if (adminDashboardLink) {
                adminDashboardLink.style.display = 'none';
            }
        }
    } else {
        if (guestBox) {
            guestBox.style.setProperty('display', 'flex', 'important');
            guestBox.classList.remove('d-none');
        }
        if (userBox) {
            userBox.style.setProperty('display', 'none', 'important');
            userBox.classList.add('d-none');
        }
        if (adminNavLink) {
            adminNavLink.style.setProperty('display', 'none', 'important');
            adminNavLink.classList.add('d-none');
        }
    }
}

// Xử lý đăng xuất an toàn (gửi POST đến AuthController::logout kèm token CSRF)
function handleLogout() {
    if (!confirm('Bạn có chắc chắn muốn đăng xuất tài khoản?')) {
        return;
    }

    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?action=logout';
    form.style.display = 'none';

    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_csrf';
    tokenInput.value = csrfMeta ? csrfMeta.getAttribute('content') : '';
    form.appendChild(tokenInput);

    document.body.appendChild(form);
    form.submit();
}

// Kiểm tra quyền truy cập khi vào URL trang Admin (index.php?action=admin)
function checkAdminAccess() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'admin') {
        // Chưa đăng nhập -> Chuyển về login
        if (!kiemTraDangNhap()) {
            chuyenDenTrangDangNhap('Vui lòng đăng nhập tài khoản Quản trị để tiếp tục.', 'index.php?action=admin');
            return false;
        }
        // Đã đăng nhập nhưng là khách hàng thông thường -> Từ chối quyền và về trang chủ
        if (!kiemTraQuyenAdmin()) {
            alert('Cảnh báo: Bạn không có quyền truy cập trang Quản trị! Chức năng này chỉ dành riêng cho Admin.');
            window.location.href = 'index.php';
            return false;
        }
    }
    return true;
}

// =============================================================
// PHẦN 10: QUẢN LÝ BIẾN THỂ TRONG ADMIN (ADMIN VARIANTS MANAGEMENT)
// =============================================================

// Mở Modal xem chi tiết và quản lý các biến thể của sản phẩm
let CURRENT_ADMIN_VARIANT_PRODUCT_ID = null;

function openVariantsManagerModal(productId) {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền truy cập chức năng này! Chức năng chỉ dành cho Admin.');
        return;
    }

    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) {
        alert('Không tìm thấy sản phẩm!');
        return;
    }

    CURRENT_ADMIN_VARIANT_PRODUCT_ID = productId;

    const modalTitle = document.getElementById('variantModalProductName');
    if (modalTitle) modalTitle.innerText = product.name;

    renderAdminVariantsTable(product);

    const modalEl = document.getElementById('variantsManagerModal');
    if (modalEl && window.bootstrap) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Render bảng danh sách biến thể trong Modal Admin
function renderAdminVariantsTable(product) {
    const tableBody = document.getElementById('adminVariantsTableBody');
    if (!tableBody) return;

    if (!product.variants || product.variants.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-3 text-muted">Sản phẩm này chưa có biến thể nào!</td></tr>`;
        return;
    }

    tableBody.innerHTML = product.variants.map((v, index) => {
        const isOut = (v.stock <= 0);
        return `
            <tr>
                <td class="fw-bold font-monospace small">
                    <input type="text" class="form-control form-control-sm font-monospace" style="width: 140px;" value="${v.sku}" id="variant_sku_${index}">
                </td>
                <td>
                    <span class="badge bg-light text-dark border px-2 py-1">
                        <i class="fa-solid fa-palette text-primary me-1"></i> ${v.color}
                    </span>
                </td>
                <td>
                    <span class="badge bg-light text-dark border px-2 py-1 fw-bold">${v.storage}</span>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" style="width: 125px;" value="${v.price}" step="50000" id="variant_price_${index}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" style="width: 125px;" value="${v.originalPrice || 0}" step="50000" id="variant_original_${index}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm ${isOut ? 'border-danger text-danger fw-bold' : ''}" style="width: 85px;" value="${v.stock}" min="0" id="variant_stock_${index}">
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm py-1 px-2" onclick="deleteVariant(${index})" title="Xóa biến thể">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

// Lưu tất cả thay đổi về Giá và Tồn kho của các biến thể
function saveAllVariantsChanges() {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền sửa biến thể sản phẩm!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === CURRENT_ADMIN_VARIANT_PRODUCT_ID);
    if (!product || !product.variants) return;

    for (let i = 0; i < product.variants.length; i++) {
        const skuInput = document.getElementById(`variant_sku_${i}`);
        const priceInput = document.getElementById(`variant_price_${i}`);
        const origInput = document.getElementById(`variant_original_${i}`);
        const stockInput = document.getElementById(`variant_stock_${i}`);

        if (skuInput && priceInput && stockInput) {
            const newSku = skuInput.value.trim();
            const newPrice = parseFloat(priceInput.value);
            const newOrig = parseFloat(origInput.value || 0);
            const newStock = parseInt(stockInput.value, 10);

            if (!newSku) {
                alert('Mã SKU không được để trống!');
                skuInput.focus();
                return;
            }
            if (isNaN(newPrice) || newPrice <= 0) {
                alert('Giá bán phải lớn hơn 0!');
                priceInput.focus();
                return;
            }
            if (isNaN(newStock) || newStock < 0) {
                alert('Số lượng tồn kho không được là số âm!');
                stockInput.focus();
                return;
            }

            product.variants[i].sku = newSku;
            product.variants[i].price = newPrice;
            product.variants[i].originalPrice = newOrig > 0 ? newOrig : 0;
            product.variants[i].stock = newStock;
        }
    }

    saveStoredProducts(PRODUCTS);
    showToast(`Đã lưu thay đổi cho tất cả các phiên bản của "${product.name}"!`, 'success');

    // Đóng modal
    const modalEl = document.getElementById('variantsManagerModal');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    // Render lại bảng Admin
    if (typeof renderAdminProductTable === 'function') renderAdminProductTable();
}

// Thêm một biến thể mới vào sản phẩm
function addNewVariantToProduct() {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền thêm biến thể mới!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === CURRENT_ADMIN_VARIANT_PRODUCT_ID);
    if (!product) return;

    const colorInput = document.getElementById('newVariantColor');
    const storageInput = document.getElementById('newVariantStorage');
    const skuInput = document.getElementById('newVariantSku');
    const priceInput = document.getElementById('newVariantPrice');
    const stockInput = document.getElementById('newVariantStock');

    if (!colorInput || !storageInput || !priceInput || !stockInput) return;

    const color = colorInput.value.trim();
    const storage = storageInput.value.trim();
    let sku = skuInput.value.trim();
    const price = parseFloat(priceInput.value);
    const stock = parseInt(stockInput.value, 10);

    if (!color) {
        alert('Vui lòng nhập tên Màu sắc!');
        colorInput.focus();
        return;
    }
    if (!storage) {
        alert('Vui lòng nhập Dung lượng!');
        storageInput.focus();
        return;
    }
    if (isNaN(price) || price <= 0) {
        alert('Giá bán phải lớn hơn 0!');
        priceInput.focus();
        return;
    }
    if (isNaN(stock) || stock < 0) {
        alert('Tồn kho phải từ 0 trở lên!');
        stockInput.focus();
        return;
    }

    // Tự sinh mã SKU nếu trống
    if (!sku) {
        const pCode = product.name.replace(/[^a-zA-Z0-9]/g, '').substring(0, 4).toUpperCase();
        const cCode = color.substring(0, 3).toUpperCase();
        sku = `${pCode}-${cCode}-${storage.replace(/[^a-zA-Z0-9]/g, '')}`;
    }

    if (!product.variants) product.variants = [];

    // Kiểm tra trùng SKU
    if (product.variants.some(v => v.sku.toUpperCase() === sku.toUpperCase())) {
        alert(`Mã SKU "${sku}" đã tồn tại trong sản phẩm này!`);
        return;
    }

    // Thêm màu và dung lượng vào danh sách nếu chưa có
    if (!product.colors) product.colors = [];
    if (!product.colors.some(c => c.name.toLowerCase() === color.toLowerCase())) {
        product.colors.push({ name: color, hex: "#64748b", image: product.image });
    }

    if (!product.storages) product.storages = [];
    if (!product.storages.includes(storage)) {
        product.storages.push(storage);
    }

    // Thêm biến thể mới
    product.variants.push({
        sku: sku,
        color: color,
        storage: storage,
        price: price,
        originalPrice: price,
        stock: stock,
        image: product.image
    });

    saveStoredProducts(PRODUCTS);
    renderAdminVariantsTable(product);

    // Xóa form nhập
    skuInput.value = '';
    priceInput.value = '';
    stockInput.value = '10';

    showToast(`Đã thêm phiên bản "${color} - ${storage}" thành công!`, 'success');
}

// Xóa một biến thể (ADMIN ONLY)
function deleteVariant(index) {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền xóa biến thể sản phẩm!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === CURRENT_ADMIN_VARIANT_PRODUCT_ID);
    if (!product || !product.variants) return;

    if (product.variants.length <= 1) {
        alert('Sản phẩm phải có ít nhất 1 phiên bản!');
        return;
    }

    const v = product.variants[index];
    if (confirm(`Bạn có chắc chắn muốn xóa phiên bản "${v.color} - ${v.storage} (SKU: ${v.sku})"?`)) {
        product.variants.splice(index, 1);
        saveStoredProducts(PRODUCTS);
        renderAdminVariantsTable(product);
        showToast('Đã xóa phiên bản thành công!', 'info');
    }
}

// =============================================================
// PHẦN 11: CHỈNH SỬA THÔNG TIN CHUNG SẢN PHẨM TRONG ADMIN (MODAL 8 TRƯỜNG)
// =============================================================
function openEditProductModal(productId) {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền chỉnh sửa thông tin sản phẩm!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    const idInput = document.getElementById('editProductId');
    const nameInput = document.getElementById('editProductName');
    const categorySelect = document.getElementById('editProductCategory');
    const brandInput = document.getElementById('editProductBrand');
    const priceInput = document.getElementById('editProductPrice');
    const promoPriceInput = document.getElementById('editProductPromoPrice');
    const stockInput = document.getElementById('editProductStock');
    const statusSelect = document.getElementById('editProductStatus');
    const imageInput = document.getElementById('editProductImage');
    const descInput = document.getElementById('editProductDescription');
    const imgPreview = document.getElementById('editProductImagePreview');
    const alertBox = document.getElementById('editProductAlert');

    if (!idInput || !nameInput) return;
    if (alertBox) alertBox.style.display = 'none';

    idInput.value = product.id;
    nameInput.value = product.name;
    if (categorySelect) categorySelect.value = product.category || 'phone';
    if (brandInput) brandInput.value = product.brand || 'Apple';
    if (priceInput) priceInput.value = getProductMinPrice(product);
    if (promoPriceInput) promoPriceInput.value = '';
    if (stockInput) stockInput.value = getProductTotalStock(product);
    if (statusSelect) statusSelect.value = product.status || 'active';
    if (imageInput) imageInput.value = product.image || '';
    if (descInput) descInput.value = product.description || '';

    if (imgPreview) {
        imgPreview.src = product.image || '';
        imgPreview.onerror = function() { handleImageError(this, product.name); };
    }

    const modalEl = document.getElementById('editProductModal');
    if (modalEl && window.bootstrap) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

function previewEditImage() {
    const imageInput = document.getElementById('editProductImage');
    const imgPreview = document.getElementById('editProductImagePreview');
    if (imageInput && imgPreview) {
        imgPreview.src = imageInput.value.trim();
    }
}

function saveProductChanges() {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền lưu thay đổi sản phẩm!');
        return;
    }

    const idInput = document.getElementById('editProductId');
    const nameInput = document.getElementById('editProductName');
    const categorySelect = document.getElementById('editProductCategory');
    const brandInput = document.getElementById('editProductBrand');
    const priceInput = document.getElementById('editProductPrice');
    const statusSelect = document.getElementById('editProductStatus');
    const imageInput = document.getElementById('editProductImage');
    const descInput = document.getElementById('editProductDescription');
    const alertBox = document.getElementById('editProductAlert');

    function showError(msg) {
        if (alertBox) {
            alertBox.className = 'alert alert-danger py-2 small mb-3';
            alertBox.innerHTML = `<i class="fa-solid fa-triangle-exclamation me-1"></i> ${msg}`;
            alertBox.style.display = 'block';
        } else {
            alert(msg);
        }
    }

    const productId = parseInt(idInput.value, 10);
    const newName = nameInput.value.trim();
    const newCategory = categorySelect.value;
    const newBrand = brandInput ? brandInput.value.trim() : 'Apple';
    const newStatus = statusSelect.value;
    const newImage = imageInput.value.trim();
    const newDesc = descInput.value.trim();

    if (!newName) {
        showError('Tên sản phẩm không được để trống!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    const categoryMap = {
        phone: 'Điện thoại',
        laptop: 'Laptop',
        tablet: 'Máy tính bảng',
        accessory: 'Phụ kiện'
    };

    product.name = newName;
    product.category = newCategory;
    product.categoryName = categoryMap[newCategory] || 'Công nghệ';
    product.brand = newBrand;
    product.status = newStatus;
    if (newImage) product.image = newImage;
    product.description = newDesc;

    saveStoredProducts(PRODUCTS);

    const modalEl = document.getElementById('editProductModal');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    showToast(`Đã cập nhật thông tin sản phẩm "${newName}" thành công!`, 'success');
    if (typeof renderAdminProductTable === 'function') renderAdminProductTable();
}

// Xóa sản phẩm khỏi hệ thống (ADMIN ONLY)
function deleteProduct(productId) {
    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền xóa sản phẩm!');
        return;
    }

    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${product.name}" cùng tất cả các phiên bản của nó?`)) {
        PRODUCTS = PRODUCTS.filter(p => p.id !== productId);
        saveStoredProducts(PRODUCTS);
        showToast(`Đã xóa sản phẩm "${product.name}" khỏi hệ thống!`, 'info');
        if (typeof renderAdminProductTable === 'function') renderAdminProductTable();
    }
}

// =============================================================
// PHẦN 12: THÊM SẢN PHẨM MỚI KÈM BIẾN THỂ TRONG ADMIN (ADMIN ONLY)
// =============================================================
function handleAddProductWithVariants(event) {
    if (event) event.preventDefault();

    if (typeof kiemTraQuyenAdmin === 'function' && !kiemTraQuyenAdmin()) {
        alert('Cảnh báo: Bạn không có quyền thêm sản phẩm mới!');
        return;
    }

    const nameInput = document.getElementById('addProductName');
    const categorySelect = document.getElementById('addProductCategory');
    const brandInput = document.getElementById('addProductBrand');
    const imageInput = document.getElementById('addProductImage');
    const colorsInput = document.getElementById('addProductColors');
    const storagesInput = document.getElementById('addProductStorages');
    const basePriceInput = document.getElementById('addProductBasePrice');
    const baseStockInput = document.getElementById('addProductBaseStock');
    const descInput = document.getElementById('addProductDescription');

    if (!nameInput || !basePriceInput || !baseStockInput) return;

    const name = nameInput.value.trim();
    const category = categorySelect ? categorySelect.value : 'phone';
    const brand = brandInput ? brandInput.value.trim() : 'Apple';
    const image = imageInput ? (imageInput.value.trim() || 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80') : '';
    const rawColors = colorsInput ? colorsInput.value.trim() : 'Đen, Xanh dương, Hồng, Vàng';
    const rawStorages = storagesInput ? storagesInput.value.trim() : '128GB, 256GB, 512GB';
    const basePrice = parseFloat(basePriceInput.value);
    const baseStock = parseInt(baseStockInput.value, 10);
    const desc = descInput ? descInput.value.trim() : '';

    if (!name) {
        alert('Vui lòng nhập tên sản phẩm!');
        nameInput.focus();
        return;
    }
    if (isNaN(basePrice) || basePrice <= 0) {
        alert('Giá bán cơ bản phải lớn hơn 0!');
        basePriceInput.focus();
        return;
    }

    // Tách danh sách màu sắc và dung lượng từ chuỗi nhập vào
    const colorNames = rawColors.split(',').map(c => c.trim()).filter(c => c.length > 0);
    const storageNames = rawStorages.split(',').map(s => s.trim()).filter(s => s.length > 0);

    const colors = colorNames.map(c => ({
        name: c,
        hex: '#3b82f6',
        image: image
    }));

    // Tự động sinh mã SKU và danh sách biến thể theo tổ hợp Màu x Dung lượng
    const pCode = name.replace(/[^a-zA-Z0-9]/g, '').substring(0, 4).toUpperCase();
    const variants = [];

    colorNames.forEach(c => {
        const cCode = c.substring(0, 3).toUpperCase();
        storageNames.forEach((s, sIdx) => {
            const sCode = s.replace(/[^a-zA-Z0-9]/g, '');
            // Mỗi mức dung lượng tăng thêm giá một chút
            const stepPrice = basePrice + (sIdx * 2000000);
            variants.push({
                sku: `${pCode}-${cCode}-${sCode}`,
                color: c,
                storage: s,
                price: stepPrice,
                originalPrice: stepPrice + 2000000,
                stock: baseStock,
                image: image
            });
        });
    });

    const categoryMap = {
        phone: 'Điện thoại',
        laptop: 'Laptop',
        tablet: 'Máy tính bảng',
        accessory: 'Phụ kiện'
    };

    const newId = PRODUCTS.length > 0 ? Math.max(...PRODUCTS.map(p => p.id)) + 1 : 1;

    const newProduct = {
        id: newId,
        name: name,
        brand: brand,
        category: category,
        categoryName: categoryMap[category] || 'Công nghệ',
        image: image,
        description: desc || `Sản phẩm ${name} chính hãng chất lượng cao.`,
        status: 'active',
        isFeatured: true,
        isNew: true,
        isPromo: false,
        rating: 5.0,
        reviews: 1,
        colors: colors,
        storages: storageNames,
        variants: variants
    };

    PRODUCTS.unshift(newProduct);
    saveStoredProducts(PRODUCTS);

    // Đóng Modal Thêm sản phẩm
    const modalEl = document.getElementById('addProductModal');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    showToast(`Đã thêm sản phẩm "${name}" với ${variants.length} phiên bản thành công!`, 'success');
    if (typeof renderAdminProductTable === 'function') renderAdminProductTable();
}

// =============================================================
// PHẦN 13: KHỞI TẠO ỨNG DỤNG KHI TẢI TRANG (INIT ON DOM READY)
// =============================================================
document.addEventListener('DOMContentLoaded', () => {
    // 1. Kiểm tra quyền bảo vệ nếu đang ở trang Admin
    if (!checkAdminAccess()) return;

    // 2. Cập nhật trạng thái đăng nhập trên Header
    updateAuthUI();

    // 3. Cập nhật giao diện giỏ hàng
    updateCartUI();

    // 4. Khởi tạo trang thanh toán nếu đang ở URL checkout
    if (window.location.search.includes('action=checkout')) {
        if (typeof khoiTaoTrangThanhToan === 'function') {
            khoiTaoTrangThanhToan();
        }
    }

    // 5. Render sản phẩm trang chủ
    renderHomePageProducts();

    // 6. Lắng nghe form tìm kiếm
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }

    // 7. Form đăng nhập / đăng ký được xử lý server-side (AuthController + MySQL)
});
