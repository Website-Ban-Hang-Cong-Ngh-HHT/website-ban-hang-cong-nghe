<!-- ========================================================= -->
<!-- TRANG ĐĂNG KÝ TÀI KHOẢN KHÁCH HÀNG (views/register.php)    -->
<!-- Xử lý server-side: AuthController::register() + MySQL      -->
<!-- ========================================================= -->

<?php
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

$redirectParam = trim((string) ($_GET['redirect'] ?? $_POST['redirect'] ?? ''));
?>

<div class="auth-wrapper py-5">
    <div class="auth-card shadow-lg" style="max-width: 520px;">
        <!-- Đầu thẻ Đăng ký -->
        <div class="auth-header text-center">
            <div class="mb-2">
                <i class="fa-solid fa-user-plus fa-3x text-primary"></i>
            </div>
            <h3 class="fw-bold mb-1">Tạo Tài Khoản Mới</h3>
            <p class="text-light-50 small mb-0">Đăng ký thành viên TECH STORE để nhận ngay ưu đãi 10%</p>
        </div>

        <!-- Thân thẻ Đăng ký -->
        <div class="auth-body p-4">

            <!-- Khung hiển thị thông báo kết quả (Lỗi / Thành công) -->
            <?php if ($alertMessage !== ''): ?>
                <div class="alert alert-<?= e($alertType ?: 'danger') ?> mb-3" role="alert">
                    <i class="fa-solid <?= e($alertIcon) ?> me-2"></i>
                    <?= e($alertMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Form Đăng ký (gửi dữ liệu về AuthController::register) -->
            <form id="registerForm" method="post" action="index.php?action=register">
                <?= csrf_field() ?>
                <input type="hidden" name="redirect" value="<?= e($redirectParam) ?>">

                <!-- 1. Họ và tên -->
                <div class="mb-3">
                    <label for="registerFullName" class="form-label fw-semibold small">
                        <i class="fa-solid fa-id-card me-1 text-primary"></i> Họ và tên <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control"
                           id="registerFullName"
                           name="full_name"
                           value="<?= e($old['full_name'] ?? '') ?>"
                           placeholder="Ví dụ: Nguyễn Văn An"
                           required
                           autofocus>
                    <div class="form-text small text-muted">Nhập họ và tên đầy đủ của bạn.</div>
                </div>

                <!-- 2. Tên đăng nhập -->
                <div class="mb-3">
                    <label for="registerUsername" class="form-label fw-semibold small">
                        <i class="fa-solid fa-user me-1 text-primary"></i> Tên đăng nhập <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control"
                           id="registerUsername"
                           name="username"
                           value="<?= e($old['username'] ?? '') ?>"
                           placeholder="Ví dụ: nguyenvana (viết liền, không dấu)"
                           minlength="3"
                           maxlength="30"
                           required>
                    <div class="form-text small text-muted">Chỉ gồm chữ không dấu, số, dấu gạch dưới; tối thiểu 3 ký tự.</div>
                </div>

                <!-- 3. Địa chỉ Email -->
                <div class="mb-3">
                    <label for="registerEmail" class="form-label fw-semibold small">
                        <i class="fa-solid fa-envelope me-1 text-primary"></i> Địa chỉ Email <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           class="form-control"
                           id="registerEmail"
                           name="email"
                           value="<?= e($old['email'] ?? '') ?>"
                           placeholder="Ví dụ: nguyenvana@gmail.com"
                           required>
                    <div class="form-text small text-muted">Email dùng để nhận thông báo và bảo mật tài khoản.</div>
                </div>

                <!-- 4. Số điện thoại -->
                <div class="mb-3">
                    <label for="registerPhone" class="form-label fw-semibold small">
                        <i class="fa-solid fa-phone me-1 text-primary"></i> Số điện thoại <span class="text-danger">*</span>
                    </label>
                    <input type="tel"
                           class="form-control"
                           id="registerPhone"
                           name="phone"
                           value="<?= e($old['phone'] ?? '') ?>"
                           placeholder="Ví dụ: 0988123456 (10 chữ số)"
                           pattern="0[0-9]{9}"
                           maxlength="10"
                           required>
                    <div class="form-text small text-muted">Bắt đầu bằng số 0, đủ 10 chữ số.</div>
                </div>

                <!-- 5. Mật khẩu -->
                <div class="mb-3">
                    <label for="registerPassword" class="form-label fw-semibold small">
                        <i class="fa-solid fa-lock me-1 text-primary"></i> Mật khẩu <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password"
                               class="form-control"
                               id="registerPassword"
                               name="password"
                               placeholder="Tối thiểu 6 ký tự..."
                               minlength="6"
                               required>
                        <button class="btn btn-outline-secondary" type="button" onclick="toggleRegisterPassword('registerPassword', 'toggleRegisterPassIcon')">
                            <i class="fa-regular fa-eye" id="toggleRegisterPassIcon"></i>
                        </button>
                    </div>
                    <div class="form-text small text-muted">Mật khẩu được mã hoá an toàn trước khi lưu vào CSDL.</div>
                </div>

                <!-- 6. Nhập lại mật khẩu -->
                <div class="mb-3">
                    <label for="registerConfirmPassword" class="form-label fw-semibold small">
                        <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Xác nhận lại mật khẩu <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password"
                               class="form-control"
                               id="registerConfirmPassword"
                               name="confirm_password"
                               placeholder="Nhập lại mật khẩu vừa nhập..."
                               minlength="6"
                               required>
                        <button class="btn btn-outline-secondary" type="button" onclick="toggleRegisterPassword('registerConfirmPassword', 'toggleRegisterConfirmPassIcon')">
                            <i class="fa-regular fa-eye" id="toggleRegisterConfirmPassIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Điều khoản sử dụng -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="registerAgree" name="agree" value="1" checked required>
                    <label class="form-check-label small text-muted" for="registerAgree">
                        Tôi đồng ý với các <a href="javascript:void(0)" class="text-primary text-decoration-none">Điều khoản dịch vụ</a> và <a href="javascript:void(0)" class="text-primary text-decoration-none">Chính sách bảo mật</a> của TECH STORE.
                    </label>
                </div>

                <!-- Nút Đăng ký -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm mb-3">
                    <i class="fa-solid fa-user-check me-2"></i> Đăng Ký Tài Khoản
                </button>

                <!-- Liên kết quay về đăng nhập -->
                <div class="text-center pt-2 border-top">
                    <span class="small text-muted">Bạn đã có tài khoản?</span>
                    <a href="index.php?action=login<?= $redirectParam !== '' ? '&redirect=' . urlencode($redirectParam) : '' ?>" class="small fw-bold text-primary text-decoration-none ms-1">
                        Đăng nhập ngay
                    </a>
                </div>

                <!-- Nút trở về trang chủ -->
                <div class="text-center mt-3">
                    <a href="index.php" class="text-muted small text-decoration-none">
                        <i class="fa-solid fa-arrow-left me-1"></i> Trở về Trang chủ
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script phụ trợ cho trang Đăng ký (Ẩn/Hiện mật khẩu) -->
<script>
function toggleRegisterPassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-regular fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa-regular fa-eye';
    }
}
</script>
