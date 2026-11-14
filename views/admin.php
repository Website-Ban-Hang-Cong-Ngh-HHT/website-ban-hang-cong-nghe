<!-- ========================================================= -->
<!-- TRANG QUẢN TRỊ ADMIN (views/admin.php) -->
<!-- Tập trung vào: Quản trị Admin và Trạng thái Đăng nhập / Đăng xuất -->
<!-- Không chứa danh sách hay số liệu đơn hàng -->
<!-- ========================================================= -->

<div class="container admin-dashboard pb-5">

    <!-- 1. TIÊU ĐỀ TRANG QUẢN TRỊ -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center bg-white p-4 rounded-3 shadow-sm border mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-warning text-dark px-2 py-1 fw-bold">ADMINISTRATOR</span>
                <h3 class="fw-bold mb-0 text-dark">Khu Vực Quản Trị Hệ Thống</h3>
            </div>
            <p class="text-muted small mb-0">Quản lý tài khoản Admin, phiên đăng nhập và bảo vệ quyền truy cập hệ thống TECH STORE</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="index.php" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-store me-1"></i> Xem Trang Bán Hàng
            </a>
            <button type="button" class="btn btn-danger btn-sm" onclick="handleLogout()">
                <i class="fa-solid fa-right-from-bracket me-1"></i> Đăng Xuất Admin
            </button>
        </div>
    </div>

    <!-- 2. KHỐI THÔNG TIN TÀI KHOẢN ADMIN VÀ BẢO VỆ PHIÊN ĐĂNG NHẬP -->
    <div class="row g-4 mb-4">
        <!-- Cột trái: Thẻ Hồ Sơ Admin đang đăng nhập -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-user-shield me-2"></i> Hồ Sơ Tài Khoản Admin
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <!-- Avatar Admin -->
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light text-primary rounded-circle border border-3 border-primary shadow-sm" style="width: 90px; height: 90px; font-size: 2.5rem;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                    </div>
                    
                    <h4 class="fw-bold mb-1 text-dark" id="adminCardName">Quản trị viên</h4>
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark px-3 py-1 fw-bold">Vai trò: Toàn quyền (Admin)</span>
                    </div>

                    <!-- Bảng thông tin chi tiết phiên làm việc -->
                    <div class="text-start bg-light p-3 rounded-3 small mb-4">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Tên tài khoản:</span>
                            <span class="fw-bold" id="adminCardUsername">admin</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Trạng thái hiện tại:</span>
                            <span class="text-success fw-bold">
                                <i class="fa-solid fa-circle-dot me-1"></i> Đang hoạt động (Online)
                            </span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Bộ nhớ lưu trữ:</span>
                            <span class="badge bg-secondary">LocalStorage</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Thời điểm đăng nhập:</span>
                            <span class="text-muted" id="adminLoginTime">Vừa xong</span>
                        </div>
                    </div>

                    <!-- Nút thao tác đăng xuất -->
                    <button type="button" class="btn btn-outline-danger w-100 py-2 fw-bold" onclick="handleLogout()">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Đăng Xuất Khỏi Hệ Thống
                    </button>
                </div>
            </div>
        </div>

        <!-- Cột phải: Hướng dẫn kiểm tra chức năng Xác thực & Bảo vệ trang -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-shield-check text-success me-2"></i> Cơ Chế Đăng Nhập & Bảo Mật Front-End
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Hộp 1: Cách hoạt động của LocalStorage -->
                    <div class="d-flex align-items-start gap-3 mb-3 p-3 bg-light rounded-3">
                        <div class="text-primary fs-3 mt-1">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">1. Duy trì trạng thái đăng nhập qua LocalStorage</h6>
                            <p class="text-muted small mb-0">
                                Khi Admin đăng nhập thành công với tài khoản <code>admin</code> / <code>admin123</code>, thông tin được lưu trữ an toàn trong <code>localStorage.setItem('techstore_user', ...)</code>. Khi bạn bấm phím <b>F5 (Tải lại trang)</b>, trạng thái Admin vẫn được giữ nguyên.
                            </p>
                        </div>
                    </div>

                    <!-- Hộp 2: Cơ chế ngăn chặn truy cập trái phép -->
                    <div class="d-flex align-items-start gap-3 mb-3 p-3 bg-light rounded-3">
                        <div class="text-danger fs-3 mt-1">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">2. Bảo vệ trang quản trị (Admin Guard)</h6>
                            <p class="text-muted small mb-0">
                                Nếu một người dùng chưa đăng nhập cố tình gõ đường dẫn <code>index.php?action=admin</code> trên trình duyệt, JavaScript sẽ tự động kiểm tra, hiển thị cảnh báo và đẩy ngay về trang đăng nhập <code>index.php?action=login</code>.
                            </p>
                        </div>
                    </div>

                    <!-- Hộp 3: Cơ chế đăng xuất -->
                    <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3">
                        <div class="text-warning fs-3 mt-1">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">3. Đăng xuất tức thì</h6>
                            <p class="text-muted small mb-0">
                                Khi nhấn <b>Đăng xuất</b>, hàm <code>handleLogout()</code> sẽ xóa key đăng nhập khỏi LocalStorage và tự động cập nhật Header về trạng thái khách ban đầu, đồng thời điều hướng về trang chủ.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. BẢNG DANH SÁCH SẢN PHẨM CÔNG NGHỆ (QUẢN TRỊ SẢN PHẨM) -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Danh Sách Sản Phẩm Công Nghệ Đang Bán
            </h5>
            <span class="badge bg-primary px-3 py-2">Tổng số: 16 sản phẩm</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width: 60px;">ID</th>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Giá Bán</th>
                            <th>Giá Gốc</th>
                            <th>Trạng Thái</th>
                            <th class="text-end pe-3" style="width: 140px;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="adminProductTableBody">
                        <!-- Danh sách sản phẩm được JavaScript tự động tạo ở đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Script hỗ trợ riêng cho trang Admin -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Kiểm tra lại quyền Admin (nếu chưa đăng nhập sẽ lập tức bị chặn)
    const user = typeof getCurrentUser === 'function' ? getCurrentUser() : null;
    if (!user || user.role !== 'admin') {
        alert('Cảnh báo: Bạn phải đăng nhập tài khoản Admin để truy cập trang này!');
        window.location.href = 'index.php?action=login';
        return;
    }

    // 2. Điền thông tin Admin lên thẻ Profile
    const cardName = document.getElementById('adminCardName');
    const cardUser = document.getElementById('adminCardUsername');
    const loginTime = document.getElementById('adminLoginTime');

    if (cardName && user.fullName) cardName.innerText = user.fullName;
    if (cardUser && user.username) cardUser.innerText = user.username;
    if (loginTime && user.loginAt) {
        try {
            const date = new Date(user.loginAt);
            loginTime.innerText = date.toLocaleTimeString('vi-VN') + ' - ' + date.toLocaleDateString('vi-VN');
        } catch (e) {
            loginTime.innerText = 'Đang hoạt động';
        }
    }

    // 3. Render danh sách sản phẩm vào bảng quản trị
    renderAdminProductTable();
});

