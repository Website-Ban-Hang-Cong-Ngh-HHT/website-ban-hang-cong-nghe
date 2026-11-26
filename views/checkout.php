<?php
// KIỂM TRA BẢO MẬT: Bắt buộc đăng nhập tài khoản mới được truy cập trang thanh toán
// Lưu ý: Kiểm tra đăng nhập và cấu hình Header đã được xử lý tại HomeController::checkout()
if (!is_logged_in()) {
    if (!headers_sent()) {
        header('Location: index.php?action=login&redirect=' . urlencode('index.php?action=checkout'));
        exit;
    }
    echo '<script>window.location.href = "index.php?action=login&redirect=' . urlencode('index.php?action=checkout') . '";</script>';
    exit;
}
?>
<!-- ================================================================= -->
<!-- TRANG THANH TOÁN GIAO DIỆN SHOPEE (views/checkout.php)             -->
<!-- CODE DÀNH CHO SINH VIÊN MỚI HỌC FRONT-END: HTML, CSS, JS CƠ BẢN    -->
<!-- ================================================================= -->

<div class="shopee-checkout-bg py-4">
    <div class="container shopee-container">

        <!-- ========================================================= -->
        <!-- PHẦN 0: KHI GIỎ HÀNG TRỐNG (ẨN MẶC ĐỊNH, HIỆN KHI CART = 0) -->
        <!-- ========================================================= -->
        <div id="khungGioHangTrong" class="shopee-card p-5 text-center" style="display: none;">
            <div class="mb-3">
                <i class="fa-solid fa-cart-shopping text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted mb-4">Không có sản phẩm nào để thanh toán. Vui lòng chọn sản phẩm vào giỏ hàng trước.</p>
            <a href="index.php" class="btn btn-shopee px-4 py-2">
                <i class="fa-solid fa-arrow-left me-2"></i> Quay lại mua sắm ngay
            </a>
        </div>

        <!-- ========================================================= -->
        <!-- PHẦN 0B: MÀN HÌNH ĐẶT HÀNG THÀNH CÔNG (HIỆN KHI ĐẶT XONG) -->
        <!-- ========================================================= -->
        <div id="khungDatHangThanhCong" class="shopee-card p-4 p-md-5 text-center" style="display: none;">
            <div class="mb-3">
                <i class="fa-solid fa-circle-check text-success" style="font-size: 4.5rem;"></i>
            </div>
            <h3 class="fw-bold text-dark mb-2">ĐẶT HÀNG THÀNH CÔNG!</h3>
            <p class="text-muted mb-4">
                Cảm ơn bạn đã mua hàng tại <b>TECH STORE</b>. Đơn hàng của bạn đã được lưu vào hệ thống và đang được chuẩn bị giao đến bạn.
            </p>

            <!-- Hộp tóm tắt đơn hàng vừa đặt -->
            <div class="card bg-light border-0 p-4 rounded-3 text-start mx-auto mb-4" style="max-width: 650px;">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                    <i class="fa-solid fa-receipt text-shopee me-2"></i> Chi Tiết Đơn Hàng Shopee
                </h6>
                <div class="row g-2 small">
                    <div class="col-6 text-muted">Mã đơn hàng:</div>
                    <div class="col-6 fw-bold text-shopee text-end" id="thanhCongMaDonHang">#DH---</div>

                    <div class="col-6 text-muted">Người nhận hàng:</div>
                    <div class="col-6 fw-bold text-dark text-end" id="thanhCongTenNguoiNhan">---</div>

                    <div class="col-6 text-muted">Số điện thoại:</div>
                    <div class="col-6 text-dark text-end" id="thanhCongSoDienThoai">---</div>

                    <div class="col-6 text-muted">Địa chỉ nhận hàng:</div>
                    <div class="col-6 text-dark text-end" id="thanhCongDiaChi">---</div>

                    <div class="col-6 text-muted">Phương thức thanh toán:</div>
                    <div class="col-6 text-dark text-end" id="thanhCongPhuongThuc">Thanh toán khi nhận hàng (COD)</div>

                    <div class="col-6 text-muted">Phương thức vận chuyển:</div>
                    <div class="col-6 text-success fw-bold text-end" id="thanhCongVanChuyen">Giao thường</div>

                    <div class="col-6 text-muted">Dự kiến giao hàng:</div>
                    <div class="col-6 text-primary fw-bold text-end" id="thanhCongThoiGianGiao">---</div>

                    <div class="col-6 text-muted">Tổng thanh toán:</div>
                    <div class="col-6 h5 fw-bold text-shopee text-end mb-0" id="thanhCongTongTien">0 ₫</div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a id="btnTheoDoiDonHangMoi" href="index.php?action=order-tracking" class="btn btn-warning px-4 py-2 fw-bold text-dark">
                    <i class="fa-solid fa-truck-fast me-2"></i> Theo dõi giao hàng ngay
                </a>
                <a href="index.php" class="btn btn-outline-secondary px-4 py-2">
                    <i class="fa-solid fa-store me-2"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- KHỐI CHÍNH THANH TOÁN (TOÀN BỘ QUY TRÌNH THANH TOÁN SHOPEE) -->
        <!-- ========================================================= -->
        <div id="khungThanhToanChinh">

            <!-- ===================================================== -->
            <!-- 1. KHỐI ĐỊA CHỈ NHẬN HÀNG (CÓ VIỀN PHONG BÌ THƯ SHOPEE) -->
            <!-- ===================================================== -->
            <div class="shopee-card overflow-hidden">
                <!-- Dải viền phong bì thư đặc trưng Shopee -->
                <div class="shopee-address-border"></div>

                <div class="p-3 p-md-4">
                    <!-- Tiêu đề có icon định vị màu cam đỏ -->
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-location-dot text-shopee fs-5 me-2"></i>
                        <span class="fs-5 fw-bold text-shopee">Địa Chỉ Nhận Hàng</span>
                    </div>

                    <!-- Nội dung địa chỉ đang được chọn -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <span class="fw-bold text-dark fs-6" id="hienThiTenVaSdt">Nguyễn Văn An (+84) 988 123 456</span>
                                <span class="badge-shopee-default" id="hienThiNhanMacDinh">Mặc định</span>
                            </div>
                            <div class="text-secondary small" id="hienThiDiaChiChiTiet">
                                Số 123 Đường Cầu Giấy, Phường Dịch Vọng, Quận Cầu Giấy, Hà Nội
                            </div>
                        </div>

                        <!-- Nút Thay đổi địa chỉ -->
                        <div>
                            <button type="button" class="btn btn-link text-decoration-none fw-semibold text-primary p-0" onclick="moModalChonDiaChi()">
                                Thay Đổi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- 2. KHỐI DANH SÁCH SẢN PHẨM THANH TOÁN (BẢNG KIỂU SHOPEE) -->
            <!-- ===================================================== -->
            <div class="shopee-card">
                <!-- Tiêu đề các cột bảng sản phẩm Shopee -->
                <div class="shopee-table-header d-none d-md-flex row align-items-center g-0">
                    <div class="col-6 fw-bold text-dark">
                        <i class="fa-solid fa-store text-shopee me-1"></i> Sản phẩm
                    </div>
                    <div class="col-2 text-center text-muted">Đơn giá</div>
                    <div class="col-2 text-center text-muted">Số lượng</div>
                    <div class="col-2 text-end text-muted">Thành tiền</div>
                </div>

                <!-- Tên Shop kiểu Shopee Mall -->
                <div class="px-3 py-2 border-bottom bg-light d-flex align-items-center gap-2">
                    <span class="badge-shopee-mall">Mall</span>
                    <strong class="text-dark small">TECH STORE Official Store</strong>
                    <span class="text-success small ms-2"><i class="fa-regular fa-comment-dots"></i> Chat ngay</span>
                </div>

                <!-- Danh sách các sản phẩm lấy từ Giỏ hàng (JavaScript chèn vào đây) -->
                <div id="danhSachSanPhamContainer">
                    <!-- JavaScript render các dòng sản phẩm vào đây -->
                </div>

                <!-- Lời nhắn cho người bán & Phương thức vận chuyển (Giao thường & Giao hỏa tốc) -->
                <div class="p-3 bg-light border-top">
                    <div class="row g-3">
                        <!-- Cột Lời nhắn cho Người bán -->
                        <div class="col-12 col-lg-4">
                            <label for="inputLoiNhan" class="small text-muted fw-semibold mb-1">Lời nhắn cho người bán:</label>
                            <textarea id="inputLoiNhan" class="form-control form-control-sm bg-white" rows="3" placeholder="Lưu ý cho Người bán (ví dụ: giao giờ hành chính, gọi trước khi giao)..."></textarea>
                        </div>

                        <!-- Cột Chọn phương thức vận chuyển (2 hình thức: Giao thường và Giao hỏa tốc) -->
                        <div class="col-12 col-lg-8 border-start-lg">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-dark fw-bold">
                                    <i class="fa-solid fa-truck-fast text-shopee me-1"></i> Phương thức vận chuyển:
                                </span>
                                <span class="fw-bold text-shopee" id="hienThiTienShip">30.000 ₫</span>
                            </div>

                            <div class="row g-2">
                                <!-- Lựa chọn 1: Giao thường -->
                                <div class="col-12 col-sm-6">
                                    <div class="shopee-shipping-card active" id="cardGiaoThuong" onclick="chonPhuongThucVanChuyen('standard')">
                                        <div class="form-check p-0 m-0 d-flex align-items-start gap-2">
                                            <input class="form-check-input mt-1" type="radio" name="radioVanChuyen" id="radioGiaoThuong" value="standard" checked>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-check-label fw-bold text-dark small" for="radioGiaoThuong" style="cursor: pointer;">
                                                        <i class="fa-solid fa-truck text-primary me-1"></i> Giao thường
                                                    </label>
                                                    <span class="text-shopee fw-bold small">30.000 ₫</span>
                                                </div>
                                                <div class="small text-muted mt-1" id="thoiGianGiaoThuongText" style="font-size: 12px;">
                                                    Đang tính toán thời gian giao...
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lựa chọn 2: Giao hỏa tốc -->
                                <div class="col-12 col-sm-6">
                                    <div class="shopee-shipping-card" id="cardGiaoHoaToc" onclick="chonPhuongThucVanChuyen('express')">
                                        <div class="form-check p-0 m-0 d-flex align-items-start gap-2">
                                            <input class="form-check-input mt-1" type="radio" name="radioVanChuyen" id="radioGiaoHoaToc" value="express">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-check-label fw-bold text-dark small" for="radioGiaoHoaToc" style="cursor: pointer;">
                                                        <i class="fa-solid fa-bolt text-warning me-1"></i> Giao hỏa tốc (2 giờ)
                                                    </label>
                                                    <span class="text-shopee fw-bold small">50.000 ₫</span>
                                                </div>
                                                <div class="small text-muted mt-1" id="thoiGianGiaoHoaTocText" style="font-size: 12px;">
                                                    Đang tính toán thời gian giao...
                                                </div>
                                                <!-- Cảnh báo khi quá 08:00 sáng -->
                                                <div class="small text-danger mt-1 fw-semibold" id="canhBaoHoaToc" style="display: none; font-size: 11px;">
                                                    <i class="fa-solid fa-circle-exclamation me-1"></i> Giao hỏa tốc chỉ áp dụng cho đơn hàng đặt trước 08:00 sáng. Vui lòng chọn giao thường.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng số tiền của đơn hàng nhỏ (Subtotal) -->
                <div class="p-3 text-end border-top bg-white">
                    <span class="text-muted small me-2">Tổng số tiền (<span id="hienThiTongSoLuong">0</span> sản phẩm):</span>
                    <span class="h5 fw-bold text-shopee mb-0" id="hienThiTongTienHangNho">0 ₫</span>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- 3. KHỐI SHOPEE VOUCHER (MÃ GIẢM GIÁ)                   -->
            <!-- ===================================================== -->
            <div class="shopee-card p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-ticket text-shopee fs-5"></i>
                        <span class="fw-bold text-dark fs-6">TECH STORE / Shopee Voucher</span>
                    </div>

                    <!-- Khu vực chọn Voucher hoặc nhập mã -->
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="selectVoucher" class="form-select form-select-sm w-auto" onchange="thayDoiVoucher()">
                            <option value="">-- Không sử dụng voucher --</option>
                            <option value="GIAM20K">GIAM20K - Giảm 20.000 ₫</option>
                            <option value="GIAM10PT">GIAM10PT - Giảm 10% (Tối đa 50.000 ₫)</option>
                            <option value="FREESHIP">FREESHIP - Miễn phí vận chuyển (Tối đa 30.000 ₫)</option>
                        </select>
                        <span class="badge bg-success-subtle text-success border border-success-subtle py-2 px-3 fw-semibold" id="hienThiNhanVoucher">
                            Chưa chọn mã
                        </span>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- 4. KHỐI PHƯƠNG THỨC THANH TOÁN (COD / CHUYỂN KHOẢN)    -->
            <!-- ===================================================== -->
            <div class="shopee-card p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center border-bottom pb-3 mb-3 gap-2">
                    <span class="fw-bold text-dark fs-6">Phương thức thanh toán</span>
                    <span class="text-muted small">Quý khách chọn 1 trong các hình thức thanh toán bên dưới:</span>
                </div>

                <!-- Các nút bấm chọn phương thức thanh toán kiểu Shopee -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <div class="shopee-payment-opt active" id="optCOD" onclick="chonPhuongThucThanhToan('COD')">
                        <i class="fa-solid fa-hand-holding-dollar text-success me-1"></i> Thanh toán khi nhận hàng (COD)
                    </div>
                    <div class="shopee-payment-opt" id="optBank" onclick="chonPhuongThucThanhToan('BANK')">
                        <i class="fa-solid fa-building-columns text-primary me-1"></i> Chuyển khoản ngân hàng (QR Code)
                    </div>
                </div>

                <!-- Thông tin chi tiết khi chọn Chuyển khoản ngân hàng -->
                <div id="khungThongTinNganHang" class="p-3 bg-light rounded-2 border" style="display: none;">
                    <div class="fw-bold text-dark mb-2"><i class="fa-solid fa-qrcode text-primary me-2"></i>Thông tin chuyển khoản ngân hàng:</div>
                    <div class="row g-2 small text-muted">
                        <div class="col-12 col-md-4">Ngân hàng: <b class="text-dark">MB Bank (Quân Đội)</b></div>
                        <div class="col-12 col-md-4">Số tài khoản: <b class="text-primary font-monospace fs-6">0988123456</b></div>
                        <div class="col-12 col-md-4">Chủ tài khoản: <b class="text-dark">TECH STORE VIETNAM</b></div>
                        <div class="col-12">Nội dung chuyển khoản: <span class="badge bg-warning text-dark font-monospace">TECHSTORE [Số điện thoại của bạn]</span></div>
                    </div>
                    <div class="text-muted small mt-2 fst-italic">
                        * Nhân viên sẽ liên hệ xác nhận ngay sau khi nhận được chuyển khoản.
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- 5. KHỐI TỔNG THANH TOÁN & NÚT ĐẶT HÀNG (SHOPEE STYLE)  -->
            <!-- ===================================================== -->
            <div class="shopee-card p-3 p-md-4">
                <div class="row justify-content-end">
                    <div class="col-12 col-md-6 col-lg-5">
                        
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Tổng tiền hàng:</span>
                            <span class="text-dark fw-semibold" id="hienThiTongTienHang">0 ₫</span>
                        </div>

                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Phí vận chuyển:</span>
                            <span class="text-dark fw-semibold" id="hienThiTongPhiShip">0 ₫</span>
                        </div>

                        <div class="d-flex justify-content-between text-muted small mb-2" id="dongGiamGiaShip" style="display: none;">
                            <span>Giảm giá phí vận chuyển:</span>
                            <span class="text-success fw-semibold" id="hienThiGiamGiaShip">- 0 ₫</span>
                        </div>

                        <div class="d-flex justify-content-between text-muted small mb-3" id="dongGiamGiaVoucher" style="display: none;">
                            <span>Tổng cộng Voucher giảm giá:</span>
                            <span class="text-success fw-semibold" id="hienThiGiamGiaVoucher">- 0 ₫</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                            <span class="fw-bold text-dark fs-6">Tổng thanh toán:</span>
                            <span class="h3 fw-bold text-shopee mb-0" id="hienThiTongThanhToan">0 ₫</span>
                        </div>

                        <div class="text-muted small mb-3 text-end" style="font-size: 12px;">
                            Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý tuân theo <a href="javascript:void(0)" class="text-decoration-none">Điều khoản Shopee / TECH STORE</a>
                        </div>

                        <!-- Nút Đặt hàng Shopee lớn màu cam đỏ -->
                        <div class="text-end">
                            <button type="button" class="btn btn-shopee w-100 py-3 fs-5 shadow-sm" id="btnDatHang" onclick="xuLyDatHang()">
                                Đặt hàng
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- Hết #khungThanhToanChinh -->

    </div>
