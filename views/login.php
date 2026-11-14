<!-- ========================================================= -->
<!-- TRANG ĐĂNG NHẬP ADMIN / NGƯỜI DÙNG (views/login.php) -->
<!-- ========================================================= -->

<div class="auth-wrapper">
    <div class="auth-card">
        <!-- Đầu thẻ Đăng nhập -->
        <div class="auth-header">
            <div class="mb-2">
                <i class="fa-solid fa-shield-halved fa-3x text-primary"></i>
            </div>
            <h3>Đăng Nhập Hệ Thống</h3>
            <p>Chào mừng bạn quay trở lại với TECH STORE</p>
        </div>

        <!-- Thân thẻ Đăng nhập -->
        <div class="auth-body">

            <!-- Khung gợi ý tài khoản Demo cho sinh viên thực hành -->
            <div class="demo-account-hint">
                <div class="d-flex align-items-center mb-1">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Hỗ trợ đăng nhập:</strong>
                </div>
                <div class="ms-4">
                    <div>• <b>Admin:</b> <code class="fw-bold text-dark">admin</code> / <code class="fw-bold text-dark">admin123</code></div>
                    <div>• <b>Khách hàng:</b> Đăng nhập bằng tài khoản bạn đã đăng ký</div>
                </div>
            </div>

            <!-- Khung hiển thị thông báo lỗi hoặc thành công -->
            <div id="loginAlert" class="alert" style="display: none;" role="alert"></div>

            <!-- Form Đăng nhập -->
            <form id="loginForm">
                <!-- Tên đăng nhập -->
                <div class="mb-3">
                    <label for="loginUsername" class="form-label fw-semibold">
                        <i class="fa-solid fa-user me-1 text-primary"></i> Tên đăng nhập / Tài khoản
                    </label>
                    <input type="text" 
                           class="form-control py-2" 
                           id="loginUsername" 
                           placeholder="Nhập 'admin' hoặc tài khoản đã đăng ký..." 
                           required 
                           autofocus>
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label for="loginPassword" class="form-label fw-semibold">
                        <i class="fa-solid fa-lock me-1 text-primary"></i> Mật khẩu
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control py-2" 
                               id="loginPassword" 
                               placeholder="Nhập 'admin123'..." 
                               required>
                        <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword" onclick="togglePasswordVisibility()">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Ghi nhớ đăng nhập demo -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                        <label class="form-check-label small text-muted" for="rememberMe">
                            Ghi nhớ tài khoản
                        </label>
                    </div>
                    <a href="javascript:void(0)" class="small text-primary text-decoration-none" onclick="fillDemoCredentials()">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Điền nhanh
                    </a>
                </div>

                <!-- Nút Đăng nhập -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm mb-3">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Đăng Nhập
                </button>

                <!-- Dòng chuyển sang trang Đăng ký -->
                <div class="text-center pt-2 pb-2 border-top">
                    <span class="small text-muted">Bạn chưa có tài khoản?</span>
                    <a href="index.php?action=register" class="small fw-bold text-primary text-decoration-none ms-1">
                        Đăng ký ngay
                    </a>
                </div>

                <!-- Nút trở về trang chủ -->
                <div class="text-center mt-2">
                    <a href="index.php" class="text-muted small text-decoration-none">
                        <i class="fa-solid fa-arrow-left me-1"></i> Trở về Trang chủ
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script phụ trợ cho trang Đăng nhập -->
<script>
// Hàm ẩn/hiện mật khẩu
function togglePasswordVisibility() {
    const passInput = document.getElementById('loginPassword');
    const passIcon = document.getElementById('togglePasswordIcon');
    if (!passInput || !passIcon) return;

    if (passInput.type === 'password') {
        passInput.type = 'text';
        passIcon.className = 'fa-regular fa-eye-slash';
    } else {
        passInput.type = 'password';
        passIcon.className = 'fa-regular fa-eye';
    }
}

// Hàm điền nhanh tài khoản demo
function fillDemoCredentials() {
    const userInp = document.getElementById('loginUsername');
    const passInp = document.getElementById('loginPassword');
    if (userInp) userInp.value = 'admin';
    if (passInp) passInp.value = 'admin123';
}
</script>