// Hàm hiển thị bảng quản lý sản phẩm
function renderAdminProductTable() {
    const tableBody = document.getElementById('adminProductTableBody');
    if (!tableBody || typeof PRODUCTS === 'undefined') return;

    tableBody.innerHTML = PRODUCTS.map(product => {
        let badges = '';
        if (product.isFeatured) badges += '<span class="badge bg-warning text-dark me-1">Hot</span>';
        if (product.isNew) badges += '<span class="badge bg-info text-dark me-1">Mới</span>';
        if (product.isPromo) badges += '<span class="badge bg-danger">Sale</span>';

        return `
            <tr>
                <td class="ps-3 fw-bold text-muted">#${product.id}</td>
                <td>
                    <img src="${product.image}" 
                         alt="${product.name}" 
                         class="rounded border p-1" 
                         style="width: 50px; height: 50px; object-fit: contain;"
                         onerror="handleImageError(this, '${product.name.replace(/'/g, "\\'")}')">
                </td>
                <td>
                    <div class="fw-bold text-dark">${product.name}</div>
                    <div class="small text-muted text-truncate" style="max-width: 320px;">${product.description}</div>
                </td>
                <td><span class="badge bg-light text-dark border">${product.categoryName}</span></td>
                <td class="fw-bold text-danger">${formatCurrency(product.price)}</td>
                <td class="text-muted small text-decoration-line-through">${product.originalPrice ? formatCurrency(product.originalPrice) : '-'}</td>
                <td>${badges || '<span class="text-muted small">Thường</span>'}</td>
                <td class="text-end pe-3">
                    <button class="btn btn-outline-primary btn-sm me-1" onclick="showProductDetail(${product.id})" title="Xem chi tiết">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-sm me-1" onclick="alert('Chức năng Demo: Sửa sản phẩm #' + ${product.id})" title="Sửa (Demo)">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="if(confirm('Xác nhận xóa sản phẩm #' + ${product.id} + '?')) alert('Đã xóa sản phẩm mô phỏng!')" title="Xóa (Demo)">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}
</script>