</div>

<!-- ================================================================= -->
<!-- MODAL 1: QUẢN LÝ VÀ CHỌN ĐỊA CHỈ NHẬN HÀNG (POPUP SHOPEE)         -->
<!-- ================================================================= -->
<div id="modalChonDiaChi" class="shopee-modal-overlay" style="display: none;">
    <div class="shopee-modal-dialog">
        <div class="shopee-modal-header">
            <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-location-dot text-shopee me-2"></i>Địa chỉ của tôi</h5>
            <button type="button" class="btn-close" onclick="dongModalChonDiaChi()"></button>
        </div>

        <div class="shopee-modal-body">
            <!-- Nút thêm địa chỉ mới -->
            <div class="mb-3 text-end">
                <button type="button" class="btn btn-shopee-outline btn-sm" onclick="moFormThemDiaChi()">
                    <i class="fa-solid fa-plus me-1 text-shopee"></i> Thêm Địa Chỉ Mới
                </button>
            </div>

            <!-- Danh sách các địa chỉ (JavaScript duyệt mảng và render vào đây) -->
            <div id="danhSachDiaChiModalContainer">
                <!-- Các thẻ địa chỉ sẽ được render vào đây -->
            </div>
        </div>

        <div class="shopee-modal-footer">
            <button type="button" class="btn btn-shopee-outline" onclick="dongModalChonDiaChi()">Hủy</button>
            <button type="button" class="btn btn-shopee px-4" onclick="xacNhanChonDiaChi()">Xác nhận</button>
        </div>
    </div>
