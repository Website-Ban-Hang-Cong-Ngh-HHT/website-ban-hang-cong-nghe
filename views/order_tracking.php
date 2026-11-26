<?php
// ==========================================================================
// TECH STORE - TRANG THEO DÕI GIAO HÀNG DÀNH CHO KHÁCH HÀNG (views/order_tracking.php)
// ==========================================================================
// Dành cho sinh viên mới học Front-End: HTML, CSS, JavaScript cơ bản
// Lưu ý: Kiểm tra đăng nhập và các lệnh HTTP Header (header(), Cache-Control)
// đã được xử lý an toàn tại HomeController::orderTracking() trước khi xuất mã HTML,
// đảm bảo hoàn toàn không bị lỗi "Cannot modify header information - headers already sent".

if (!is_logged_in()) {
    if (!headers_sent()) {
        $target = 'index.php?action=order-tracking';
        if (!empty($_GET['id'])) {
            $target .= '&id=' . urlencode($_GET['id']);
        }
        header('Location: index.php?action=login&redirect=' . urlencode($target));
        exit;
    }
    echo '<script>window.location.href = "index.php?action=login&redirect=' . urlencode('index.php?action=order-tracking') . '";</script>';
    exit;
}
?>

<div class="tracking-page-wrapper py-4">
    <div class="container">

        <!-- ========================================================= -->
        <!-- PHẦN 1: THANH ĐIỀU HƯỚNG BREADCRUMB                      -->
        <!-- ========================================================= -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 py-2 px-3 bg-white rounded shadow-sm small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)" onclick="troVeDanhSachDonHang()" class="text-decoration-none text-muted">Đơn hàng của tôi</a></li>
                <li class="breadcrumb-item active fw-bold text-danger" aria-current="page" id="breadcrumbActiveText">Theo dõi giao hàng</li>
            </ol>
        </nav>

        <!-- ========================================================= -->
        <!-- PHẦN 2: KHUNG 1 - DANH SÁCH ĐƠN HÀNG CỦA KHÁCH HÀNG       -->
        <!-- ========================================================= -->
        <section id="khungDanhSachDonHang" class="tracking-section">
            
            <!-- Tiêu đề trang danh sách -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-truck-fast text-warning me-2"></i> Theo Dõi Giao Hàng
                    </h3>
                    <p class="text-muted small mb-0">Xem tiến trình vận chuyển, ngày giờ giao dự kiến và quản lý đơn hàng của bạn</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="index.php" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-bag-shopping me-1"></i> Mua sắm thêm
                    </a>
                </div>
            </div>

            <!-- Thanh tab bộ lọc 6 trạng thái đơn hàng -->
            <div class="tracking-filter-tabs bg-white p-2 rounded-3 shadow-sm mb-4">
                <ul class="nav nav-pills nav-fill flex-nowrap overflow-auto gap-1" id="orderFilterNav">
                    <li class="nav-item">
                        <button class="nav-link active py-2 px-3 text-nowrap" type="button" onclick="locTrangThaiDonHang('all', this)">
                            Tất cả (<span id="countTabAll">0</span>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-2 px-3 text-nowrap" type="button" onclick="locTrangThaiDonHang('pending', this)">
                            Chờ xác nhận (<span id="countTabPending">0</span>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-2 px-3 text-nowrap" type="button" onclick="locTrangThaiDonHang('processing', this)">
                            Đang chuẩn bị (<span id="countTabProcessing">0</span>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-2 px-3 text-nowrap" type="button" onclick="locTrangThaiDonHang('shipping', this)">
                            Đang giao hàng (<span id="countTabShipping">0</span>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-2 px-3 text-nowrap" type="button" onclick="locTrangThaiDonHang('completed', this)">
                            Đã giao thành công (<span id="countTabCompleted">0</span>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-2 px-3 text-nowrap" type="button" onclick="locTrangThaiDonHang('cancelled', this)">
                            Đã hủy (<span id="countTabCancelled">0</span>)
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Nơi JavaScript tự động render danh sách các thẻ đơn hàng -->
            <div id="danhSachDonHangContainer">
                <!-- Nội dung danh sách đơn hàng sẽ hiển thị tại đây -->
            </div>

            <!-- Khung hiển thị khi không có đơn hàng nào -->
            <div id="khungDonHangTrong" class="bg-white rounded-3 p-5 text-center shadow-sm" style="display: none;">
                <div class="mb-3">
                    <i class="fa-solid fa-box-open text-muted" style="font-size: 4rem;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Chưa có đơn hàng nào!</h5>
                <p class="text-muted small mb-4">Bạn chưa có đơn hàng nào thuộc trạng thái này. Hãy khám phá và đặt mua các sản phẩm công nghệ ngay nhé!</p>
                <a href="index.php" class="btn btn-primary px-4 py-2 fw-bold">
                    <i class="fa-solid fa-cart-shopping me-2"></i> Khám phá sản phẩm ngay
                </a>
            </div>

        </section>

        <!-- ========================================================= -->
        <!-- PHẦN 3: KHUNG 2 - CHI TIẾT THEO DÕI TIẾN TRÌNH GIAO HÀNG   -->
        <!-- (Ẩn mặc định, hiển thị khi bấm Theo dõi đơn hàng)        -->
        <!-- ========================================================= -->
        <section id="khungChiTietTheoDoi" class="tracking-section" style="display: none;">

            <!-- Nút quay lại danh sách -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button type="button" class="btn btn-outline-secondary btn-sm fw-bold px-3 py-2" onclick="troVeDanhSachDonHang()">
                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách đơn hàng
                </button>
                <span class="badge bg-light text-dark border px-3 py-2 small" id="detailOrderStatusBadge">
                    Đang tải...
                </span>
            </div>

            <!-- Thẻ 1: Header chi tiết đơn hàng & Thanh tiến trình 5 bước -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <span class="text-muted small">MÃ ĐƠN HÀNG:</span>
                            <span class="fs-5 fw-bold text-danger ms-1" id="detailOrderCode">#DH0000</span>
                            <span class="text-muted small ms-3">
                                <i class="fa-regular fa-clock me-1"></i> Ngày đặt: <strong id="detailOrderDateTime" class="text-dark">---</strong>
                            </span>
                        </div>
                        <div id="detailShipMethodBadge">
                            <!-- Badge vận chuyển -->
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    <!-- Banner Thông báo đặc biệt khi Giao thành công hoặc Đã hủy -->
                    <div id="detailSuccessBanner" class="alert alert-success d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="display: none;">
                        <div class="fs-1 text-success">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1 text-success">Giao hàng thành công!</h5>
                            <p class="mb-0 small text-dark">
                                Đơn hàng đã được shipper giao tận tay quý khách vào lúc <strong id="detailSuccessActualTime" class="text-success">---</strong>.
                                Cảm ơn quý khách đã tin tưởng mua sắm tại TECH STORE!
                            </p>
                        </div>
                    </div>

                    <div id="detailCancelledBanner" class="alert alert-danger d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="display: none;">
                        <div class="fs-1 text-danger">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1 text-danger">Đơn hàng đã bị hủy</h5>
                            <p class="mb-1 small text-dark">
                                Thời điểm hủy: <strong id="detailCancelledTime">---</strong>
                            </p>
                            <p class="mb-0 small text-dark">
                                Lý do hủy: <strong id="detailCancelledReason" class="text-danger">Khách hàng yêu cầu hủy đơn</strong>
                            </p>
                        </div>
                    </div>

                    <!-- Tiêu đề thanh tiến trình -->
                    <h6 class="fw-bold text-dark text-uppercase small mb-4">
                        <i class="fa-solid fa-route text-danger me-2"></i> Tiến Trình Giao Hàng (Cập nhật thời gian thực từ cửa hàng)
                    </h6>

                    <!-- THANH TIẾN TRÌNH 5 BƯỚC (STEPPER) -->
                    <div class="tracking-stepper-wrapper mb-2">
                        <div class="tracking-stepper" id="trackingStepperContainer">
                            <!-- JavaScript capNhatTienTrinh() tự động render 5 bước vào đây -->
                        </div>
                    </div>

                </div>
            </div>

            <!-- Thẻ 2: Thông tin hình thức và thời gian giao hàng (Giao thường / Hỏa tốc) -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-truck-ramp-box text-primary me-2"></i> Thông Tin Hình Thức & Thời Gian Vận Chuyển
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        
                        <!-- Cột trái: Cấu hình vận chuyển -->
                        <div class="col-12 col-md-6 border-end-md">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <h6 class="fw-bold text-dark mb-3 small text-uppercase">Hình thức vận chuyển áp dụng</h6>
                                
                                <div class="mb-3 d-flex align-items-center gap-2" id="detailShippingBoxInfo">
                                    <!-- Render chi tiết Giao thường / Hỏa tốc -->
                                </div>

                                <div class="small text-muted mb-2">
                                    <i class="fa-solid fa-calendar-day me-1 text-primary"></i> <strong>Ngày giao dự kiến:</strong> 
                                    <span id="detailEstDate" class="text-dark fw-bold">---</span>
                                </div>

                                <div class="small text-muted mb-2">
                                    <i class="fa-solid fa-clock me-1 text-primary"></i> <strong>Khung giờ giao dự kiến:</strong> 
                                    <span id="detailEstTime" class="text-danger fw-bold fs-6">---</span>
                                </div>

                                <div class="small text-muted mb-2">
                                    <i class="fa-solid fa-receipt me-1 text-primary"></i> <strong>Cước phí vận chuyển:</strong> 
                                    <span id="detailShippingFeeText" class="text-dark fw-bold">---</span>
                                </div>

                                <div class="small text-muted" id="detailActualDeliveryRow" style="display: none;">
                                    <i class="fa-solid fa-circle-check me-1 text-success"></i> <strong>Thời gian giao thực tế:</strong> 
                                    <span id="detailActualDeliveryText" class="text-success fw-bold">---</span>
                                </div>
                            </div>
                        </div>

                        <!-- Cột phải: Thông tin người nhận hàng (Chỉ xem, không sửa) -->
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <h6 class="fw-bold text-dark mb-3 small text-uppercase">
                                    <i class="fa-solid fa-location-dot text-danger me-1"></i> Địa Chỉ Nhận Hàng Của Khách
                                </h6>

                                <div class="mb-2">
                                    <strong id="detailCustomerName" class="text-dark fs-6">---</strong>
                                    <span class="text-muted ms-2 small font-monospace fw-bold" id="detailCustomerPhone">---</span>
                                </div>

                                <div class="text-muted small mb-2" id="detailCustomerAddress">
                                    ---
                                </div>

                                <div class="small text-muted fst-italic" id="detailCustomerNoteBox">
                                    <strong>Ghi chú:</strong> <span id="detailCustomerNote">Không có ghi chú</span>
                                </div>

                                <div class="alert alert-secondary py-2 px-3 small mt-3 mb-0">
                                    <i class="fa-solid fa-circle-info me-1 text-secondary"></i>
                                    Thông tin người nhận được bảo lưu cố định theo đơn đặt hàng để shipper giao đúng địa chỉ.
                                </div>
                            </div>
                        </div>

                        <!-- Lịch sử thay đổi ngày/giờ giao hàng của Admin (nếu có) -->
                        <div class="col-12" id="detailDeliveryHistoryBox" style="display: none;">
                            <div class="border rounded-3 p-3 bg-white">
                                <h6 class="fw-bold text-warning mb-2 small text-uppercase">
                                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Lịch Sử Cập Nhật Thời Gian Giao Từ Quản Trị Viên (Admin)
                                </h6>
                                <p class="text-muted small mb-2">Cửa hàng đã điều chỉnh lại thời gian giao của đơn hàng này kèm lý do cụ thể:</p>
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle small mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Thời gian cũ</th>
                                                <th>Thời gian mới</th>
                                                <th>Lý do điều chỉnh của Admin</th>
                                                <th>Thời điểm cập nhật</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailDeliveryHistoryTableBody">
                                            <!-- Render các lần Admin đổi lịch -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Thẻ 3: Danh sách sản phẩm trong đơn & Tổng tiền thanh toán -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Danh Sách Sản Phẩm Trong Đơn
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th class="ps-4">Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody id="detailProductsTableBody">
                                <!-- Render danh sách sản phẩm -->
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-top bg-light">
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-5">
                                <div class="d-flex justify-content-between small mb-2">
                                    <span class="text-muted">Tổng tiền hàng:</span>
                                    <span class="fw-bold text-dark" id="detailSubtotalText">0 ₫</span>
                                </div>
                                <div class="d-flex justify-content-between small mb-2">
                                    <span class="text-muted">Phí vận chuyển:</span>
                                    <span class="fw-bold text-dark" id="detailShippingFeeVal">0 ₫</span>
                                </div>
                                <div class="d-flex justify-content-between small mb-2" id="detailDiscountRow">
                                    <span class="text-muted">Giảm giá voucher:</span>
                                    <span class="fw-bold text-success" id="detailDiscountVal">- 0 ₫</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                    <span class="fw-bold text-dark fs-6">Tổng thanh toán:</span>
                                    <span class="fw-bold text-danger fs-4" id="detailGrandTotalText">0 ₫</span>
                                </div>
                                <div class="small text-muted text-end mt-1">
                                    Hình thức: <strong id="detailPaymentMethodText" class="text-dark">COD (Thanh toán khi nhận hàng)</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer thẻ: Nút Hủy đơn hàng hoặc thông báo -->
                <div class="card-footer bg-white py-3 px-4 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted" id="detailCancelNoticeText">
                        <!-- Thông báo quyền hủy đơn -->
                    </div>
                    <div id="detailActionButtonsBox">
                        <!-- Nút Hủy đơn hàng -->
                    </div>
                </div>
            </div>

        </section>

    </div>
</div>

<!-- ========================================================= -->
<!-- PHẦN 4: MODAL HỦY ĐƠN HÀNG (DÀNH CHO KHÁCH HÀNG)           -->
<!-- ========================================================= -->
<div class="modal fade" id="modalHuyDonHang" tabindex="-1" aria-labelledby="modalHuyDonHangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="modalHuyDonHangLabel">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Xác Nhận Hủy Đơn Hàng
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3 text-dark">
                    Bạn có chắc chắn muốn hủy đơn hàng <strong id="modalCancelOrderIdText" class="text-danger">#DH0000</strong>?
                </p>
                <div class="alert alert-warning py-2 small mb-3">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>
                    Sau khi hủy, cửa hàng sẽ ngừng chuẩn bị đơn hàng này và không thể phục hồi lại trạng thái cũ.
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Chọn lý do hủy đơn hàng <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="selectLyDoHuy" onchange="xuLyChonLyDoHuy(this.value)">
                        <option value="Tôi muốn thay đổi địa chỉ nhận hàng">Tôi muốn thay đổi địa chỉ nhận hàng</option>
                        <option value="Tôi muốn đổi màu sắc hoặc phiên bản khác">Tôi muốn đổi màu sắc hoặc phiên bản khác</option>
                        <option value="Tôi tìm thấy sản phẩm nơi khác giá tốt hơn">Tôi tìm thấy sản phẩm nơi khác giá tốt hơn</option>
                        <option value="Tôi đổi ý, không có nhu cầu mua nữa">Tôi đổi ý, không có nhu cầu mua nữa</option>
                        <option value="Thời gian giao hàng không phù hợp với tôi">Thời gian giao hàng không phù hợp với tôi</option>
                        <option value="OTHER">Lý do khác (Nhập chi tiết bên dưới)</option>
                    </select>
                </div>

                <div class="mb-3" id="khungLyDoChiTiet" style="display: none;">
                    <label class="form-label small fw-bold text-dark">Nhập chi tiết lý do của bạn <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-sm" id="inputLyDoChiTiet" rows="3" placeholder="Vui lòng nhập lý do cụ thể..."></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Không, giữ lại đơn</button>
                <button type="button" class="btn btn-danger btn-sm px-4 fw-bold" id="btnXacNhanHuyDon" onclick="xacNhanHuyDonHang()">
                    <i class="fa-solid fa-xmark me-1"></i> Đồng ý hủy đơn
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- PHẦN 5: CSS GIAO DIỆN THEO PHONG CÁCH SHOPEE / TECH STORE -->
<!-- ========================================================= -->
<style>
/* CSS Giao diện Theo Dõi Giao Hàng */
.tracking-page-wrapper {
    background-color: #f8fafc;
    min-height: 80vh;
}

/* Tabs lọc đơn hàng */
.tracking-filter-tabs .nav-pills .nav-link {
    color: #475569;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 8px;
    background-color: transparent;
    transition: all 0.2s ease;
}
.tracking-filter-tabs .nav-pills .nav-link:hover {
    background-color: #f1f5f9;
    color: #ee4d2d;
}
.tracking-filter-tabs .nav-pills .nav-link.active {
    background-color: #ee4d2d;
    color: #ffffff;
}

/* Thẻ đơn hàng danh sách */
.order-list-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 1.25rem;
    transition: box-shadow 0.2s ease, transform 0.15s ease;
}
.order-list-card:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}

/* Thanh tiến trình 5 bước (Stepper) */
.tracking-stepper-wrapper {
    padding: 1rem 0;
    overflow-x: auto;
}
.tracking-stepper {
    display: flex;
    justify-content: space-between;
    position: relative;
    min-width: 580px;
    margin: 0 auto;
}
.tracking-stepper::before {
    content: '';
    position: absolute;
    top: 24px;
    left: 40px;
    right: 40px;
    height: 4px;
    background-color: #e2e8f0;
    z-index: 1;
}
.tracking-stepper-line-active {
    position: absolute;
    top: 24px;
    left: 40px;
    height: 4px;
    background: linear-gradient(90deg, #ee4d2d 0%, #ea580c 100%);
    z-index: 2;
    transition: width 0.4s ease;
}
.step-item {
    position: relative;
    z-index: 3;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 20%;
    text-align: center;
}
.step-bubble {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: #ffffff;
    border: 3px solid #cbd5e1;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    transition: all 0.3s ease;
}
.step-title {
    font-size: 0.825rem;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.6rem;
    line-height: 1.3;
}
.step-time {
    font-size: 0.725rem;
    color: #94a3b8;
    margin-top: 0.25rem;
}

/* Trạng thái bước hoàn thành */
.step-item.completed .step-bubble {
    background-color: #ee4d2d;
    border-color: #ee4d2d;
    color: #ffffff;
    box-shadow: 0 0 0 4px rgba(238, 77, 45, 0.15);
}
.step-item.completed .step-title {
    color: #1e293b;
    font-weight: 700;
}

/* Trạng thái bước đang diễn ra (current) */
.step-item.current .step-bubble {
    background-color: #ffffff;
    border-color: #ee4d2d;
    color: #ee4d2d;
    box-shadow: 0 0 0 5px rgba(238, 77, 45, 0.25);
    animation: pulseBubble 2s infinite;
}
.step-item.current .step-title {
    color: #ee4d2d;
    font-weight: 800;
}

/* Đơn hàng đã hủy */
.step-item.cancelled .step-bubble {
    background-color: #ef4444;
    border-color: #ef4444;
    color: #ffffff;
}
.step-item.cancelled .step-title {
    color: #ef4444;
}

@keyframes pulseBubble {
    0% { transform: scale(1); }
    50% { transform: scale(1.08); }
    100% { transform: scale(1); }
}

@media (min-width: 768px) {
    .border-end-md {
        border-right: 1px solid #e2e8f0;
    }
}
</style>

<!-- ========================================================= -->
<!-- PHẦN 6: JAVASCRIPT XỬ LÝ THEO DÕI GIAO HÀNG (CƠ BẢN)     -->
<!-- Bao gồm 6 hàm bắt buộc:                                   -->
<!-- 1. hienThiDanhSachDonHang()                               -->
<!-- 2. theoDoiDonHang()                                       -->
<!-- 3. hienThiChiTietDonHang()                                -->
<!-- 4. capNhatTienTrinh()                                     -->
<!-- 5. kiemTraDieuKienHuy()                                   -->
<!-- 6. huyDonHang()                                           -->
<!-- ========================================================= -->
<script>
// Biến toàn cục lưu trạng thái hiện tại
let DANG_LOC_TRANG_THAI = 'all';
let DON_HANG_DANG_XEM = null;
let MA_DON_HANG_DANG_HUY = null;

// Lấy danh sách đơn hàng từ localStorage (khoá chuẩn techstore_orders_v2)
function layTatCaDonHangHeThong() {
    const raw = localStorage.getItem('techstore_orders_v2') || localStorage.getItem('techstore_orders');
    return raw ? JSON.parse(raw) : [];
}

// Lấy danh sách đơn hàng của riêng người dùng đang đăng nhập (Bảo vệ dữ liệu)
function layDonHangCuaToi() {
    const user = (typeof getCurrentUser === 'function') ? getCurrentUser() : null;
    if (!user || !user.id) return [];

    const allOrders = layTatCaDonHangHeThong();
    // Khách hàng chỉ xem được đơn hàng của chính mình (userId === user.id)
    return allOrders.filter(o => Number(o.userId) === Number(user.id));
}

// Lưu danh sách đơn hàng sau khi cập nhật
function luuLaiDonHangHeThong(danhSach) {
    localStorage.setItem('techstore_orders_v2', JSON.stringify(danhSach));
    localStorage.setItem('techstore_orders', JSON.stringify(danhSach));
}

// Định dạng tiền tệ VND
function dinhDangTienVN(soTien) {
    return (Number(soTien) || 0).toLocaleString('vi-VN') + ' ₫';
}

// Tạo badge hiển thị trạng thái
function taoBadgeTrangThaiDon(status, statusText) {
    switch (status) {
        case 'pending':
            return `<span class="badge bg-warning text-dark border px-2 py-1"><i class="fa-regular fa-clock me-1"></i> ${statusText || 'Chờ xác nhận'}</span>`;
        case 'confirmed':
            return `<span class="badge bg-info text-dark border px-2 py-1"><i class="fa-solid fa-user-check me-1"></i> ${statusText || 'Đã xác nhận'}</span>`;
        case 'processing':
            return `<span class="badge bg-primary text-white border px-2 py-1"><i class="fa-solid fa-box-open me-1"></i> ${statusText || 'Đang chuẩn bị hàng'}</span>`;
        case 'shipping':
            return `<span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-2 py-1 fw-bold"><i class="fa-solid fa-truck-fast me-1"></i> ${statusText || 'Đang giao hàng'}</span>`;
        case 'completed':
            return `<span class="badge bg-success text-white border px-2 py-1"><i class="fa-solid fa-circle-check me-1"></i> ${statusText || 'Đã giao thành công'}</span>`;
        case 'cancelled':
            return `<span class="badge bg-danger text-white border px-2 py-1"><i class="fa-solid fa-xmark me-1"></i> ${statusText || 'Đã hủy'}</span>`;
        default:
            return `<span class="badge bg-secondary text-white px-2 py-1">${statusText || status}</span>`;
    }
}

// Tạo badge phương thức vận chuyển
function taoBadgePhuongThucVanChuyen(shipMethod, fee) {
    if (shipMethod === 'express') {
        return `<span class="badge bg-warning text-dark border px-2 py-1 fw-bold"><i class="fa-solid fa-bolt text-danger me-1"></i> Giao hỏa tốc (${dinhDangTienVN(fee || 50000)})</span>`;
    }
    return `<span class="badge bg-info-subtle text-info-emphasis border border-info px-2 py-1 fw-semibold"><i class="fa-solid fa-truck me-1"></i> Giao thường (${dinhDangTienVN(fee || 30000)})</span>`;
}

// =============================================================
// HÀM 1: hienThiDanhSachDonHang() - BẮT BUỘC
// Hiển thị danh sách các đơn hàng của khách hàng theo bộ lọc
// =============================================================
function hienThiDanhSachDonHang(boLoc) {
    if (boLoc) DANG_LOC_TRANG_THAI = boLoc;

    const myOrders = layDonHangCuaToi();
    const container = document.getElementById('danhSachDonHangContainer');
    const emptyBox = document.getElementById('khungDonHangTrong');

    // Cập nhật số lượng đếm trên các Tabs
    const countAll = myOrders.length;
    const countPending = myOrders.filter(o => o.status === 'pending' || o.status === 'confirmed').length;
    const countProcessing = myOrders.filter(o => o.status === 'processing').length;
    const countShipping = myOrders.filter(o => o.status === 'shipping').length;
    const countCompleted = myOrders.filter(o => o.status === 'completed').length;
    const countCancelled = myOrders.filter(o => o.status === 'cancelled').length;

    if (document.getElementById('countTabAll')) document.getElementById('countTabAll').innerText = countAll;
    if (document.getElementById('countTabPending')) document.getElementById('countTabPending').innerText = countPending;
    if (document.getElementById('countTabProcessing')) document.getElementById('countTabProcessing').innerText = countProcessing;
    if (document.getElementById('countTabShipping')) document.getElementById('countTabShipping').innerText = countShipping;
    if (document.getElementById('countTabCompleted')) document.getElementById('countTabCompleted').innerText = countCompleted;
    if (document.getElementById('countTabCancelled')) document.getElementById('countTabCancelled').innerText = countCancelled;

    // Lọc danh sách theo tab đang chọn
    let filteredOrders = myOrders;
    if (DANG_LOC_TRANG_THAI === 'pending') {
        filteredOrders = myOrders.filter(o => o.status === 'pending' || o.status === 'confirmed');
    } else if (DANG_LOC_TRANG_THAI === 'processing') {
        filteredOrders = myOrders.filter(o => o.status === 'processing');
    } else if (DANG_LOC_TRANG_THAI === 'shipping') {
        filteredOrders = myOrders.filter(o => o.status === 'shipping');
    } else if (DANG_LOC_TRANG_THAI === 'completed') {
        filteredOrders = myOrders.filter(o => o.status === 'completed');
    } else if (DANG_LOC_TRANG_THAI === 'cancelled') {
        filteredOrders = myOrders.filter(o => o.status === 'cancelled');
    }

    if (!container) return;

    if (filteredOrders.length === 0) {
        container.innerHTML = '';
        if (emptyBox) emptyBox.style.display = 'block';
        return;
    }

    if (emptyBox) emptyBox.style.display = 'none';

    // Render danh sách thẻ đơn hàng
    container.innerHTML = filteredOrders.map(order => {
        const statusBadge = taoBadgeTrangThaiDon(order.status, order.statusText);
        const shipBadge = taoBadgePhuongThucVanChuyen(order.shippingMethod, order.shippingFee);
        const isExpress = (order.shippingMethod === 'express');

        // Thông tin vận chuyển hiển thị trên thẻ
        let deliveryInfoText = '';
        if (order.status === 'completed' && order.actualDeliveryTime) {
            deliveryInfoText = `<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Đã giao vào: <b>${order.actualDeliveryTime}</b></span>`;
        } else if (isExpress) {
            deliveryInfoText = `<span class="text-danger fw-bold"><i class="fa-solid fa-bolt me-1"></i> Giao hỏa tốc trước ${order.estimatedDeliveryTime || '2 tiếng'}</span>`;
        } else {
            deliveryInfoText = `<span><i class="fa-solid fa-calendar-day me-1 text-primary"></i> Dự kiến: <b>${order.estimatedDeliveryDate || 'Trong ngày'} (${order.estimatedDeliveryTime || '12:00 - 17:00'})</b></span>`;
        }

        // Render sản phẩm tiêu biểu
        const itemsList = (order.items && Array.isArray(order.items) && order.items.length > 0)
            ? order.items.map(item => `
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <img src="${item.image || 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80'}" 
                         alt="${item.name}" 
                         class="rounded border p-1" 
                         style="width: 55px; height: 55px; object-fit: contain;">
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark small">${item.name}</div>
                        <div class="text-muted small">${(item.color || item.storage) ? `Phiên bản: ${item.color || ''} - ${item.storage || ''}` : ''}</div>
                        <div class="text-muted small">Số lượng: x${item.quantity || 1}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-dark small">${dinhDangTienVN(item.price || 0)}</div>
                    </div>
                </div>
            `).join('')
            : `<div class="text-muted small py-2">${order.productSummary || 'Chi tiết đơn hàng'}</div>`;

        // Nút Hủy đơn hàng (Chỉ hiển thị khi đủ điều kiện hủy)
        const canCancel = kiemTraDieuKienHuy(order.status);
        const cancelBtnHtml = canCancel
            ? `<button type="button" class="btn btn-outline-danger btn-sm px-3 fw-semibold" onclick="moModalHuyDonHang('${order.id}')">
                   <i class="fa-solid fa-xmark me-1"></i> Hủy đơn hàng
               </button>`
            : '';

        // Thông báo lý do hủy nếu đơn đã hủy
        const cancelledReasonNotice = (order.status === 'cancelled' && order.cancelReason)
            ? `<div class="alert alert-danger py-1 px-2 small mb-2"><i class="fa-solid fa-info-circle me-1"></i> <strong>Lý do hủy:</strong> ${order.cancelReason}</div>`
            : '';

        return `
            <article class="order-list-card p-3 p-md-4 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom pb-3 mb-3">
                    <div>
                        <span class="text-muted small">MÃ ĐƠN HÀNG:</span>
                        <strong class="text-danger fs-6 ms-1">#${order.id}</strong>
                        <span class="text-muted small ms-3">
                            <i class="fa-regular fa-clock me-1"></i> Ngày đặt: ${order.orderDate || ''} ${order.orderTime || ''}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        ${shipBadge}
                        ${statusBadge}
                    </div>
                </div>

                ${cancelledReasonNotice}

                <div class="order-items-box mb-3">
                    ${itemsList}
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 gap-3">
                    <div class="small text-muted">
                        ${deliveryInfoText}
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <span class="text-muted small me-1">Tổng thanh toán:</span>
                            <span class="fs-5 fw-bold text-danger">${dinhDangTienVN(order.total || 0)}</span>
                        </div>
                        <div class="d-flex gap-2">
                            ${cancelBtnHtml}
                            <button type="button" class="btn btn-warning btn-sm px-3 fw-bold" onclick="theoDoiDonHang('${order.id}')">
                                <i class="fa-solid fa-truck-fast me-1"></i> Theo dõi đơn hàng
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        `;
    }).join('');
}

// Chuyển tab lọc trạng thái
function locTrangThaiDonHang(trangThai, buttonEl) {
    DANG_LOC_TRANG_THAI = trangThai;

    const buttons = document.querySelectorAll('#orderFilterNav .nav-link');
    buttons.forEach(btn => btn.classList.remove('active'));
    if (buttonEl) buttonEl.classList.add('active');

    hienThiDanhSachDonHang(trangThai);
}

// =============================================================
// HÀM 2: theoDoiDonHang(maDonHang) - BẮT BUỘC
// Chuyển sang màn hình theo dõi chi tiết đơn hàng
// =============================================================
function theoDoiDonHang(maDonHang) {
    const khungDanhSach = document.getElementById('khungDanhSachDonHang');
    const khungChiTiet = document.getElementById('khungChiTietTheoDoi');
    const breadcrumbActive = document.getElementById('breadcrumbActiveText');

    if (khungDanhSach) khungDanhSach.style.display = 'none';
    if (khungChiTiet) khungChiTiet.style.display = 'block';
    if (breadcrumbActive) breadcrumbActive.innerText = 'Chi tiết đơn hàng #' + maDonHang;

    // Cập nhật tham số trên URL trình duyệt mà không cần tải lại trang
    const newUrl = 'index.php?action=order-tracking&id=' + encodeURIComponent(maDonHang);
    window.history.pushState({ orderId: maDonHang }, '', newUrl);

    // Cuộn lên đầu trang
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Gọi hàm hiển thị chi tiết đơn hàng
    hienThiChiTietDonHang(maDonHang);
}

// Quay lại màn hình danh sách đơn hàng
function troVeDanhSachDonHang() {
    const khungDanhSach = document.getElementById('khungDanhSachDonHang');
    const khungChiTiet = document.getElementById('khungChiTietTheoDoi');
    const breadcrumbActive = document.getElementById('breadcrumbActiveText');

    if (khungChiTiet) khungChiTiet.style.display = 'none';
    if (khungDanhSach) khungDanhSach.style.display = 'block';
    if (breadcrumbActive) breadcrumbActive.innerText = 'Theo dõi giao hàng';

    // Cập nhật lại URL
    window.history.pushState({}, '', 'index.php?action=order-tracking');

    // Tải lại danh sách đơn hàng
    hienThiDanhSachDonHang(DANG_LOC_TRANG_THAI);
}

// =============================================================
// HÀM 3: hienThiChiTietDonHang(maDonHang) - BẮT BUỘC
// Lấy dữ liệu và hiển thị chi tiết tiến trình vận chuyển của đơn hàng
// =============================================================
function hienThiChiTietDonHang(maDonHang) {
    const myOrders = layDonHangCuaToi();
    const order = myOrders.find(o => String(o.id) === String(maDonHang));

    if (!order) {
        alert('Không tìm thấy đơn hàng #' + maDonHang + ' hoặc bạn không có quyền xem đơn hàng này!');
        troVeDanhSachDonHang();
        return;
    }

    DON_HANG_DANG_XEM = order;

    // 1. Điền thông tin mã và ngày đặt
    document.getElementById('detailOrderCode').innerText = '#' + order.id;
    document.getElementById('detailOrderDateTime').innerText = (order.orderDate || '') + ' ' + (order.orderTime || '');
    document.getElementById('detailOrderStatusBadge').innerHTML = taoBadgeTrangThaiDon(order.status, order.statusText);
    document.getElementById('detailShipMethodBadge').innerHTML = taoBadgePhuongThucVanChuyen(order.shippingMethod, order.shippingFee);

    // 2. Cập nhật Banner Giao thành công / Đã hủy
    const successBanner = document.getElementById('detailSuccessBanner');
    const cancelledBanner = document.getElementById('detailCancelledBanner');

    if (order.status === 'completed') {
        if (successBanner) {
            successBanner.style.display = 'flex';
            const actualText = order.actualDeliveryTime || `${order.estimatedDeliveryDate || 'Hôm nay'} (${order.estimatedDeliveryTime || '12:00 - 17:00'})`;
            document.getElementById('detailSuccessActualTime').innerText = actualText;
        }
        if (cancelledBanner) cancelledBanner.style.display = 'none';
    } else if (order.status === 'cancelled') {
        if (cancelledBanner) {
            cancelledBanner.style.display = 'flex';
            document.getElementById('detailCancelledTime').innerText = order.cancelledAt || (order.orderDate + ' ' + order.orderTime);
            document.getElementById('detailCancelledReason').innerText = order.cancelReason || 'Khách hàng yêu cầu hủy đơn';
        }
        if (successBanner) successBanner.style.display = 'none';
    } else {
        if (successBanner) successBanner.style.display = 'none';
        if (cancelledBanner) cancelledBanner.style.display = 'none';
    }

    // 3. CẬP NHẬT THANH TIẾN TRÌNH 5 BƯỚC
    capNhatTienTrinh(order.status, order);

    // 4. Khối hình thức và thời gian giao hàng
    const isExpress = (order.shippingMethod === 'express');
    const shipBoxInfo = document.getElementById('detailShippingBoxInfo');
    if (shipBoxInfo) {
        if (isExpress) {
            shipBoxInfo.innerHTML = `
                <div class="p-2 bg-warning-subtle text-warning-emphasis border border-warning rounded w-100">
                    <div class="fw-bold"><i class="fa-solid fa-bolt text-danger me-1"></i> Giao hỏa tốc (Giao trong 2 tiếng)</div>
                    <div class="small">Áp dụng đơn đặt trước 08:00 sáng. Giờ đặt: <b>${order.orderTime || '07:30'}</b> - Dự kiến giao trước: <b>${order.estimatedDeliveryTime || '09:30'}</b></div>
                </div>
            `;
        } else {
            shipBoxInfo.innerHTML = `
                <div class="p-2 bg-info-subtle text-info-emphasis border border-info rounded w-100">
                    <div class="fw-bold"><i class="fa-solid fa-truck me-1"></i> Giao thường (Giao trong ngày)</div>
                    <div class="small">Khung giờ giao hàng tiêu chuẩn: <b>${order.estimatedDeliveryTime || '12:00 - 17:00'}</b></div>
                </div>
            `;
        }
    }

    document.getElementById('detailEstDate').innerText = order.estimatedDeliveryDate || 'Trong ngày';
    document.getElementById('detailEstTime').innerText = order.estimatedDeliveryTime || '12:00 - 17:00';
    document.getElementById('detailShippingFeeText').innerText = dinhDangTienVN(order.shippingFee || (isExpress ? 50000 : 30000));

    // Hiển thị thời gian giao thực tế nếu đã hoàn thành
    const actualRow = document.getElementById('detailActualDeliveryRow');
    if (actualRow) {
        if (order.status === 'completed' && order.actualDeliveryTime) {
            actualRow.style.display = 'block';
            document.getElementById('detailActualDeliveryText').innerText = order.actualDeliveryTime;
        } else {
            actualRow.style.display = 'none';
        }
    }

    // 5. Khối người nhận hàng
    document.getElementById('detailCustomerName').innerText = order.customer || 'Khách hàng';
    document.getElementById('detailCustomerPhone').innerText = order.phone || 'Chưa cập nhật';
    document.getElementById('detailCustomerAddress').innerText = order.address || 'Chưa cập nhật địa chỉ';
    document.getElementById('detailCustomerNote').innerText = order.note || 'Không có ghi chú';

    // 6. Lịch sử Admin cập nhật thời gian giao hàng (nếu có)
    const historyBox = document.getElementById('detailDeliveryHistoryBox');
    const historyBody = document.getElementById('detailDeliveryHistoryTableBody');
    if (historyBox && historyBody) {
        if (order.deliveryHistory && Array.isArray(order.deliveryHistory) && order.deliveryHistory.length > 0) {
            historyBox.style.display = 'block';
            historyBody.innerHTML = order.deliveryHistory.map((h, idx) => `
                <tr>
                    <td class="fw-bold text-muted">${idx + 1}</td>
                    <td><span class="text-secondary">${h.oldDate || ''} (${h.oldTime || ''})</span></td>
                    <td><strong class="text-danger">${h.newDate || ''} (${h.newTime || ''})</strong></td>
                    <td><span class="fw-semibold text-dark">${h.reason || 'Điều chỉnh lịch giao'}</span></td>
                    <td class="text-muted">${h.changedAt || ''}</td>
                </tr>
            `).join('');
        } else {
            historyBox.style.display = 'none';
        }
    }

    // 7. Render danh sách sản phẩm trong đơn
    const productsTable = document.getElementById('detailProductsTableBody');
    if (productsTable) {
        if (order.items && Array.isArray(order.items) && order.items.length > 0) {
            productsTable.innerHTML = order.items.map(item => {
                const totalItemPrice = (item.price || 0) * (item.quantity || 1);
                return `
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="${item.image || 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80'}" 
                                     alt="${item.name}" 
                                     class="rounded border p-1" 
                                     style="width: 50px; height: 50px; object-fit: contain;">
                                <div>
                                    <div class="fw-bold text-dark small">${item.name}</div>
                                    <div class="text-muted small">${(item.color || item.storage) ? `Phân loại: ${item.color || ''} - ${item.storage || ''}` : ''}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center small fw-semibold">x${item.quantity || 1}</td>
                        <td class="text-end small">${dinhDangTienVN(item.price || 0)}</td>
                        <td class="text-end pe-4 fw-bold text-danger">${dinhDangTienVN(totalItemPrice)}</td>
                    </tr>
                `;
            }).join('');
        } else {
            productsTable.innerHTML = `<tr><td colspan="4" class="text-center py-3 text-muted">${order.productSummary || 'Không có chi tiết'}</td></tr>`;
        }
    }

    // 8. Tóm tắt tiền thanh toán
    const subtotal = (order.items && Array.isArray(order.items))
        ? order.items.reduce((sum, it) => sum + ((it.price || 0) * (it.quantity || 1)), 0)
        : (order.total - (order.shippingFee || 30000));

    document.getElementById('detailSubtotalText').innerText = dinhDangTienVN(subtotal > 0 ? subtotal : order.total);
    document.getElementById('detailShippingFeeVal').innerText = dinhDangTienVN(order.shippingFee || 30000);

    const discountRow = document.getElementById('detailDiscountRow');
    if (order.discount && order.discount > 0) {
        if (discountRow) discountRow.style.display = 'flex';
        document.getElementById('detailDiscountVal').innerText = '- ' + dinhDangTienVN(order.discount);
    } else {
        if (discountRow) discountRow.style.display = 'none';
    }

    document.getElementById('detailGrandTotalText').innerText = dinhDangTienVN(order.total || 0);
    document.getElementById('detailPaymentMethodText').innerText = order.paymentMethod || 'Thanh toán khi nhận hàng (COD)';

    // 9. Khu vực nút Hủy đơn hàng và thông báo điều kiện
    const actionBox = document.getElementById('detailActionButtonsBox');
    const noticeText = document.getElementById('detailCancelNoticeText');
    const canCancel = kiemTraDieuKienHuy(order.status);

    if (canCancel) {
        if (actionBox) {
            actionBox.innerHTML = `
                <button type="button" class="btn btn-outline-danger btn-sm px-4 fw-bold py-2" onclick="moModalHuyDonHang('${order.id}')">
                    <i class="fa-solid fa-xmark me-1"></i> Hủy đơn hàng này
                </button>
            `;
        }
        if (noticeText) {
            noticeText.innerHTML = `<span class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> Bạn có thể hủy đơn hàng khi đơn đang ở trạng thái Chờ xác nhận hoặc Đang chuẩn bị hàng.</span>`;
        }
    } else {
        if (actionBox) actionBox.innerHTML = '';
        if (noticeText) {
            if (order.status === 'shipping') {
                noticeText.innerHTML = `<span class="text-warning-emphasis fw-semibold"><i class="fa-solid fa-truck-fast me-1"></i> Đơn hàng đang trên đường giao đến bạn, không thể thực hiện hủy đơn.</span>`;
            } else if (order.status === 'completed') {
                noticeText.innerHTML = `<span class="text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i> Đơn hàng đã được giao thành công hoàn tất.</span>`;
            } else if (order.status === 'cancelled') {
                noticeText.innerHTML = `<span class="text-danger fw-semibold"><i class="fa-solid fa-ban me-1"></i> Đơn hàng đã bị hủy.</span>`;
            }
        }
    }
}

// =============================================================
// HÀM 4: capNhatTienTrinh(trangThai, donHang) - BẮT BUỘC
// Render thanh tiến trình 5 bước theo trạng thái đơn hàng
// 1. Đặt hàng thành công
// 2. Đã xác nhận đơn hàng
// 3. Đang chuẩn bị hàng
// 4. Đang giao hàng
// 5. Đã giao hàng thành công
// =============================================================
function capNhatTienTrinh(trangThai, donHang) {
    const container = document.getElementById('trackingStepperContainer');
    if (!container) return;

    // Thời gian cho các bước
    const orderTimeText = (donHang.orderDate || '') + ' ' + (donHang.orderTime || '');
    const estDeliveryText = (donHang.estimatedDeliveryDate || 'Hôm nay') + ' ' + (donHang.estimatedDeliveryTime || '');
    const actualDeliveryText = donHang.actualDeliveryTime || estDeliveryText;

    // Nếu đơn hàng bị HỦY ĐƠN: Render tiến trình trạng thái Hủy đơn
    if (trangThai === 'cancelled') {
        container.innerHTML = `
            <div class="step-item completed">
                <div class="step-bubble"><i class="fa-solid fa-clipboard-check"></i></div>
                <div class="step-title">Đặt hàng thành công</div>
                <div class="step-time">${orderTimeText}</div>
            </div>
            <div class="step-item cancelled">
                <div class="step-bubble"><i class="fa-solid fa-ban"></i></div>
                <div class="step-title">Đơn hàng đã hủy</div>
                <div class="step-time">${donHang.cancelledAt || 'Đã hủy'}</div>
            </div>
        `;
        return;
    }

    // Thứ tự 5 bước theo tiêu chuẩn
    // Cấp độ hoàn thành từ 1 đến 5:
    // pending -> 1
    // confirmed -> 2
    // processing -> 3
    // shipping -> 4
    // completed -> 5
    let currentStepLevel = 1;
    if (trangThai === 'pending') currentStepLevel = 1;
    else if (trangThai === 'confirmed') currentStepLevel = 2;
    else if (trangThai === 'processing') currentStepLevel = 3;
    else if (trangThai === 'shipping') currentStepLevel = 4;
    else if (trangThai === 'completed') currentStepLevel = 5;

    // Độ rộng thanh line màu cam
    const progressWidthPercent = ((currentStepLevel - 1) / 4) * 100;

    const steps = [
        {
            level: 1,
            title: 'Đặt hàng thành công',
            icon: 'fa-solid fa-clipboard-check',
            time: orderTimeText
        },
        {
            level: 2,
            title: 'Đã xác nhận đơn hàng',
            icon: 'fa-solid fa-circle-check',
            time: (currentStepLevel >= 2) ? 'Đã xác nhận' : 'Chờ xác nhận'
        },
        {
            level: 3,
            title: 'Đang chuẩn bị hàng',
            icon: 'fa-solid fa-box-open',
            time: (currentStepLevel >= 3) ? 'Đã đóng gói' : (currentStepLevel === 2 ? 'Đang chuẩn bị' : 'Chờ đóng gói')
        },
        {
            level: 4,
            title: 'Đang giao hàng',
            icon: 'fa-solid fa-truck-fast',
            time: (currentStepLevel >= 4) ? 'Đang vận chuyển' : 'Dự kiến: ' + estDeliveryText
        },
        {
            level: 5,
            title: 'Đã giao thành công',
            icon: 'fa-solid fa-house-circle-check',
            time: (currentStepLevel === 5) ? actualDeliveryText : 'Chờ nhận hàng'
        }
    ];

    let stepsHtml = `<div class="tracking-stepper-line-active" style="width: calc(${progressWidthPercent}% - 80px);"></div>`;

    steps.forEach(step => {
        let stepClass = '';
        if (currentStepLevel > step.level) {
            stepClass = 'completed'; // Bước đã qua
        } else if (currentStepLevel === step.level) {
            stepClass = (currentStepLevel === 5) ? 'completed' : 'current'; // Bước hiện tại
        } else {
            stepClass = 'pending'; // Bước chưa tới
        }

        stepsHtml += `
            <div class="step-item ${stepClass}">
                <div class="step-bubble">
                    <i class="${step.icon}"></i>
                </div>
                <div class="step-title">${step.title}</div>
                <div class="step-time">${step.time}</div>
            </div>
        `;
    });

    container.innerHTML = stepsHtml;
}

// =============================================================
// HÀM 5: kiemTraDieuKienHuy(trangThai) - BẮT BUỘC
// Quy định điều kiện hủy đơn hàng:
// - ĐƯỢC HỦY: Chờ xác nhận (pending), Đã xác nhận (confirmed), Đang chuẩn bị (processing)
// - KHÔNG ĐƯỢC HỦY: Đang giao hàng (shipping), Đã giao hàng (completed), Đã hủy (cancelled)
// Trả về: true (được hủy) hoặc false (không được hủy)
// =============================================================
function kiemTraDieuKienHuy(trangThai) {
    if (!trangThai) return false;
    const danhSachChoPhep = ['pending', 'confirmed', 'processing'];
    return danhSachChoPhep.includes(trangThai);
}

// Mở Modal xác nhận hủy đơn hàng
function moModalHuyDonHang(maDonHang) {
    const myOrders = layDonHangCuaToi();
    const order = myOrders.find(o => String(o.id) === String(maDonHang));

    if (!order) {
        alert('Không tìm thấy đơn hàng!');
        return;
    }

    // Kiểm tra điều kiện hủy
    if (!kiemTraDieuKienHuy(order.status)) {
        if (order.status === 'shipping') {
            alert(`Không thể hủy đơn hàng #${order.id} vì shipper đang vận chuyển giao hàng!`);
        } else if (order.status === 'completed') {
            alert(`Không thể hủy đơn hàng #${order.id} vì đơn đã được giao thành công!`);
        } else if (order.status === 'cancelled') {
            alert(`Đơn hàng #${order.id} đã bị hủy từ trước!`);
        } else {
            alert(`Không thể hủy đơn hàng #${order.id} ở trạng thái hiện tại!`);
        }
        return;
    }

    MA_DON_HANG_DANG_HUY = maDonHang;
    document.getElementById('modalCancelOrderIdText').innerText = '#' + maDonHang;
    document.getElementById('selectLyDoHuy').value = 'Tôi muốn thay đổi địa chỉ nhận hàng';
    document.getElementById('khungLyDoChiTiet').style.display = 'none';
    document.getElementById('inputLyDoChiTiet').value = '';

    const modalEl = document.getElementById('modalHuyDonHang');
    if (modalEl && window.bootstrap) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Ẩn hiện ô nhập chi tiết lý do khi chọn "Lý do khác"
function xuLyChonLyDoHuy(giaTri) {
    const khung = document.getElementById('khungLyDoChiTiet');
    if (khung) {
        khung.style.display = (giaTri === 'OTHER') ? 'block' : 'none';
    }
}

// =============================================================
// HÀM 6: huyDonHang(maDonHang) - BẮT BUỘC
// Thực hiện hủy đơn hàng và lưu lý do vào hệ thống (đồng bộ với Admin)
// =============================================================
function huyDonHang(maDonHang) {
    const allOrders = layTatCaDonHangHeThong();
    const order = allOrders.find(o => String(o.id) === String(maDonHang));

    if (!order) {
        alert('Không tìm thấy đơn hàng!');
        return;
    }

    // 1. Kiểm tra điều kiện hủy
    if (!kiemTraDieuKienHuy(order.status)) {
        alert(`Không thể hủy đơn hàng #${order.id} vì đơn đang ở trạng thái "${order.statusText || order.status}"!`);
        return;
    }

    // 2. Lấy lý do hủy từ Modal
    const selectEl = document.getElementById('selectLyDoHuy');
    const inputDetailEl = document.getElementById('inputLyDoChiTiet');

    let lyDoHuy = (selectEl && selectEl.value && selectEl.value.trim() !== '') ? selectEl.value : 'Khách hàng yêu cầu hủy đơn';
    if (lyDoHuy === 'OTHER') {
        const customReason = inputDetailEl ? inputDetailEl.value.trim() : '';
        if (!customReason) {
            alert('Vui lòng nhập chi tiết lý do hủy đơn hàng!');
            if (inputDetailEl) inputDetailEl.focus();
            return;
        }
        lyDoHuy = customReason;
    }

    // 3. Cập nhật trạng thái đơn hàng thành "cancelled" (Đã hủy)
    const now = new Date();
    const thoiDiemHuyText = now.toLocaleDateString('vi-VN') + ' ' + now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });

    order.status = 'cancelled';
    order.statusText = 'Đã hủy';
    order.cancelReason = lyDoHuy;
    order.cancelledAt = thoiDiemHuyText;

    // 4. Lưu lại vào localStorage để đồng bộ với phía Admin
    luuLaiDonHangHeThong(allOrders);

    // 5. Đóng Modal hủy
    const modalEl = document.getElementById('modalHuyDonHang');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    // 6. Thông báo thành công
    if (typeof showToast === 'function') {
        showToast(`Đã hủy thành công đơn hàng #${order.id}!`, 'info');
    } else {
        alert(`Đã hủy thành công đơn hàng #${order.id}!`);
    }

    // 7. Cập nhật lại giao diện
    const khungChiTiet = document.getElementById('khungChiTietTheoDoi');
    if (khungChiTiet && khungChiTiet.style.display !== 'none' && DON_HANG_DANG_XEM && String(DON_HANG_DANG_XEM.id) === String(maDonHang)) {
        hienThiChiTietDonHang(maDonHang);
    } else {
        hienThiDanhSachDonHang(DANG_LOC_TRANG_THAI);
    }
}

// Hàm bấm nút xác nhận trong Modal
function xacNhanHuyDonHang() {
    if (MA_DON_HANG_DANG_HUY) {
        huyDonHang(MA_DON_HANG_DANG_HUY);
    }
}

// =============================================================
// KHỞI TẠO TRANG THEO DÕI GIAO HÀNG KHI TẢI TRANG
// =============================================================
document.addEventListener('DOMContentLoaded', () => {
    // Kiểm tra đăng nhập
    if (typeof kiemTraDangNhap === 'function' && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap('Vui lòng đăng nhập để theo dõi đơn hàng!', 'index.php?action=order-tracking');
        return;
    }

    // Kiểm tra xem trên URL có tham số id đơn hàng không (ví dụ: ?action=order-tracking&id=DH1234)
    const urlParams = new URLSearchParams(window.location.search);
    const orderIdParam = urlParams.get('id');

    if (orderIdParam) {
        // Mở thẳng màn hình chi tiết theo dõi đơn hàng
        theoDoiDonHang(orderIdParam);
    } else {
        // Mở danh sách tất cả đơn hàng
        hienThiDanhSachDonHang('all');
    }

    // Lắng nghe nút Back/Forward của trình duyệt
    window.addEventListener('popstate', (event) => {
        const currentParams = new URLSearchParams(window.location.search);
        const currId = currentParams.get('id');
        if (currId) {
            theoDoiDonHang(currId);
        } else {
            troVeDanhSachDonHang();
        }
    });
});
</script>
