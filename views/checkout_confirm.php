<!-- ========================================================= -->
<!-- TRANG 2: XỬ LÝ & XÁC NHẬN ĐƠN HÀNG (views/checkout_confirm.php) -->
<!-- ========================================================= -->

<div class="container py-4 checkout-page-container">

    <!-- 1. TIÊU ĐỀ VÀ BREADCRUMB TIẾN TRÌNH THANH TOÁN (BƯỚC 3: XÁC NHẬN ĐƠN HÀNG) -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark mb-2">
            <i class="fa-solid fa-clipboard-check text-primary me-2"></i>Kiểm Tra & Xác Nhận Đơn Hàng
        </h2>
        <p class="text-muted small mb-4">Bước 3: Vui lòng kiểm tra lại thông tin nhận hàng và danh sách sản phẩm trước khi tiến hành đặt hàng</p>

        <!-- Thanh tiến trình 3 bước -->
        <div class="checkout-steps-wrapper">
            <div class="checkout-step completed">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <div class="step-label">1. Giỏ hàng</div>
            </div>
            <div class="step-line active"></div>
            <div class="checkout-step completed">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <div class="step-label">2. Thông tin nhận hàng</div>
            </div>
            <div class="step-line active" id="stepLineFinal"></div>
            <div class="checkout-step active" id="stepIndicatorComplete">
                <div class="step-circle">3</div>
                <div class="step-label">3. Xác nhận đơn hàng</div>
            </div>
        </div>
    </div>

    <!-- 2. KHỐI THÀNH CÔNG SAU KHI ĐẶT HÀNG (ẨN MẶC ĐỊNH, HIỂN THỊ KHI ĐẶT XONG) -->
    <div id="checkoutSuccessSection" class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-center my-4" style="display: none;">
        <div class="mb-3">
            <i class="fa-solid fa-circle-check text-success" style="font-size: 4.5rem;"></i>
        </div>
        <h3 class="fw-bold text-dark mb-2">ĐẶT HÀNG THÀNH CÔNG!</h3>
        <p class="text-muted mb-4" style="max-width: 600px; margin: 0 auto;">
            Cảm ơn bạn đã tin tưởng mua sắm tại <b>TECH STORE</b>. Đơn hàng của bạn đã được ghi nhận trên hệ thống và nhân viên chăm sóc khách hàng sẽ liên hệ với bạn trong vòng 15-30 phút để xác nhận.
        </p>

        <!-- Thẻ tóm tắt thông tin đơn hàng vừa tạo thành công -->
        <div class="card bg-light border-0 p-4 rounded-3 text-start mx-auto mb-4" style="max-width: 650px;">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="fa-solid fa-receipt text-primary me-2"></i> Chi Tiết Đơn Hàng Đã Tạo
            </h6>
            <div class="row g-2 small">
                <div class="col-6 text-muted">Mã đơn hàng:</div>
                <div class="col-6 fw-bold text-primary font-monospace text-end" id="successOrderId">#DH---</div>

                <div class="col-6 text-muted">Người nhận:</div>
                <div class="col-6 fw-bold text-dark text-end" id="successCustomerName">---</div>

                <div class="col-6 text-muted">Số điện thoại:</div>
                <div class="col-6 text-dark text-end" id="successPhone">---</div>

                <div class="col-6 text-muted">Địa chỉ nhận hàng:</div>
                <div class="col-6 text-dark text-end" id="successAddress">---</div>

                <div class="col-6 text-muted">Phương thức thanh toán:</div>
                <div class="col-6 text-dark text-end">
                    <span class="badge bg-success">Thanh toán khi nhận hàng (COD)</span>
                </div>

                <div class="col-6 text-muted">Phí vận chuyển:</div>
                <div class="col-6 text-success fw-bold text-end">MIỄN PHÍ (0 ₫)</div>

                <div class="col-6 text-muted">Tổng tiền thanh toán:</div>
                <div class="col-6 h5 fw-bold text-danger text-end mb-0" id="successTotalAmount">0 ₫</div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="index.php" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                <i class="fa-solid fa-store me-2"></i> Tiếp tục mua sắm
            </a>
            <button type="button" class="btn btn-outline-primary px-4 py-2 fw-semibold" id="btnViewOrderHistory" onclick="handleViewOrderHistory()">
                <i class="fa-solid fa-clock-rotate-left me-2"></i> Xem lịch sử đơn hàng
            </button>
        </div>
    </div>

    <!-- 3. KHỐI NỘI DUNG XÁC NHẬN ĐƠN HÀNG (TRANG 2) -->
    <div id="checkoutConfirmMainContainer" class="row g-4 align-items-start">

        <!-- CỘT TRÁI (7 PHẦN): THÔNG TIN NGƯỜI NHẬN & PHƯƠNG THỨC THANH TOÁN -->
        <div class="col-12 col-lg-7">
            
            <!-- THẺ 1: THÔNG TIN NGƯỜI NHẬN HÀNG (KÈM NÚT CHỈNH SỬA) -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 checkout-customer-card">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-user-check text-primary me-2"></i>Thông tin người nhận hàng
                    </h5>
                    <!-- Nút quay lại trang 1 để chỉnh sửa thông tin -->
                    <a href="index.php?action=checkout" class="btn btn-outline-primary btn-sm px-3 fw-semibold">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Chỉnh sửa
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <span class="text-muted small d-block mb-1"><i class="fa-regular fa-user me-1 text-primary"></i> Họ và tên người nhận:</span>
                        <strong class="text-dark fs-6" id="reviewFullName">---</strong>
                    </div>

                    <div class="col-12 col-sm-6">
                        <span class="text-muted small d-block mb-1"><i class="fa-solid fa-phone me-1 text-primary"></i> Số điện thoại:</span>
                        <strong class="text-dark fs-6" id="reviewPhone">---</strong>
                    </div>

                    <div class="col-12">
                        <span class="text-muted small d-block mb-1"><i class="fa-regular fa-envelope me-1 text-primary"></i> Địa chỉ Email:</span>
                        <span class="text-dark" id="reviewEmail">Chưa cung cấp</span>
                    </div>

                    <div class="col-12">
                        <span class="text-muted small d-block mb-1"><i class="fa-solid fa-location-dot me-1 text-primary"></i> Địa chỉ giao hàng đầy đủ:</span>
                        <div class="p-2 rounded bg-light border text-dark fw-medium" id="reviewFullAddress">---</div>
                    </div>

                    <div class="col-12">
                        <span class="text-muted small d-block mb-1"><i class="fa-regular fa-note-sticky me-1 text-primary"></i> Ghi chú đơn hàng:</span>
                        <span class="text-secondary fst-italic" id="reviewNote">Không có ghi chú</span>
                    </div>
                </div>
            </div>

            <!-- THẺ 2: PHƯƠNG THỨC THANH TOÁN (COD) -->
            <div class="card border-0 shadow-sm rounded-4 p-4 checkout-customer-card">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-wallet text-primary me-2"></i>Phương thức thanh toán
                    </h5>
                    <span class="badge bg-success">Khuyên dùng</span>
                </div>

                <div class="form-check p-3 border rounded-3 bg-light d-flex align-items-center">
                    <input class="form-check-input me-3 ms-0" type="radio" name="confirmPaymentMethod" id="paymentCODConfirm" value="COD" checked>
                    <label class="form-check-label flex-grow-1" for="paymentCODConfirm" style="cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-dark">
                                <i class="fa-solid fa-hand-holding-dollar text-success me-2 fs-5"></i>Thanh toán khi nhận hàng (COD)
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Miễn phí thu hộ</span>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Quý khách được đồng kiểm tra máy, phụ kiện chính hãng đầy đủ trước khi thanh toán tiền mặt cho nhân viên giao hàng.
                        </small>
                    </label>
                </div>
            </div>

        </div>

        <!-- CỘT PHẢI (5 PHẦN): TÓM TẮT SẢN PHẨM, TỔNG TIỀN VÀ NÚT XÁC NHẬN ĐẶT HÀNG -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 checkout-summary-card sticky-top" style="top: 90px; z-index: 10;">
                
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-bag-shopping text-primary me-2"></i>Chi tiết sản phẩm
                    </h5>
                    <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold" id="confirmCartCountBadge">0 sản phẩm</span>
                </div>

                <!-- Danh sách sản phẩm trong giỏ hàng -->
                <div id="confirmOrderItemsList" class="checkout-items-scroll mb-3" style="max-height: 290px; overflow-y: auto;">
                    <!-- JS sẽ render chi tiết từng sản phẩm vào đây -->
                </div>

                <!-- Bảng tổng hợp số tiền -->
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Tổng tiền hàng:</span>
                        <span class="fw-semibold text-dark" id="confirmSubtotalPrice">0 ₫</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success fw-bold">MIỄN PHÍ (0 ₫)</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-3">
                        <span>Giảm giá khuyến mãi:</span>
                        <span class="text-secondary fw-semibold" id="confirmDiscountPrice">- 0 ₫</span>
                    </div>

                    <!-- Khối Tổng thanh toán cuối cùng NỔI BẬT -->
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-danger bg-opacity-10 border border-danger-subtle mb-4">
                        <div>
                            <span class="fw-bold text-dark d-block">Tổng thanh toán:</span>
                            <small class="text-muted" style="font-size: 0.75rem;">(Đã gồm VAT & Miễn phí ship)</small>
                        </div>
                        <span class="h4 fw-bold text-danger mb-0" id="confirmFinalTotalPrice">0 ₫</span>
                    </div>

                    <!-- Các nút chức năng: Quay lại chỉnh sửa và Xác nhận đặt hàng -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary btn-lg fw-bold shadow py-3" id="btnConfirmOrder" onclick="processConfirmOrder()">
                            <i class="fa-solid fa-shield-check me-2"></i> XÁC NHẬN ĐẶT HÀNG
                        </button>
                        <a href="index.php?action=checkout" class="btn btn-outline-secondary py-2 fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại chỉnh sửa thông tin
                        </a>
                    </div>

                    <div class="text-center mt-3 text-muted small">
                        <i class="fa-solid fa-lock text-success me-1"></i> Thông tin đặt hàng của bạn được bảo mật tuyệt đối
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- SCRIPT XỬ LÝ CHO TRANG 2 (XỬ LÝ & XÁC NHẬN ĐƠN HÀNG) -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    initCheckoutConfirmPage();
});