</div>

<!-- ================================================================= -->
<!-- MODAL 2: FORM THÊM MỚI VÀ CHỈNH SỬA ĐỊA CHỈ                       -->
<!-- ================================================================= -->
<div id="modalFormDiaChi" class="shopee-modal-overlay" style="display: none; z-index: 1095;">
    <div class="shopee-modal-dialog">
        <div class="shopee-modal-header">
            <h5 class="fw-bold text-dark mb-0" id="tieuDeFormDiaChi">Địa chỉ mới</h5>
            <button type="button" class="btn-close" onclick="dongFormDiaChi()"></button>
        </div>

        <div class="shopee-modal-body">
            <form id="formThongTinDiaChi" onsubmit="event.preventDefault(); luuThongTinDiaChi();">
                <!-- Ẩn id đang sửa (nếu là sửa) -->
                <input type="hidden" id="inputDiaChiId" value="">

                <div class="row g-3">
                    <!-- Họ và tên -->
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" id="inputHoTen" class="form-control form-control-sm" placeholder="Ví dụ: Nguyễn Văn An" required>
                    </div>

                    <!-- Số điện thoại -->
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" id="inputSoDienThoai" class="form-control form-control-sm" placeholder="Ví dụ: 0988123456" required>
                    </div>

                    <!-- Tỉnh / Thành phố -->
                    <div class="col-12 col-sm-4">
                        <label class="form-label small fw-semibold">Tỉnh/Thành <span class="text-danger">*</span></label>
                        <select id="selectTinhThanh" class="form-select form-select-sm" required>
                            <option value="">-- Chọn --</option>
                            <option value="Hà Nội" selected>Hà Nội</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Hải Phòng">Hải Phòng</option>
                            <option value="Cần Thơ">Cần Thơ</option>
                            <option value="Bình Dương">Bình Dương</option>
                            <option value="Đồng Nai">Đồng Nai</option>
                            <option value="Bắc Ninh">Bắc Ninh</option>
                            <option value="Quảng Ninh">Quảng Ninh</option>
                        </select>
                    </div>

                    <!-- Quận / Huyện -->
                    <div class="col-12 col-sm-4">
                        <label class="form-label small fw-semibold">Quận/Huyện <span class="text-danger">*</span></label>
                        <input type="text" id="inputQuanHuyen" class="form-control form-control-sm" placeholder="Ví dụ: Cầu Giấy" required value="Quận Cầu Giấy">
                    </div>

                    <!-- Phường / Xã -->
                    <div class="col-12 col-sm-4">
                        <label class="form-label small fw-semibold">Phường/Xã <span class="text-danger">*</span></label>
                        <input type="text" id="inputPhuongXa" class="form-control form-control-sm" placeholder="Ví dụ: Dịch Vọng" required value="Phường Dịch Vọng">
                    </div>

                    <!-- Địa chỉ cụ thể -->
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Địa chỉ cụ thể <span class="text-danger">*</span></label>
                        <input type="text" id="inputDiaChiChiTiet" class="form-control form-control-sm" placeholder="Số nhà, ngõ/ngách, tên tòa nhà..." required>
                    </div>

                    <!-- Checkbox đặt làm mặc định -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkDatMacDinh">
                            <label class="form-check-label small" for="checkDatMacDinh">
                                Thiết lập làm địa chỉ mặc định
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="shopee-modal-footer">
            <button type="button" class="btn btn-shopee-outline" onclick="dongFormDiaChi()">Trở lại</button>
            <button type="button" class="btn btn-shopee px-4" onclick="luuThongTinDiaChi()">Hoàn thành</button>
        </div>
    </div>
</div>

<!-- ================================================================= -->
<!-- TOÀN BỘ CODE JAVASCRIPT CƠ BẢN DÀNH CHO SINH VIÊN FRONT-END       -->
<!-- ================================================================= -->
<script>
// ===================================================================
// 1. CÁC BIẾN TOÀN CỤC VÀ DỮ LIỆU BAN ĐẦU
// ===================================================================

// Tên khóa lưu trong localStorage
var KHOA_LUU_DIA_CHI = "shopee_danh_sach_dia_chi";

// Danh sách địa chỉ mẫu ban đầu nếu máy khách chưa có lưu
var danhSachDiaChiMacDinh = [
    {
        id: 1,
        hoTen: "Nguyễn Văn An",
        soDienThoai: "0988123456",
        tinhThanh: "Hà Nội",
        quanHuyen: "Quận Cầu Giấy",
        phuongXa: "Phường Dịch Vọng",
        diaChiChiTiet: "Số 123 Đường Cầu Giấy",
        laMacDinh: true
    },
    {
        id: 2,
        hoTen: "Trần Thị Bình",
        soDienThoai: "0912345678",
        tinhThanh: "TP. Hồ Chí Minh",
        quanHuyen: "Quận Bình Thạnh",
        phuongXa: "Phường 22",
        diaChiChiTiet: "Tòa nhà Landmark 81, 720A Điện Biên Phủ",
        laMacDinh: false
    }
];

// Biến lưu ID của địa chỉ đang được chọn để giao hàng
var idDiaChiDangChon = null;

// Biến lưu phương thức thanh toán đang chọn: "COD" hoặc "BANK"
var phuongThucThanhToanHienTai = "COD";

// Biến lưu phương thức vận chuyển đang chọn: "standard" (Giao thường) hoặc "express" (Giao hỏa tốc)
var phuongThucVanChuyenHienTai = "standard";

// Biến lưu thông tin phí vận chuyển hiện tại (mặc định 30.000₫ cho Giao thường)
var phiVanChuyenHienTai = 30000;

// Biến lưu thông tin voucher hiện tại
var maVoucherHienTai = "";

// ===================================================================
// 2. KHI TẢI TRANG XONG THÌ CHẠY HÀM KHỞI TẠO (INIT)
// ===================================================================
document.addEventListener("DOMContentLoaded", function () {
    khoiTaoTrangThanhToan();
});

