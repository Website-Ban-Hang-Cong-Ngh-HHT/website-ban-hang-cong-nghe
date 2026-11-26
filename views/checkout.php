<!-- ========================================================= -->
<!-- TRANG 1: THÔNG TIN NHẬN HÀNG (views/checkout.php)         -->
<!-- ========================================================= -->

<div class="container py-4 checkout-page-container" style="max-width: 860px;">

    <!-- 1. TIÊU ĐỀ VÀ THANH TIẾN TRÌNH (BƯỚC 2: THÔNG TIN NHẬN HÀNG) -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark mb-2">
            <i class="fa-solid fa-location-dot text-primary me-2"></i>Thông Tin Nhận Hàng
        </h2>
        <p class="text-muted small mb-4">Bước 2: Vui lòng nhập địa chỉ và thông tin nhận hàng để TECH STORE chuẩn bị đơn hàng cho bạn</p>

        <!-- Thanh tiến trình 3 bước: Giỏ hàng -> Thông tin nhận hàng -> Xác nhận đơn hàng -->
        <div class="checkout-steps-wrapper">
            <div class="checkout-step completed">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <div class="step-label">1. Giỏ hàng</div>
            </div>
            <div class="step-line active"></div>
            <div class="checkout-step active" id="stepIndicatorInfo">
                <div class="step-circle">2</div>
                <div class="step-label">2. Thông tin nhận hàng</div>
            </div>
            <div class="step-line" id="stepLineFinal"></div>
            <div class="checkout-step" id="stepIndicatorComplete">
                <div class="step-circle">3</div>
                <div class="step-label">3. Xác nhận đơn hàng</div>
            </div>
        </div>
    </div>

    <!-- 2. KHỐI KHI GIỎ HÀNG TRỐNG (ẨN MẶC ĐỊNH, HIỂN THỊ KHI CART = 0) -->
    <div id="checkoutEmptySection" class="card border-0 shadow-sm rounded-4 p-5 text-center my-4" style="display: none;">
        <div class="cart-empty-icon mx-auto mb-3">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống!</h4>
        <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
            Bạn chưa có sản phẩm nào trong giỏ hàng. Vui lòng quay lại cửa hàng để chọn các sản phẩm công nghệ yêu thích trước khi điền thông tin nhận hàng.
        </p>
        <div>
            <a href="index.php" class="btn btn-primary px-4 py-2 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Quay lại mua sắm ngay
            </a>
        </div>
    </div>

    <!-- 3. KHỐI FORM THÔNG TIN NHẬN HÀNG (TRANG 1) -->
    <div id="checkoutShippingContainer" class="card border-0 shadow-sm rounded-4 p-4 p-md-5 checkout-customer-card">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-2">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="fa-regular fa-address-card text-primary me-2"></i>Địa chỉ người nhận
                </h4>
                <div class="text-muted small">Thông tin này sẽ được dùng để in phiếu giao hàng và gửi thông báo đơn hàng</div>
            </div>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fw-semibold">
                * Các trường bắt buộc
            </span>
        </div>

        <form id="checkoutShippingForm" novalidate onsubmit="event.preventDefault(); goToOrderReviewPage();">
            <div class="row g-3">
                
                <!-- 1. Họ và tên người nhận -->
                <div class="col-12 col-md-6">
                    <label for="checkoutFullName" class="form-label fw-semibold small">
                        Họ và tên người nhận <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-user"></i></span>
                        <input type="text" class="form-control" id="checkoutFullName" placeholder="Ví dụ: Nguyễn Văn An" required>
                    </div>
                    <div class="invalid-feedback" id="errorFullName">Vui lòng nhập họ và tên của người nhận hàng!</div>
                </div>

                <!-- 2. Số điện thoại -->
                <div class="col-12 col-md-6">
                    <label for="checkoutPhone" class="form-label fw-semibold small">
                        Số điện thoại liên hệ <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-phone"></i></span>
                        <input type="tel" class="form-control" id="checkoutPhone" placeholder="Ví dụ: 0988123456" required>
                    </div>
                    <div class="invalid-feedback" id="errorPhone">Số điện thoại phải gồm 10 chữ số bắt đầu bằng số 0!</div>
                </div>

                <!-- 3. Địa chỉ Email -->
                <div class="col-12">
                    <label for="checkoutEmail" class="form-label fw-semibold small">
                        Địa chỉ Email <span class="text-muted fw-normal">(Không bắt buộc - dùng để nhận hóa đơn và thông báo hành trình đơn hàng)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" class="form-control" id="checkoutEmail" placeholder="name@example.com">
                    </div>
                    <div class="invalid-feedback" id="errorEmail">Địa chỉ email không đúng định dạng (Ví dụ: name@example.com)!</div>
                </div>

                <!-- 4. Tỉnh / Thành phố -->
                <div class="col-12 col-md-4">
                    <label for="checkoutProvince" class="form-label fw-semibold small">
                        Tỉnh / Thành phố <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="checkoutProvince" required>
                        <option value="">-- Chọn Tỉnh/Thành --</option>
                        <option value="Hà Nội" selected>Hà Nội</option>
                        <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                        <option value="Đà Nẵng">Đà Nẵng</option>
                        <option value="Hải Phòng">Hải Phòng</option>
                        <option value="Cần Thơ">Cần Thơ</option>
                        <option value="Bình Dương">Bình Dương</option>
                        <option value="Đồng Nai">Đồng Nai</option>
                        <option value="Bắc Ninh">Bắc Ninh</option>
                        <option value="Quảng Ninh">Quảng Ninh</option>
                        <option value="Khánh Hòa">Khánh Hòa</option>
                    </select>
                    <div class="invalid-feedback" id="errorProvince">Vui lòng chọn Tỉnh/Thành phố nhận hàng!</div>
                </div>

                <!-- 5. Quận / Huyện -->
                <div class="col-12 col-md-4">
                    <label for="checkoutDistrict" class="form-label fw-semibold small">
                        Quận / Huyện <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="checkoutDistrict" placeholder="Ví dụ: Nam Từ Liêm" required value="Nam Từ Liêm">
                    <div class="invalid-feedback" id="errorDistrict">Vui lòng nhập Quận/Huyện!</div>
                </div>

                <!-- 6. Phường / Xã -->
                <div class="col-12 col-md-4">
                    <label for="checkoutWard" class="form-label fw-semibold small">
                        Phường / Xã <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="checkoutWard" placeholder="Ví dụ: Phương Canh" required value="Phương Canh">
                    <div class="invalid-feedback" id="errorWard">Vui lòng nhập Phường/Xã!</div>
                </div>

                <!-- 7. Địa chỉ cụ thể -->
                <div class="col-12">
                    <label class="form-label fw-semibold small d-block">Hình thức nhận hàng</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check"><input class="form-check-input" type="radio" name="fulfillmentMethod" id="fulfillmentDelivery" value="delivery" checked onchange="updateFulfillmentFields()"><label class="form-check-label" for="fulfillmentDelivery">Giao tận nơi</label></div>
                        <div class="form-check"><input class="form-check-input" type="radio" name="fulfillmentMethod" id="fulfillmentPickup" value="pickup" onchange="updateFulfillmentFields()"><label class="form-check-label" for="fulfillmentPickup">Nhận tại cửa hàng</label></div>
                    </div>
                </div>

                <!-- 7. Địa chỉ cụ thể -->
                <div class="col-12">
                    <label for="checkoutAddress" class="form-label fw-semibold small">
                        Địa chỉ nhận hàng chi tiết <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-house"></i></span>
                        <input type="text" class="form-control" id="checkoutAddress" placeholder="Số nhà, ngõ/ngách, tên đường, số tầng, tên tòa nhà..." required>
                    </div>
                    <div class="invalid-feedback" id="errorAddress">Vui lòng nhập địa chỉ cụ thể để shipper giao hàng!</div>
                </div>

                <!-- 8. Ghi chú đơn hàng -->
                <div class="col-12">
                    <label for="checkoutNote" class="form-label fw-semibold small">
                        Ghi chú giao hàng <span class="text-muted fw-normal">(Tùy chọn)</span>
                    </label>
                    <textarea class="form-control" id="checkoutNote" rows="3" placeholder="Ví dụ: Giao giờ hành chính, gọi trước 15 phút, nhờ bảo vệ nhận giúp..."></textarea>
                </div>

            </div>

            <!-- Các nút điều hướng: Quay lại giỏ hàng và Tiếp tục -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 pt-4 mt-4 border-top">
                <a href="index.php" class="btn btn-outline-secondary px-4 py-2 fw-semibold w-100 w-sm-auto order-2 order-sm-1">
                    <i class="fa-solid fa-arrow-left me-2"></i> Quay lại giỏ hàng
                </a>
                <button type="button" class="btn btn-primary px-5 py-2 fw-bold shadow-sm w-100 w-sm-auto order-1 order-sm-2" id="btnContinueCheckout" onclick="goToOrderReviewPage()">
                    Tiếp tục sang kiểm tra đơn hàng <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
            </div>

        </form>

    </div>