let currentShippingData = null;

// Khởi tạo trang 2: Kiểm tra dữ liệu và hiển thị thông tin
function initCheckoutConfirmPage() {
    const cart = typeof getCart === 'function' ? getCart() : [];
    
    // 1. Kiểm tra giỏ hàng: nếu không có sản phẩm, yêu cầu mua sắm trước
    if (!cart || cart.length === 0) {
        showToast('Giỏ hàng của bạn đang trống! Vui lòng chọn sản phẩm trước.', 'warning');
        window.location.href = 'index.php';
        return;
    }

    // 2. Kiểm tra thông tin nhận hàng lưu tạm từ Trang 1
    let shippingData = null;
    try {
        const raw = localStorage.getItem('techstore_checkout_shipping');
        if (raw) shippingData = JSON.parse(raw);
    } catch (e) {
        shippingData = null;
    }

    // Nếu chưa có thông tin nhận hàng, quay lại Trang 1 để nhập
    if (!shippingData || !shippingData.fullName || !shippingData.phone || !shippingData.address) {
        showToast('Vui lòng hoàn tất thông tin nhận hàng trước khi xác nhận!', 'warning');
        window.location.href = 'index.php?action=checkout';
        return;
    }

    currentShippingData = shippingData;

    // 3. Hiển thị thông tin người nhận lên giao diện
    const fullNameEl = document.getElementById('reviewFullName');
    const phoneEl = document.getElementById('reviewPhone');
    const emailEl = document.getElementById('reviewEmail');
    const fullAddressEl = document.getElementById('reviewFullAddress');
    const noteEl = document.getElementById('reviewNote');

    if (fullNameEl) fullNameEl.innerText = shippingData.fullName;
    if (phoneEl) phoneEl.innerText = shippingData.phone;
    if (emailEl) emailEl.innerText = shippingData.email || 'Chưa cung cấp';
    if (fullAddressEl) fullAddressEl.innerText = shippingData.fullAddress || shippingData.address;
    if (noteEl) noteEl.innerText = shippingData.note ? shippingData.note : 'Không có ghi chú';

    // 4. Render danh sách sản phẩm và tổng tiền từ giỏ hàng
    renderConfirmOrderItems(cart);
}