function khoiTaoTrangThanhToan() {
    // 0. BẮT BUỘC ĐĂNG NHẬP: Kiểm tra trạng thái đăng nhập
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        if (typeof chuyenDenTrangDangNhap === "function") {
            chuyenDenTrangDangNhap("Vui lòng đăng nhập để sử dụng chức năng thanh toán!", "index.php?action=checkout");
        } else {
            window.location.href = "index.php?action=login&redirect=" + encodeURIComponent("index.php?action=checkout") + "&msg=" + encodeURIComponent("Vui lòng đăng nhập để thanh toán!");
        }
        return;
    }

    // 1. Kiểm tra giỏ hàng có sản phẩm hay không
    var cart = layGioHang();
    var khungGioHangTrong = document.getElementById("khungGioHangTrong");
    var khungThanhToanChinh = document.getElementById("khungThanhToanChinh");

    if (!cart || cart.length === 0) {
        if (khungGioHangTrong) khungGioHangTrong.style.display = "block";
        if (khungThanhToanChinh) khungThanhToanChinh.style.display = "none";
        return;
    }

    if (khungGioHangTrong) khungGioHangTrong.style.display = "none";
    if (khungThanhToanChinh) khungThanhToanChinh.style.display = "block";

    // 2. Khởi tạo danh sách địa chỉ và hiển thị địa chỉ mặc định
    var danhSachDiaChi = layDanhSachDiaChi();
    
    // Tìm địa chỉ mặc định
    var diaChiMacDinh = null;
    for (var i = 0; i < danhSachDiaChi.length; i++) {
        if (danhSachDiaChi[i].laMacDinh === true) {
            diaChiMacDinh = danhSachDiaChi[i];
            break;
        }
    }
    // Nếu không có địa chỉ nào là mặc định, lấy phần tử đầu tiên
    if (!diaChiMacDinh && danhSachDiaChi.length > 0) {
        diaChiMacDinh = danhSachDiaChi[0];
    }

    if (diaChiMacDinh) {
        idDiaChiDangChon = diaChiMacDinh.id;
    }

    // Hiển thị địa chỉ lên giao diện chính
    hienThiDiaChiDangChon();

    // 3. Hiển thị danh sách sản phẩm từ giỏ hàng
    hienThiDanhSachSanPham(cart);

    // 4. Khởi tạo phương thức vận chuyển (Giao thường & Giao hỏa tốc)
    khoiTaoThongTinVanChuyen();
    chonPhuongThucVanChuyen("standard");

    // 5. Tính toán tổng tiền
    tinhTongTien();
}

// ===================================================================
// 3. QUẢN LÝ GIỎ HÀNG (LẤY TỪ LOCALSTORAGE)
// ===================================================================
function layGioHang() {
    // Gọi hàm getCart() có sẵn từ main.js hoặc đọc trực tiếp từ localStorage
    if (typeof getCart === "function") {
        return getCart();
    }
    var duLieu = localStorage.getItem("techstore_cart_v2");
    if (!duLieu) {
        duLieu = localStorage.getItem("techstore_cart");
    }
    return duLieu ? JSON.parse(duLieu) : [];
}

// Định dạng số tiền sang chuẩn Việt Nam (ví dụ: 100000 -> 100.000 ₫)
function dinhDangTien(soTien) {
    if (typeof formatCurrency === "function") {
        return formatCurrency(soTien);
    }
    return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(soTien);
}

// ===================================================================
// 4. CÁC HÀM QUẢN LÝ ĐỊA CHỈ NHẬN HÀNG (MẢNG VÀ ĐỐI TƯỢNG)
// ===================================================================

// Tên khóa lưu trong localStorage riêng cho từng người dùng (Bảo vệ dữ liệu tài khoản)
function layKhoaLuuDiaChi() {
    var user = (typeof getCurrentUser === "function") ? getCurrentUser() : null;
    return user ? ("shopee_danh_sach_dia_chi_u" + user.id) : "shopee_danh_sach_dia_chi_guest";
}

// Lấy danh sách địa chỉ từ localStorage
function layDanhSachDiaChi() {
    var key = layKhoaLuuDiaChi();
    var duLieuLuu = localStorage.getItem(key);
    if (duLieuLuu) {
        return JSON.parse(duLieuLuu);
    }
    // Lấy thông tin user hiện tại nếu có để điền sẵn tên & SĐT người nhận
    var user = (typeof getCurrentUser === "function") ? getCurrentUser() : null;
    var danhSachKhoiTao = [
        {
            id: 1,
            hoTen: user ? (user.fullName || user.username) : "Nguyễn Văn An",
            soDienThoai: user ? (user.phone || "0988123456") : "0988123456",
            tinhThanh: "Hà Nội",
            quanHuyen: "Quận Cầu Giấy",
            phuongXa: "Phường Dịch Vọng",
            diaChiChiTiet: "Số 123 Đường Cầu Giấy",
            laMacDinh: true
        }
    ];
    luuDanhSachDiaChi(danhSachKhoiTao);
    return danhSachKhoiTao;
}

// Lưu mảng danh sách địa chỉ vào localStorage
function luuDanhSachDiaChi(danhSach) {
    var key = layKhoaLuuDiaChi();
    localStorage.setItem(key, JSON.stringify(danhSach));
}

// Lấy đối tượng địa chỉ đang được chọn
function layDiaChiDangChon() {
    var danhSach = layDanhSachDiaChi();
    for (var i = 0; i < danhSach.length; i++) {
        if (danhSach[i].id == idDiaChiDangChon) {
            return danhSach[i];
        }
    }
    return danhSach.length > 0 ? danhSach[0] : null;
}

// Hiển thị thông tin địa chỉ đang chọn lên trang chính
function hienThiDiaChiDangChon() {
    var diaChi = layDiaChiDangChon();
    var tenVaSdtEl = document.getElementById("hienThiTenVaSdt");
    var nhanMacDinhEl = document.getElementById("hienThiNhanMacDinh");
    var diaChiChiTietEl = document.getElementById("hienThiDiaChiChiTiet");

    if (!diaChi) {
        if (tenVaSdtEl) tenVaSdtEl.innerText = "Chưa có địa chỉ nhận hàng";
        if (nhanMacDinhEl) nhanMacDinhEl.style.display = "none";
        if (diaChiChiTietEl) diaChiChiTietEl.innerText = "Vui lòng bấm Thay Đổi để thêm địa chỉ nhận hàng";
        return;
    }

    if (tenVaSdtEl) {
        tenVaSdtEl.innerText = diaChi.hoTen + " (" + diaChi.soDienThoai + ")";
    }

    if (nhanMacDinhEl) {
        nhanMacDinhEl.style.display = diaChi.laMacDinh ? "inline-block" : "none";
    }

    if (diaChiChiTietEl) {
        var diaChiDayDu = diaChi.diaChiChiTiet + ", " + diaChi.phuongXa + ", " + diaChi.quanHuyen + ", " + diaChi.tinhThanh;
        diaChiChiTietEl.innerText = diaChiDayDu;
    }
}

// Mở Modal Quản lý & Chọn địa chỉ
function moModalChonDiaChi() {
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để quản lý địa chỉ nhận hàng!", "index.php?action=checkout");
        return;
    }
    var modal = document.getElementById("modalChonDiaChi");
    if (modal) modal.style.display = "flex";
    hienThiDanhSachDiaChiTrongModal();
}

// Đóng Modal Quản lý địa chỉ
function dongModalChonDiaChi() {
    var modal = document.getElementById("modalChonDiaChi");
    if (modal) modal.style.display = "none";
}

// Render danh sách địa chỉ vào bên trong Modal
function hienThiDanhSachDiaChiTrongModal() {
    var danhSach = layDanhSachDiaChi();
    var container = document.getElementById("danhSachDiaChiModalContainer");
    if (!container) return;

    if (danhSach.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-4">Chưa có địa chỉ nào. Bấm nút Thêm Địa Chỉ Mới bên trên để thêm.</div>';
        return;
    }

    var html = "";
    for (var i = 0; i < danhSach.length; i++) {
        var dc = danhSach[i];
        var isChecked = (dc.id == idDiaChiDangChon) ? "checked" : "";
        var diaChiDayDu = dc.diaChiChiTiet + ", " + dc.phuongXa + ", " + dc.quanHuyen + ", " + dc.tinhThanh;

        html += '<div class="shopee-address-item">';
        // Radio chọn địa chỉ này
        html += '  <div class="pt-1">';
        html += '    <input type="radio" name="radioChonDiaChi" value="' + dc.id + '" ' + isChecked + ' onchange="chonDiaChiTam(' + dc.id + ')">';
        html += '  </div>';

        // Thông tin địa chỉ
        html += '  <div class="flex-grow-1">';
        html += '    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">';
        html += '      <strong class="text-dark">' + dc.hoTen + '</strong>';
        html += '      <span class="text-muted small">| ' + dc.soDienThoai + '</span>';
        if (dc.laMacDinh) {
            html += '  <span class="badge-shopee-default">Mặc định</span>';
        }
        html += '    </div>';
        html += '    <div class="text-secondary small mb-2">' + diaChiDayDu + '</div>';

        // Các nút thao tác: Cập nhật, Xóa, Thiết lập mặc định
        html += '    <div class="d-flex gap-3 small">';
        html += '      <a href="javascript:void(0)" class="text-primary text-decoration-none" onclick="moFormSuaDiaChi(' + dc.id + ')">Cập nhật</a>';
        html += '      <a href="javascript:void(0)" class="text-danger text-decoration-none" onclick="xoaDiaChi(' + dc.id + ')">Xóa</a>';
        if (!dc.laMacDinh) {
            html += '  <a href="javascript:void(0)" class="text-secondary text-decoration-none" onclick="thietLapMacDinh(' + dc.id + ')">Thiết lập mặc định</a>';
        }
        html += '    </div>';
        html += '  </div>';
        html += '</div>';
    }

    container.innerHTML = html;
}