</div>

<!-- SCRIPT XỬ LÝ CHO TRANG 1 (THÔNG TIN NHẬN HÀNG) -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    initCheckoutShippingPage();
});

// Khởi tạo và phục hồi dữ liệu thông tin nhận hàng
function initCheckoutShippingPage() {
    const cart = typeof getCart === 'function' ? getCart() : [];
    const emptySection = document.getElementById('checkoutEmptySection');
    const shippingContainer = document.getElementById('checkoutShippingContainer');

    // 1. Kiểm tra giỏ hàng: nếu trống thì hiển thị thông báo giỏ hàng trống
    if (!cart || !cart.some(item => item.selected !== false)) {
        if (emptySection) emptySection.style.display = 'block';
        if (shippingContainer) shippingContainer.style.display = 'none';
        return;
    }

    if (emptySection) emptySection.style.display = 'none';
    if (shippingContainer) shippingContainer.style.display = 'block';

    const nameInput = document.getElementById('checkoutFullName');
    const phoneInput = document.getElementById('checkoutPhone');
    const emailInput = document.getElementById('checkoutEmail');
    const provinceSelect = document.getElementById('checkoutProvince');
    const districtInput = document.getElementById('checkoutDistrict');
    const wardInput = document.getElementById('checkoutWard');
    const addressInput = document.getElementById('checkoutAddress');
    const noteInput = document.getElementById('checkoutNote');

    // 2. Phục hồi dữ liệu tạm từ localStorage (để khi quay lại từ trang 2 không bị mất)
    let savedShipping = null;
    try {
        const raw = localStorage.getItem('techstore_checkout_shipping');
        if (raw) savedShipping = JSON.parse(raw);
    } catch (e) {
        savedShipping = null;
    }

    if (savedShipping) {
        if (nameInput && savedShipping.fullName) nameInput.value = savedShipping.fullName;
        if (phoneInput && savedShipping.phone) phoneInput.value = savedShipping.phone;
        if (emailInput && savedShipping.email) emailInput.value = savedShipping.email;
        if (provinceSelect && savedShipping.province) provinceSelect.value = savedShipping.province;
        if (districtInput && savedShipping.district) districtInput.value = savedShipping.district;
        if (wardInput && savedShipping.ward) wardInput.value = savedShipping.ward;
        if (addressInput && savedShipping.address) addressInput.value = savedShipping.address;
        if (noteInput && savedShipping.note) noteInput.value = savedShipping.note;
        const methodInput = document.querySelector(`input[name="fulfillmentMethod"][value="${savedShipping.fulfillmentMethod || 'delivery'}"]`);
        if (methodInput) methodInput.checked = true;
        updateFulfillmentFields();
        return;
    }

    updateFulfillmentFields();

    // 3. Nếu chưa có dữ liệu lưu tạm, tự động điền thông tin từ tài khoản đã đăng nhập
    const currentUser = typeof getCurrentUser === 'function' ? getCurrentUser() : null;
    if (currentUser) {
        if (nameInput && !nameInput.value) nameInput.value = currentUser.fullName || currentUser.username || '';
        if (phoneInput && !phoneInput.value) phoneInput.value = currentUser.phone || '';
        if (emailInput && !emailInput.value) emailInput.value = currentUser.email || '';
    }
}