// Render các sản phẩm trong giỏ vào cột bên phải
function renderConfirmOrderItems(cart) {
    const listContainer = document.getElementById('confirmOrderItemsList');
    const countBadge = document.getElementById('confirmCartCountBadge');
    const subtotalEl = document.getElementById('confirmSubtotalPrice');
    const finalTotalEl = document.getElementById('confirmFinalTotalPrice');

    if (!listContainer) return;

    let totalAmount = 0;
    let totalItems = 0;

    listContainer.innerHTML = cart.map(item => {
        const itemTotal = item.price * item.quantity;
        totalAmount += itemTotal;
        totalItems += item.quantity;

        let variantBadgeHTML = '';
        if (item.color || item.storage) {
            variantBadgeHTML = `
                <div class="small text-muted mb-1">
                    ${item.color ? `<span class="badge bg-light text-dark border me-1">Màu: ${item.color}</span>` : ''}
                    ${item.storage ? `<span class="badge bg-light text-dark border me-1">${item.storage}</span>` : ''}
                    ${item.sku ? `<span class="badge bg-secondary-subtle text-secondary font-monospace">${item.sku}</span>` : ''}
                </div>
            `;
        }

        return `
            <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded-3 border">
                <img src="${item.image}" 
                     alt="${item.name}" 
                     class="rounded border p-1 bg-white me-2" 
                     style="width: 50px; height: 50px; object-fit: contain;"
                     onerror="handleImageError(this, '${item.name.replace(/'/g, "\\'")}')">
                <div class="flex-grow-1 me-2 min-w-0">
                    <h6 class="mb-0 text-truncate fw-bold text-dark small" title="${item.name}">${item.name}</h6>
                    ${variantBadgeHTML}
                    <div class="small text-muted">
                        ${formatCurrency(item.price)} × <b class="text-primary">${item.quantity}</b>
                    </div>
                </div>
                <div class="text-end fw-bold text-danger small">
                    ${formatCurrency(itemTotal)}
                </div>
            </div>
        `;
    }).join('');

    if (countBadge) countBadge.innerText = `${totalItems} sản phẩm`;
    if (subtotalEl) subtotalEl.innerText = formatCurrency(totalAmount);
    if (finalTotalEl) finalTotalEl.innerText = formatCurrency(totalAmount);
}