// Tạm thời chọn địa chỉ khi người dùng click vào radio
var idTamDangChon = null;
function chonDiaChiTam(id) {
    idTamDangChon = id;
}

// Xác nhận địa chỉ đã chọn từ Modal
function xacNhanChonDiaChi() {
    if (idTamDangChon) {
        idDiaChiDangChon = idTamDangChon;
    }
    hienThiDiaChiDangChon();
    dongModalChonDiaChi();
}

// Thiết lập 1 địa chỉ làm mặc định
function thietLapMacDinh(id) {
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để thiết lập địa chỉ mặc định!", "index.php?action=checkout");
        return;
    }
    var danhSach = layDanhSachDiaChi();
    for (var i = 0; i < danhSach.length; i++) {
        if (danhSach[i].id == id) {
            danhSach[i].laMacDinh = true;
        } else {
            danhSach[i].laMacDinh = false;
        }
    }
    luuDanhSachDiaChi(danhSach);
    idDiaChiDangChon = id;
    hienThiDanhSachDiaChiTrongModal();
    hienThiDiaChiDangChon();
}

// Xóa một địa chỉ khỏi danh sách
function xoaDiaChi(id) {
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để xóa địa chỉ nhận hàng!", "index.php?action=checkout");
        return;
    }
    var danhSach = layDanhSachDiaChi();
    if (danhSach.length <= 1) {
        alert("Bạn cần giữ lại ít nhất 1 địa chỉ nhận hàng!");
        return;
    }

    var xacNhan = confirm("Bạn có chắc chắn muốn xóa địa chỉ này không?");
    if (!xacNhan) return;

    // Tìm vị trí của địa chỉ cần xóa trong mảng
    var viTri = -1;
    for (var i = 0; i < danhSach.length; i++) {
        if (danhSach[i].id == id) {
            viTri = i;
            break;
        }
    }

    if (viTri > -1) {
        danhSach.splice(viTri, 1);
        // Nếu địa chỉ vừa xóa là địa chỉ đang chọn, chuyển sang phần tử đầu tiên
        if (idDiaChiDangChon == id) {
            idDiaChiDangChon = danhSach[0].id;
        }
        luuDanhSachDiaChi(danhSach);
        hienThiDanhSachDiaChiTrongModal();
        hienThiDiaChiDangChon();
    }
}

// Mở Form Thêm địa chỉ mới
function moFormThemDiaChi() {
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để thêm địa chỉ nhận hàng!", "index.php?action=checkout");
        return;
    }
    var modal = document.getElementById("modalFormDiaChi");
    var tieuDe = document.getElementById("tieuDeFormDiaChi");
    if (tieuDe) tieuDe.innerText = "Địa chỉ mới";

    // Xóa trắng các ô nhập
    document.getElementById("inputDiaChiId").value = "";
    document.getElementById("inputHoTen").value = "";
    document.getElementById("inputSoDienThoai").value = "";
    document.getElementById("selectTinhThanh").value = "Hà Nội";
    document.getElementById("inputQuanHuyen").value = "";
    document.getElementById("inputPhuongXa").value = "";
    document.getElementById("inputDiaChiChiTiet").value = "";
    document.getElementById("checkDatMacDinh").checked = false;

    if (modal) modal.style.display = "flex";
}

// Mở Form Sửa địa chỉ đã có
function moFormSuaDiaChi(id) {
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để chỉnh sửa địa chỉ nhận hàng!", "index.php?action=checkout");
        return;
    }
    var danhSach = layDanhSachDiaChi();
    var diaChi = null;
    for (var i = 0; i < danhSach.length; i++) {
        if (danhSach[i].id == id) {
            diaChi = danhSach[i];
            break;
        }
    }

    if (!diaChi) return;

    var modal = document.getElementById("modalFormDiaChi");
    var tieuDe = document.getElementById("tieuDeFormDiaChi");
    if (tieuDe) tieuDe.innerText = "Cập nhật địa chỉ";

    // Điền thông tin cũ vào các ô nhập
    document.getElementById("inputDiaChiId").value = diaChi.id;
    document.getElementById("inputHoTen").value = diaChi.hoTen;
    document.getElementById("inputSoDienThoai").value = diaChi.soDienThoai;
    document.getElementById("selectTinhThanh").value = diaChi.tinhThanh;
    document.getElementById("inputQuanHuyen").value = diaChi.quanHuyen;
    document.getElementById("inputPhuongXa").value = diaChi.phuongXa;
    document.getElementById("inputDiaChiChiTiet").value = diaChi.diaChiChiTiet;
    document.getElementById("checkDatMacDinh").checked = diaChi.laMacDinh;

    if (modal) modal.style.display = "flex";
}

// Đóng Form Thêm/Sửa địa chỉ
function dongFormDiaChi() {
    var modal = document.getElementById("modalFormDiaChi");
    if (modal) modal.style.display = "none";
}

// Lưu thông tin địa chỉ từ Form (Thêm hoặc Sửa)
function luuThongTinDiaChi() {
    var id = document.getElementById("inputDiaChiId").value;
    var hoTen = document.getElementById("inputHoTen").value.trim();
    var soDienThoai = document.getElementById("inputSoDienThoai").value.trim();
    var tinhThanh = document.getElementById("selectTinhThanh").value.trim();
    var quanHuyen = document.getElementById("inputQuanHuyen").value.trim();
    var phuongXa = document.getElementById("inputPhuongXa").value.trim();
    var diaChiChiTiet = document.getElementById("inputDiaChiChiTiet").value.trim();
    var laMacDinh = document.getElementById("checkDatMacDinh").checked;

    // Kiểm tra dữ liệu hợp lệ cơ bản
    if (!hoTen || !soDienThoai || !tinhThanh || !quanHuyen || !phuongXa || !diaChiChiTiet) {
        alert("Vui lòng điền đầy đủ các thông tin địa chỉ bắt buộc!");
        return;
    }

    // Kiểm tra số điện thoại (10 chữ số bắt đầu bằng số 0)
    var phoneRegex = /^0[0-9]{9}$/;
    if (!phoneRegex.test(soDienThoai)) {
        alert("Số điện thoại không hợp lệ! Vui lòng nhập 10 chữ số bắt đầu bằng số 0.");
        return;
    }

    var danhSach = layDanhSachDiaChi();

    // Nếu người dùng chọn Đặt làm mặc định, hủy mặc định các địa chỉ cũ
    if (laMacDinh) {
        for (var i = 0; i < danhSach.length; i++) {
            danhSach[i].laMacDinh = false;
        }
    }

    if (id) {
        // Trường hợp SỬA địa chỉ đã có
        for (var i = 0; i < danhSach.length; i++) {
            if (danhSach[i].id == id) {
                danhSach[i].hoTen = hoTen;
                danhSach[i].soDienThoai = soDienThoai;
                danhSach[i].tinhThanh = tinhThanh;
                danhSach[i].quanHuyen = quanHuyen;
                danhSach[i].phuongXa = phuongXa;
                danhSach[i].diaChiChiTiet = diaChiChiTiet;
                danhSach[i].laMacDinh = laMacDinh;
                break;
            }
        }
    } else {
        // Trường hợp THÊM MỚI địa chỉ
        var idMoi = Date.now(); // tạo mã id duy nhất bằng thời gian hiện tại
        var diaChiMoi = {
            id: idMoi,
            hoTen: hoTen,
            soDienThoai: soDienThoai,
            tinhThanh: tinhThanh,
            quanHuyen: quanHuyen,
            phuongXa: phuongXa,
            diaChiChiTiet: diaChiChiTiet,
            laMacDinh: laMacDinh
        };
        danhSach.push(diaChiMoi);
        // Tự động chọn địa chỉ vừa thêm
        idDiaChiDangChon = idMoi;
    }

    // Lưu vào localStorage
    luuDanhSachDiaChi(danhSach);

    // Cập nhật lại giao diện
    hienThiDanhSachDiaChiTrongModal();
    hienThiDiaChiDangChon();
    dongFormDiaChi();
}

