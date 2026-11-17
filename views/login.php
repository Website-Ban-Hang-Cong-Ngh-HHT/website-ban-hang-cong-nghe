<!-- ========================================================= -->
<!-- TRANG ĐĂNG NHẬP ADMIN / NGƯỜI DÙNG (views/login.php)       -->
<!-- Xử lý server-side: AuthController::login() + MySQL         -->
<!-- ========================================================= -->

<?php
$oldLogin = $old['login'] ?? '';

$flash        = flash_get();
$alertType    = $flash['type'] ?? '';
$alertMessage = $flash['message'] ?? '';

if (!empty($error)) {
    $alertType    = 'danger';
    $alertMessage = $error;
}
if ($alertType === 'error') {
    $alertType = 'danger';
}
$alertIcon = $alertType === 'success'
    ? 'fa-circle-check'
    : ($alertType === 'warning' ? 'fa-circle-exclamation' : 'fa-triangle-exclamation');
?>

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
                    <div>• <b>Admin:</b> <code class="fw-bold text-dark">admin</code> / <code class="fw-bold text-dark">123456</code></div>
                    <div>• <b>Khách hàng:</b> Đăng nhập bằng tài khoản đã đăng ký trong CSDL</div>
                </div>
            </div>

            <!-- Khung hiển thị thông báo lỗi hoặc thành công -->
            <?php if ($alertMessage !== ''): ?>
                <div class="alert alert-<?= e($alertType ?: 'danger') ?> mb-3" role="alert">
                    <i class="fa-solid <?= e($alertIcon) ?> me-2"></i>
                    <?= e($alertMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Form Đăng nhập (gửi dữ liệu về AuthController::login) -->
            <form id="loginForm" method="post" action="index.php?action=login">
                <?= csrf_field() ?>

                <!-- Tên đăng nhập / Email -->
                <div class="mb-3">
                    <label for="loginUsername" class="form-label fw-semibold">
                        <i class="fa-solid fa-user me-1 text-primary"></i> Tên đăng nhập hoặc Email
                    </label>
                    <input type="text"
                           class="form-control py-2"
                           id="loginUsername"
                           name="login"
                           value="<?= e($oldLogin) ?>"
                           placeholder="Nhập 'admin' hoặc tài khoản / email đã đăng ký..."
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
                               name="password"
                               placeholder="Nhập mật khẩu của bạn..."
                               required>
                        <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword" onclick="togglePasswordVisibility()">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Điền nhanh tài khoản demo -->
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <a href="javascript:void(0)" class="small text-primary text-decoration-none" onclick="fillDemoCredentials()">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Điền nhanh tài khoản Admin
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
    if (passInp) passInp.value = '123456';
}
</script>