// Xử lý khi nhấn "XÁC NHẬN ĐẶT HÀNG"
function processConfirmOrder() {
    const cart = typeof getCart === 'function' ? getCart() : [];
    if (!cart || cart.length === 0) {
        showToast('Giỏ hàng trống! Không thể đặt hàng.', 'warning');
        window.location.href = 'index.php';
        return;
    }

    if (!currentShippingData) {
        showToast('Thiếu thông tin nhận hàng! Vui lòng quay lại kiểm tra.', 'error');
        window.location.href = 'index.php?action=checkout';
        return;
    }

    const confirmBtn = document.getElementById('btnConfirmOrder');

    // 1. Chống bấm nhiều lần liên tiếp (Debounce & Disable Button)
    if (confirmBtn) {
        if (confirmBtn.disabled) return;
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Đang tạo đơn hàng...';
    }

    // 2. Kiểm tra và trừ số lượng tồn kho của từng biến thể sản phẩm trong PRODUCTS
    if (typeof PRODUCTS !== 'undefined' && Array.isArray(PRODUCTS)) {
        for (const item of cart) {
            const product = PRODUCTS.find(p => p.id === item.id);
            if (product && product.variants) {
                const variant = product.variants.find(v => v.sku === item.sku);
                if (variant && variant.stock >= item.quantity) {
                    variant.stock -= item.quantity;
                }
            }
        }
        if (typeof saveStoredProducts === 'function') {
            saveStoredProducts(PRODUCTS);
        }
    }

    // 3. Tính tổng tiền và tạo đối tượng đơn hàng mới
    const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const orderId = "DH" + Math.floor(1000 + Math.random() * 9000);
    const productSummary = cart.map(i => `${i.name} (${i.color || ''} ${i.storage || ''}) x ${i.quantity}`).join(', ');
    const currentUser = typeof getCurrentUser === 'function' ? getCurrentUser() : null;

    const newOrder = {
        id: orderId,
        userId: currentUser ? Number(currentUser.id) : null,
        customer: currentShippingData.fullName,
        phone: currentShippingData.phone,
        email: currentShippingData.email,
        address: currentShippingData.fullAddress || currentShippingData.address,
        note: currentShippingData.note || '',
        paymentMethod: "COD (Thanh toán khi nhận hàng)",
        total: totalAmount,
        shippingFee: 0,
        discount: 0,
        date: new Date().toLocaleDateString('vi-VN') + ' ' + new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
        status: "pending",
        statusText: "Chờ xác nhận",
        productSummary: productSummary,
        items: cart.map(item => ({
            id: item.id,
            sku: item.sku,
            name: item.name,
            color: item.color,
            storage: item.storage,
            price: item.price,
            quantity: item.quantity,
            subtotal: item.price * item.quantity,
            image: item.image
        }))
    };

    // 4. Lưu đơn hàng vào danh sách orders (LocalStorage đồng bộ cả techstore_orders_v2 và techstore_orders)
    const orders = typeof getStoredOrders === 'function' ? getStoredOrders() : [];
    orders.unshift(newOrder);
    if (typeof saveStoredOrders === 'function') {
        saveStoredOrders(orders);
    } else {
        localStorage.setItem('techstore_orders_v2', JSON.stringify(orders));
        localStorage.setItem('techstore_orders', JSON.stringify(orders));
    }

    // 5. Xóa giỏ hàng và dữ liệu nhận hàng tạm thời sau khi đặt hàng thành công
    if (typeof saveCart === 'function') {
        saveCart([]);
    } else {
        localStorage.setItem('techstore_cart_v2', JSON.stringify([]));
        localStorage.setItem('techstore_cart', JSON.stringify([]));
        if (typeof updateCartUI === 'function') updateCartUI();
    }
    localStorage.removeItem('techstore_checkout_shipping');

    // 6. Hiển thị thông tin lên màn hình đặt hàng thành công
    const mainContainer = document.getElementById('checkoutConfirmMainContainer');
    const successSection = document.getElementById('checkoutSuccessSection');

    document.getElementById('successOrderId').innerText = '#' + orderId;
    document.getElementById('successCustomerName').innerText = newOrder.customer;
    document.getElementById('successPhone').innerText = newOrder.phone;
    document.getElementById('successAddress').innerText = newOrder.address;
    document.getElementById('successTotalAmount').innerText = formatCurrency(totalAmount);

    if (mainContainer) mainContainer.style.display = 'none';
    if (successSection) successSection.style.display = 'block';

    showToast(`Đặt hàng thành công! Mã đơn hàng: #${orderId}`, 'success');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Xử lý khi nhấn nút "Xem lịch sử đơn hàng"
function handleViewOrderHistory() {
    const modalEl = document.getElementById('orderHistoryModal');
    if (modalEl && window.bootstrap) {
        if (typeof renderOrderHistory === 'function') renderOrderHistory();
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } else {
        window.location.href = 'index.php';
    }
}
</script>