// ===================================================================
// 5. HIỂN THỊ DANH SÁCH SẢN PHẨM THANH TOÁN TỪ GIỎ HÀNG
// ===================================================================
function hienThiDanhSachSanPham(cart) {
    var container = document.getElementById("danhSachSanPhamContainer");
    if (!container) return;

    var html = "";
    var tongSoLuong = 0;

    for (var i = 0; i < cart.length; i++) {
        var sp = cart[i];
        var thanhTien = sp.price * sp.quantity;
        tongSoLuong += sp.quantity;

        // Phân loại hàng (Màu sắc, Dung lượng nếu có)
        var phanLoai = "";
        if (sp.color || sp.storage) {
            phanLoai = (sp.color ? sp.color : "") + (sp.storage ? " - " + sp.storage : "");
        } else {
            phanLoai = "Tiêu chuẩn";
        }

        html += '<div class="shopee-product-row row g-2 align-items-center m-0">';
        
        // Cột Sản phẩm: Ảnh, tên và phân loại
        html += '  <div class="col-12 col-md-6 d-flex align-items-center gap-3">';
        html += '    <img src="' + sp.image + '" alt="' + sp.name + '" class="shopee-product-img">';
        html += '    <div>';
        html += '      <div class="fw-bold text-dark small text-truncate" style="max-width: 320px;" title="' + sp.name + '">' + sp.name + '</div>';
        html += '      <div class="text-muted small">Phân loại: ' + phanLoai + '</div>';
        html += '    </div>';
        html += '  </div>';

        // Cột Đơn giá
        html += '  <div class="col-4 col-md-2 text-md-center small">';
        html += '    <span class="d-md-none text-muted">Đơn giá: </span>';
        html += '    <span class="text-dark">' + dinhDangTien(sp.price) + '</span>';
        html += '  </div>';

        // Cột Số lượng
        html += '  <div class="col-4 col-md-2 text-md-center small">';
        html += '    <span class="d-md-none text-muted">SL: </span>';
        html += '    <span class="text-dark">x' + sp.quantity + '</span>';
        html += '  </div>';

        // Cột Thành tiền
        html += '  <div class="col-4 col-md-2 text-end fw-bold text-shopee">';
        html += '    ' + dinhDangTien(thanhTien);
        html += '  </div>';

        html += '</div>';
    }

    container.innerHTML = html;

    var tongSoLuongEl = document.getElementById("hienThiTongSoLuong");
    if (tongSoLuongEl) tongSoLuongEl.innerText = tongSoLuong;
}

// ===================================================================
// 6. XỬ LÝ PHƯƠNG THỨC VẬN CHUYỂN (GIAO THƯỜNG & GIAO HỎA TỐC)
// ===================================================================

// Hàm định dạng ngày sang dạng dd/mm/yyyy
function dinhDangNgay(dateObj) {
    var d = dateObj.getDate();
    var m = dateObj.getMonth() + 1;
    var y = dateObj.getFullYear();
    return (d < 10 ? "0" + d : d) + "/" + (m < 10 ? "0" + m : m) + "/" + y;
}

// Hàm định dạng giờ sang dạng hh:mm
function dinhDangGio(dateObj) {
    var h = dateObj.getHours();
    var m = dateObj.getMinutes();
    return (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m);
}

// Hàm tính toán thông tin vận chuyển theo thời gian hiện tại
function tinhThongTinGiaoHang(ngayGioDat) {
    var thoiGian = ngayGioDat || new Date();
    var gio = thoiGian.getHours();

    // 1. Giao thường: Phí 30.000 ₫
    // - Đặt trước 18:00 -> Giao trong ngày hôm nay
    // - Đặt từ 18:00 trở đi -> Giao vào ngày mai
    var ngayGiaoThuong = "";
    var gioGiaoThuong = "";
    var moTaGiaoThuong = "";

    if (gio < 18) {
        ngayGiaoThuong = dinhDangNgay(thoiGian);
        gioGiaoThuong = "Trong ngày (trước 18:00)";
        moTaGiaoThuong = "Giao trong ngày (" + ngayGiaoThuong + ", trước 18:00)";
    } else {
        var ngayMai = new Date(thoiGian.getTime() + 24 * 60 * 60 * 1000);
        ngayGiaoThuong = dinhDangNgay(ngayMai);
        gioGiaoThuong = "Trước 18:00 ngày mai";
        moTaGiaoThuong = "Hết giờ giao trong ngày. Dự kiến giao: " + ngayGiaoThuong + " (trước 18:00)";
    }

    // 2. Giao hỏa tốc: Phí 50.000 ₫
    // - Chỉ áp dụng nếu đặt TRƯỚC 08:00 sáng
    // - Giao trong vòng 2 tiếng kể từ khi đặt
    var duocGiaoHoaToc = (gio < 8);
    var ngayGiaoHoaToc = "";
    var gioGiaoHoaToc = "";
    var moTaGiaoHoaToc = "";

    if (duocGiaoHoaToc) {
        ngayGiaoHoaToc = dinhDangNgay(thoiGian);
        var thoiGianSau2h = new Date(thoiGian.getTime() + 2 * 60 * 60 * 1000);
        gioGiaoHoaToc = "Trước " + dinhDangGio(thoiGianSau2h);
        moTaGiaoHoaToc = "Giao trong vòng 2 tiếng (Dự kiến trước " + dinhDangGio(thoiGianSau2h) + " hôm nay)";
    } else {
        moTaGiaoHoaToc = "Giao hỏa tốc chỉ áp dụng cho đơn đặt trước 08:00 sáng. Vui lòng chọn giao thường.";
    }

    return {
        duocGiaoHoaToc: duocGiaoHoaToc,
        ngayGiaoThuong: ngayGiaoThuong,
        gioGiaoThuong: gioGiaoThuong,
        moTaGiaoThuong: moTaGiaoThuong,
        ngayGiaoHoaToc: ngayGiaoHoaToc,
        gioGiaoHoaToc: gioGiaoHoaToc,
        moTaGiaoHoaToc: moTaGiaoHoaToc
    };
}

// Khởi tạo hiển thị thông tin vận chuyển khi tải trang
function khoiTaoThongTinVanChuyen() {
    var info = tinhThongTinGiaoHang(new Date());

    var textGiaoThuongEl = document.getElementById("thoiGianGiaoThuongText");
    var textGiaoHoaTocEl = document.getElementById("thoiGianGiaoHoaTocText");
    var canhBaoHoaTocEl = document.getElementById("canhBaoHoaToc");
    var radioGiaoHoaTocEl = document.getElementById("radioGiaoHoaToc");
    var cardGiaoHoaTocEl = document.getElementById("cardGiaoHoaToc");

    if (textGiaoThuongEl) {
        textGiaoThuongEl.innerText = info.moTaGiaoThuong;
    }

    if (info.duocGiaoHoaToc) {
        if (textGiaoHoaTocEl) {
            textGiaoHoaTocEl.innerText = info.moTaGiaoHoaToc;
            textGiaoHoaTocEl.className = "small text-success mt-1 fw-semibold";
        }
        if (canhBaoHoaTocEl) canhBaoHoaTocEl.style.display = "none";
        if (radioGiaoHoaTocEl) radioGiaoHoaTocEl.disabled = false;
        if (cardGiaoHoaTocEl) cardGiaoHoaTocEl.classList.remove("disabled");
    } else {
        // Sau 08:00 sáng: Vô hiệu hóa tùy chọn hỏa tốc
        if (textGiaoHoaTocEl) {
            textGiaoHoaTocEl.innerText = "Không phục vụ hỏa tốc sau 08:00 sáng";
            textGiaoHoaTocEl.className = "small text-muted mt-1";
        }
        if (canhBaoHoaTocEl) canhBaoHoaTocEl.style.display = "block";
        if (radioGiaoHoaTocEl) radioGiaoHoaTocEl.disabled = true;
        if (cardGiaoHoaTocEl) cardGiaoHoaTocEl.classList.add("disabled");

        if (phuongThucVanChuyenHienTai === "express") {
            chonPhuongThucVanChuyen("standard");
        }
    }
}

