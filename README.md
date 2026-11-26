# TECH STORE - Website Bán Hàng Công Nghệ

Dự án mẫu thực hành Front-End kết hợp mô hình MVC PHP cơ bản (FPT Polytechnic - Môn WD21302).

## 🚀 Giới Thiệu Dự Án
Website thương mại điện tử chuyên bán các sản phẩm công nghệ hiện đại:
- **Điện thoại:** iPhone 16 Pro Max, Samsung Galaxy S24 Ultra...
- **Laptop:** MacBook Pro M3, ASUS ROG Strix, Dell XPS 15...
- **Máy tính bảng:** iPad Pro M4, iPad Air...
- **Phụ kiện:** Tai nghe AirPods Pro 2, Sony WH-1000XM5, Chuột Logitech MX Master 3S, Bàn phím cơ DareU...

## 🌟 Chức Năng Nổi Bật
1. **Giao diện trang chủ hiện đại:**
   - Header với Logo TECH STORE, thanh tìm kiếm thông minh, giỏ hàng đếm số lượng, khối đăng nhập/đăng xuất động.
   - Menu điều hướng theo danh mục và trang khuyến mãi.
   - Banner Slider quảng cáo sản phẩm công nghệ sinh động.
   - Khối dịch vụ cam kết chính hãng, giao hàng 2h, đổi trả 30 ngày.
   - Danh mục sản phẩm nổi bật.
   - Khối Sản phẩm nổi bật, Sản phẩm mới nhất, Sản phẩm khuyến mãi giảm sốc.
   - Footer thông tin cửa hàng, showroom, chính sách và liên hệ.
2. **Bộ lọc & Tìm kiếm:** Lọc sản phẩm theo danh mục và tìm kiếm theo tên ngay trên trang.
3. **Modal xem chi tiết:** Xem chi tiết cấu hình, thông số, mô tả sản phẩm.
4. **Giỏ hàng lưu trữ LocalStorage:** Thêm vào giỏ, tăng/giảm số lượng, xóa sản phẩm, tính tổng tiền và thanh toán demo.
5. **Xác thực và Phân quyền tài khoản qua MySQL (PHP Session):**
   - **Tài khoản Admin:**
     - Thông tin demo: **`admin`** | Mật khẩu: **`123456`**
     - Đăng nhập xong hiển thị huy hiệu **`ADMIN`** màu vàng trên Header.
     - Có quyền truy cập Bảng điều khiển Quản trị (`index.php?action=admin`).
     - **Chức năng Quản trị & Sửa Sản Phẩm:** Cho phép Admin xem danh sách sản phẩm, chỉnh sửa trực tiếp thông tin (Tên, Danh mục, Giá bán, Giá khuyến mãi, Tồn kho, Trạng thái kinh doanh, Hình ảnh, Mô tả) qua cửa sổ Modal hiện đại, lưu trữ tự động vào `localStorage` không bị mất dữ liệu khi F5.
   - **Tài khoản Khách hàng (Customer):**
     - Trang đăng ký riêng: `index.php?action=register` với đầy đủ kiểm tra hợp lệ (Họ tên, Username, Email, Số điện thoại, Mật khẩu >= 6 ký tự).
     - Đăng ký thành công -> Có thể dùng tài khoản hoặc email vừa tạo để đăng nhập ngay lập tức.
     - Đăng nhập xong hiển thị tên khách hàng và huy hiệu **`KHÁCH HÀNG`** màu xanh trên Header.
     - **Phân quyền bảo vệ:** Khách hàng không thể truy cập trang Quản trị Admin (hệ thống sẽ tự động chặn và cảnh báo).
   - **Bảo mật và phiên làm việc:**
     - Mật khẩu được mã hoá bằng `password_hash()` (bcrypt), xác thực bằng `password_verify()`.
     - Chống tấn công CSRF bằng token cho mọi form đăng nhập / đăng ký / đăng xuất.
     - Duy trì trạng thái đăng nhập khi F5 tải lại trang (PHP Session).
     - Đăng xuất xóa phiên làm việc và trở về trạng thái chưa đăng nhập tức thì.

## 🗄️ Cơ Sở Dữ Liệu MySQL

- CSDL `hhta` được tạo và quản lý **trực tiếp bằng MySQL** (project không chứa file `.sql` nào).
- Cấu hình kết nối nằm trong `configs/env.php` (`DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USERNAME`, `DB_PASSWORD`).
- Bảng `users` gồm: `id`, `full_name`, `username`, `email`, `phone`, `password`, `role`, `created_at`, `updated_at`.
- Tạo bảng đơn hàng bằng cách chạy file `database/orders.sql` trên CSDL `hhta`; bảng này lưu `note`, `fulfillment_method` và danh sách mặt hàng JSON.
- Tài khoản Admin mặc định: **`admin`** / **`123456`**.
- Mật khẩu đang lưu dạng **chữ/số bình thường** vì `PASSWORD_MODE = 'plain'` trong `configs/env.php` (dễ quan sát trong MySQL, phù hợp học tập/demo).
- Khi triển khai thật, đổi `PASSWORD_MODE` thành `'hash'` để bật mã hoá bcrypt. Code hỗ trợ đăng nhập cho cả tài khoản cũ (hash) và mới (plain).
- Cần tạo hash thủ công: `php tools/hash-password.php "matkhau"`.

## 🛠️ Hướng Dẫn Chạy Website

### Cách 1: Chạy bằng Laragon (Khuyên dùng)
1. Mở ứng dụng **Laragon**.
2. Nhấn nút **Start All** để khởi động Apache & MySQL.
3. Mở trình duyệt web và truy cập theo đường dẫn:
   `http://localhost/WD21302 - Phát triển dự án Website với AI/base-duanmau/base-duanmau/`

### Cách 2: Chạy bằng PHP Built-in Server
1. Mở Terminal / PowerShell tại thư mục dự án này.
2. Chạy lệnh:
   ```bash
   C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe -S localhost:8000
   ```
3. Mở trình duyệt và truy cập: `http://localhost:8000`