function updateFulfillmentFields() {
    const pickup = document.getElementById('fulfillmentPickup')?.checked;
    ['checkoutProvince', 'checkoutDistrict', 'checkoutWard', 'checkoutAddress'].forEach(id => {
        const field = document.getElementById(id);
        if (field) field.required = !pickup;
    });
    const addressField = document.getElementById('checkoutAddress');
    if (addressField) addressField.closest('.col-12')?.classList.toggle('d-none', Boolean(pickup));
    ['checkoutProvince', 'checkoutDistrict', 'checkoutWard'].forEach(id => {
        const field = document.getElementById(id);
        if (field) field.closest('.col-12')?.classList.toggle('d-none', Boolean(pickup));
    });
}

// Kiểm tra dữ liệu và lưu tạm sang trang 2 (Xử lý đơn hàng)
function goToOrderReviewPage() {
    const cart = typeof getCart === 'function' ? getCart() : [];
    if (!cart || !cart.some(item => item.selected !== false)) {
        showToast('Vui lòng chọn ít nhất một sản phẩm để thanh toán.', 'warning');
        initCheckoutShippingPage();
        return;
    }

    const nameInput = document.getElementById('checkoutFullName');
    const phoneInput = document.getElementById('checkoutPhone');
    const emailInput = document.getElementById('checkoutEmail');
    const provinceSelect = document.getElementById('checkoutProvince');
    const districtInput = document.getElementById('checkoutDistrict');
    const wardInput = document.getElementById('checkoutWard');
    const addressInput = document.getElementById('checkoutAddress');
    const noteInput = document.getElementById('checkoutNote');

    if (!nameInput || !phoneInput || !provinceSelect || !districtInput || !wardInput || !addressInput) {
        return;
    }

    const fullName = nameInput.value.trim();
    const phone = phoneInput.value.trim();
    const email = emailInput ? emailInput.value.trim() : '';
    const province = provinceSelect.value.trim();
    const district = districtInput.value.trim();
    const ward = wardInput.value.trim();
    const address = addressInput.value.trim();
    const note = noteInput ? noteInput.value.trim() : '';
    const fulfillmentMethod = document.querySelector('input[name="fulfillmentMethod"]:checked')?.value || 'delivery';

    // Xóa các trạng thái lỗi cũ
    [nameInput, phoneInput, emailInput, provinceSelect, districtInput, wardInput, addressInput].forEach(el => {
        if (el) el.classList.remove('is-invalid');
    });

    let hasError = false;

    // 1. Kiểm tra Họ và tên (tối thiểu 2 ký tự)
    if (!fullName || fullName.length < 2) {
        nameInput.classList.add('is-invalid');
        nameInput.focus();
        hasError = true;
    }

    // 2. Kiểm tra Số điện thoại (10 số bắt đầu bằng số 0)
    const phoneRegex = /^0[0-9]{9}$/;
    if (!phone || !phoneRegex.test(phone)) {
        phoneInput.classList.add('is-invalid');
        if (!hasError) phoneInput.focus();
        hasError = true;
    }

    // 3. Kiểm tra Email (nếu có nhập thì phải hợp lệ)
    if (email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            emailInput.classList.add('is-invalid');
            if (!hasError) emailInput.focus();
            hasError = true;
        }
    }

    // 4. Kiểm tra Tỉnh / Thành phố
    if (fulfillmentMethod === 'delivery' && !province) {
        provinceSelect.classList.add('is-invalid');
        if (!hasError) provinceSelect.focus();
        hasError = true;
    }

    // 5. Kiểm tra Quận / Huyện
    if (fulfillmentMethod === 'delivery' && !district) {
        districtInput.classList.add('is-invalid');
        if (!hasError) districtInput.focus();
        hasError = true;
    }

    // 6. Kiểm tra Phường / Xã
    if (fulfillmentMethod === 'delivery' && !ward) {
        wardInput.classList.add('is-invalid');
        if (!hasError) wardInput.focus();
        hasError = true;
    }

    // 7. Kiểm tra Địa chỉ chi tiết
    if (fulfillmentMethod === 'delivery' && !address) {
        addressInput.classList.add('is-invalid');
        if (!hasError) addressInput.focus();
        hasError = true;
    }

    if (hasError) {
        showToast('Vui lòng kiểm tra và điền đầy đủ các thông tin bắt buộc!', 'error');
        return;
    }

    // 8. Lưu thông tin nhận hàng tạm thời vào LocalStorage
    const shippingData = {
        fullName: fullName,
        phone: phone,
        email: email,
        province: province,
        district: district,
        ward: ward,
        address: fulfillmentMethod === 'pickup' ? 'Nhận tại cửa hàng' : address,
        fullAddress: fulfillmentMethod === 'pickup' ? 'Nhận tại cửa hàng' : `${address}, ${ward}, ${district}, ${province}`,
        fulfillmentMethod,
        note: note
    };

    localStorage.setItem('techstore_checkout_shipping', JSON.stringify(shippingData));

    // 9. Chuyển sang Trang 2: Xử lý & Xác nhận đơn hàng (URL riêng biệt)
    window.location.href = 'index.php?action=checkout-confirm';
}
</script>