// Hàm chọn phương thức vận chuyển (standard hoặc express)
function chonPhuongThucVanChuyen(loai) {
    var info = tinhThongTinGiaoHang(new Date());

    // Nếu chọn hỏa tốc mà đã quá 08:00 sáng
    if (loai === "express" && !info.duocGiaoHoaToc) {
        alert("Giao hỏa tốc chỉ áp dụng cho đơn hàng đặt trước 08:00 sáng! Quý khách vui lòng chọn phương thức Giao thường.");
        loai = "standard";
    }

    phuongThucVanChuyenHienTai = loai;
    phiVanChuyenHienTai = (loai === "express") ? 50000 : 30000;

    var radioGiaoThuong = document.getElementById("radioGiaoThuong");
    var radioGiaoHoaToc = document.getElementById("radioGiaoHoaToc");
    var cardGiaoThuong = document.getElementById("cardGiaoThuong");
    var cardGiaoHoaToc = document.getElementById("cardGiaoHoaToc");

    if (loai === "express") {
        if (radioGiaoHoaToc) radioGiaoHoaToc.checked = true;
        if (radioGiaoThuong) radioGiaoThuong.checked = false;
        if (cardGiaoHoaToc) cardGiaoHoaToc.classList.add("active");
        if (cardGiaoThuong) cardGiaoThuong.classList.remove("active");
    } else {
        if (radioGiaoThuong) radioGiaoThuong.checked = true;
        if (radioGiaoHoaToc) radioGiaoHoaToc.checked = false;
        if (cardGiaoThuong) cardGiaoThuong.classList.add("active");
        if (cardGiaoHoaToc) cardGiaoHoaToc.classList.remove("active");
    }

    var hienThiTienShipEl = document.getElementById("hienThiTienShip");
    if (hienThiTienShipEl) {
        hienThiTienShipEl.innerText = dinhDangTien(phiVanChuyenHienTai);
    }

    tinhTongTien();
}

// ===================================================================
// 7. XỬ LÝ VOUCHER (MÃ GIẢM GIÁ)
// ===================================================================
function thayDoiVoucher() {
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để sử dụng voucher giảm giá!", "index.php?action=checkout");
        return;
    }
    var selectEl = document.getElementById("selectVoucher");
    maVoucherHienTai = selectEl ? selectEl.value : "";
    var nhanEl = document.getElementById("hienThiNhanVoucher");

    if (maVoucherHienTai === "GIAM20K") {
        if (nhanEl) nhanEl.innerText = "Đã áp dụng mã Giảm 20.000₫";
    } else if (maVoucherHienTai === "GIAM10PT") {
        if (nhanEl) nhanEl.innerText = "Đã áp dụng mã Giảm 10%";
    } else if (maVoucherHienTai === "FREESHIP") {
        if (nhanEl) nhanEl.innerText = "Đã áp dụng Freeship";
    } else {
        if (nhanEl) nhanEl.innerText = "Chưa chọn mã";
    }

    tinhTongTien();
}

// ===================================================================
// 8. XỬ LÝ CHỌN PHƯƠNG THỨC THANH TOÁN (COD HOẶC CHUYỂN KHOẢN)
// ===================================================================
function chonPhuongThucThanhToan(loai) {
    phuongThucThanhToanHienTai = loai;

    var optCOD = document.getElementById("optCOD");
    var optBank = document.getElementById("optBank");
    var khungNganHang = document.getElementById("khungThongTinNganHang");

    if (loai === "BANK") {
        if (optCOD) optCOD.classList.remove("active");
        if (optBank) optBank.classList.add("active");
        if (khungNganHang) khungNganHang.style.display = "block";
    } else {
        if (optCOD) optCOD.classList.add("active");
        if (optBank) optBank.classList.remove("active");
        if (khungNganHang) khungNganHang.style.display = "none";
    }
}

// ===================================================================
// 9. TÍNH TOÁN VÀ HIỂN THỊ TỔNG TIỀN THANH TOÁN
// ===================================================================
function tinhTongTien() {
    var cart = layGioHang();
    
    // 1. Tính tổng tiền hàng
    var tongTienHang = 0;
    for (var i = 0; i < cart.length; i++) {
        tongTienHang += (cart[i].price * cart[i].quantity);
    }

    // 2. Tính giảm giá theo Voucher
    var giamGiaShip = 0;
    var giamGiaVoucher = 0;

    if (maVoucherHienTai === "FREESHIP") {
        // Giảm tối đa tiền ship hiện tại
        giamGiaShip = phiVanChuyenHienTai > 30000 ? 30000 : phiVanChuyenHienTai;
    } else if (maVoucherHienTai === "GIAM20K") {
        giamGiaVoucher = 20000;
    } else if (maVoucherHienTai === "GIAM10PT") {
        giamGiaVoucher = Math.round(tongTienHang * 0.1);
        // Tối đa giảm 50.000₫
        if (giamGiaVoucher > 50000) giamGiaVoucher = 50000;
    }

    // 3. Tính tổng thanh toán cuối cùng
    var tongThanhToan = tongTienHang + phiVanChuyenHienTai - giamGiaShip - giamGiaVoucher;
    if (tongThanhToan < 0) tongThanhToan = 0;

    // 4. Hiển thị lên giao diện
    var tongTienHangNhoEl = document.getElementById("hienThiTongTienHangNho");
    var tongTienHangEl = document.getElementById("hienThiTongTienHang");
    var tongPhiShipEl = document.getElementById("hienThiTongPhiShip");
    var dongGiamGiaShipEl = document.getElementById("dongGiamGiaShip");
    var hienThiGiamGiaShipEl = document.getElementById("hienThiGiamGiaShip");
    var dongGiamGiaVoucherEl = document.getElementById("dongGiamGiaVoucher");
    var hienThiGiamGiaVoucherEl = document.getElementById("hienThiGiamGiaVoucher");
    var tongThanhToanEl = document.getElementById("hienThiTongThanhToan");

    if (tongTienHangNhoEl) tongTienHangNhoEl.innerText = dinhDangTien(tongTienHang);
    if (tongTienHangEl) tongTienHangEl.innerText = dinhDangTien(tongTienHang);
    if (tongPhiShipEl) tongPhiShipEl.innerText = dinhDangTien(phiVanChuyenHienTai);

    // Hiển thị dòng giảm ship nếu có
    if (giamGiaShip > 0) {
        if (dongGiamGiaShipEl) dongGiamGiaShipEl.style.display = "flex";
        if (hienThiGiamGiaShipEl) hienThiGiamGiaShipEl.innerText = "- " + dinhDangTien(giamGiaShip);
    } else {
        if (dongGiamGiaShipEl) dongGiamGiaShipEl.style.display = "none";
    }

    // Hiển thị dòng voucher giảm giá nếu có
    if (giamGiaVoucher > 0) {
        if (dongGiamGiaVoucherEl) dongGiamGiaVoucherEl.style.display = "flex";
        if (hienThiGiamGiaVoucherEl) hienThiGiamGiaVoucherEl.innerText = "- " + dinhDangTien(giamGiaVoucher);
    } else {
        if (dongGiamGiaVoucherEl) dongGiamGiaVoucherEl.style.display = "none";
    }

    // Hiển thị tổng thanh toán
    if (tongThanhToanEl) tongThanhToanEl.innerText = dinhDangTien(tongThanhToan);

    return {
        tongTienHang: tongTienHang,
        phiVanChuyen: phiVanChuyenHienTai,
        giamGiaShip: giamGiaShip,
        giamGiaVoucher: giamGiaVoucher,
        tongThanhToan: tongThanhToan
    };
}

// ===================================================================
// 10. XỬ LÝ KHI NGƯỜI DÙNG BẤM "ĐẶT HÀNG"
// ===================================================================
function xuLyDatHang() {
    // 0. Bắt buộc đăng nhập trước khi đặt hàng
    if (typeof kiemTraDangNhap === "function" && !kiemTraDangNhap()) {
        chuyenDenTrangDangNhap("Vui lòng đăng nhập để đặt hàng!", "index.php?action=checkout");
        return;
    }

    var cart = layGioHang();
    if (!cart || cart.length === 0) {
        alert("Giỏ hàng của bạn đang trống! Vui lòng chọn sản phẩm vào giỏ trước.");
        return;
    }

    var diaChi = layDiaChiDangChon();
    if (!diaChi) {
        alert("Vui lòng chọn hoặc thêm địa chỉ nhận hàng trước khi đặt hàng!");
        moModalChonDiaChi();
        return;
    }

    var btnDatHang = document.getElementById("btnDatHang");
    if (btnDatHang) {
        if (btnDatHang.disabled) return;
        btnDatHang.disabled = true;
        btnDatHang.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Đang xử lý đặt hàng...';
    }

    // 1. Trừ số lượng tồn kho của từng phiên bản trong PRODUCTS
    if (typeof PRODUCTS !== "undefined" && Array.isArray(PRODUCTS)) {
        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            for (var p = 0; p < PRODUCTS.length; p++) {
                if (PRODUCTS[p].id === item.id && PRODUCTS[p].variants) {
                    for (var v = 0; v < PRODUCTS[p].variants.length; v++) {
                        if (PRODUCTS[p].variants[v].sku === item.sku) {
                            if (PRODUCTS[p].variants[v].stock >= item.quantity) {
                                PRODUCTS[p].variants[v].stock -= item.quantity;
                            }
                        }
                    }
                }
            }
        }
        if (typeof saveStoredProducts === "function") {
            saveStoredProducts(PRODUCTS);
        }
    }

    // 2. Tính tiền và tạo mã đơn hàng
    var ketQuaTien = tinhTongTien();

    // Kiểm tra điều kiện vận chuyển hỏa tốc tại thời điểm nhấn nút Đặt hàng
    var infoVanChuyen = tinhThongTinGiaoHang(new Date());
    if (phuongThucVanChuyenHienTai === "express" && !infoVanChuyen.duocGiaoHoaToc) {
        alert("Đã qua 08:00 sáng, đơn hàng không thể chọn Giao hỏa tốc. Hệ thống đã tự động chuyển sang Giao thường.");
        chonPhuongThucVanChuyen("standard");
        if (btnDatHang) {
            btnDatHang.disabled = false;
            btnDatHang.innerHTML = 'Đặt hàng';
        }
        return;
    }

    // Thời gian đặt hàng cố định (không tự động thay đổi sau khi đặt)
    var now = new Date();
    var orderDate = dinhDangNgay(now); // Ví dụ: "26/11/2026"
    var orderTime = dinhDangGio(now);  // Ví dụ: "07:30"
    var estimatedDeliveryDate = (phuongThucVanChuyenHienTai === "express") ? infoVanChuyen.ngayGiaoHoaToc : infoVanChuyen.ngayGiaoThuong;
    var estimatedDeliveryTime = (phuongThucVanChuyenHienTai === "express") ? infoVanChuyen.gioGiaoHoaToc : infoVanChuyen.gioGiaoThuong;
    var shippingMethodName = (phuongThucVanChuyenHienTai === "express") ? "Giao hỏa tốc" : "Giao thường";

    var maDonHang = "DH" + Math.floor(1000 + Math.random() * 9000);
    var loiNhan = document.getElementById("inputLoiNhan") ? document.getElementById("inputLoiNhan").value.trim() : "";
    var diaChiDayDu = diaChi.diaChiChiTiet + ", " + diaChi.phuongXa + ", " + diaChi.quanHuyen + ", " + diaChi.tinhThanh;

    // Tóm tắt sản phẩm
    var tomTatSanPham = [];
    for (var k = 0; k < cart.length; k++) {
        tomTatSanPham.push(cart[k].name + " x " + cart[k].quantity);
    }

    var tenPhuongThuc = (phuongThucThanhToanHienTai === "BANK") ? "Chuyển khoản ngân hàng" : "Thanh toán khi nhận hàng (COD)";
    var currentUser = (typeof getCurrentUser === "function") ? getCurrentUser() : null;

    // Tạo đối tượng đơn hàng mới với các trường vận chuyển cố định
    var donHangMoi = {
        id: maDonHang,
        userId: currentUser ? Number(currentUser.id) : null,
        customer: diaChi.hoTen,
        phone: diaChi.soDienThoai,
        address: diaChiDayDu,
        note: loiNhan,
        paymentMethod: tenPhuongThuc,
        shippingMethod: phuongThucVanChuyenHienTai, // 'standard' hoặc 'express'
        shippingMethodName: shippingMethodName,      // 'Giao thường' hoặc 'Giao hỏa tốc'
        shippingFee: ketQuaTien.phiVanChuyen,       // 30000 hoặc 50000
        orderDate: orderDate,                       // Ngày đặt (dd/mm/yyyy)
        orderTime: orderTime,                       // Giờ đặt (hh:mm)
        estimatedDeliveryDate: estimatedDeliveryDate, // Ngày giao dự kiến
        estimatedDeliveryTime: estimatedDeliveryTime, // Giờ giao dự kiến (Trước 18:00 hoặc Trước hh:mm)
        actualDeliveryTime: null,                   // Thời gian giao thực tế (Admin cập nhật khi hoàn thành)
        deliveryHistory: [],                        // Lịch sử cập nhật ngày giao của Admin
        total: ketQuaTien.tongThanhToan,
        discount: ketQuaTien.giamGiaShip + ketQuaTien.giamGiaVoucher,
        voucher: maVoucherHienTai,
        date: orderDate + " " + orderTime,
        status: "pending",
        statusText: "Chờ xác nhận",
        productSummary: tomTatSanPham.join(", "),
        items: cart
    };

    // 3. Lưu đơn hàng vào danh sách đơn hàng của hệ thống (localStorage)
    var orders = (typeof getStoredOrders === "function") ? getStoredOrders() : [];
    orders.unshift(donHangMoi);
    if (typeof saveStoredOrders === "function") {
        saveStoredOrders(orders);
    } else {
        localStorage.setItem("techstore_orders_v2", JSON.stringify(orders));
        localStorage.setItem("techstore_orders", JSON.stringify(orders));
    }

    // 4. Xóa giỏ hàng sau khi đặt thành công
    if (typeof saveCart === "function") {
        saveCart([]);
    } else {
        localStorage.setItem("techstore_cart_v2", JSON.stringify([]));
        localStorage.setItem("techstore_cart", JSON.stringify([]));
        if (typeof updateCartUI === "function") updateCartUI();
    }

    // 5. Hiển thị giao diện Đặt hàng thành công
    var khungThanhToanChinh = document.getElementById("khungThanhToanChinh");
    var khungDatHangThanhCong = document.getElementById("khungDatHangThanhCong");

    document.getElementById("thanhCongMaDonHang").innerText = "#" + maDonHang;
    var btnTheoDoi = document.getElementById("btnTheoDoiDonHangMoi");
    if (btnTheoDoi) {
        btnTheoDoi.href = "index.php?action=order-tracking&id=" + encodeURIComponent(maDonHang);
    }
    document.getElementById("thanhCongTenNguoiNhan").innerText = donHangMoi.customer;
    document.getElementById("thanhCongSoDienThoai").innerText = donHangMoi.phone;
    document.getElementById("thanhCongDiaChi").innerText = donHangMoi.address;
    document.getElementById("thanhCongPhuongThuc").innerText = tenPhuongThuc;
    document.getElementById("thanhCongVanChuyen").innerText = shippingMethodName + " (" + dinhDangTien(ketQuaTien.phiVanChuyen) + ")";
    var thoiGianGiaoThanhCongEl = document.getElementById("thanhCongThoiGianGiao");
    if (thoiGianGiaoThanhCongEl) {
        thoiGianGiaoThanhCongEl.innerText = estimatedDeliveryDate + " (" + estimatedDeliveryTime + ")";
    }
    document.getElementById("thanhCongTongTien").innerText = dinhDangTien(ketQuaTien.tongThanhToan);

    if (khungThanhToanChinh) khungThanhToanChinh.style.display = "none";
    if (khungDatHangThanhCong) khungDatHangThanhCong.style.display = "block";

    // Cuộn lên đầu trang
    window.scrollTo({ top: 0, behavior: "smooth" });

    if (typeof showToast === "function") {
        showToast("Đặt hàng thành công! Mã đơn: #" + maDonHang, "success");
    }
}
</script>
