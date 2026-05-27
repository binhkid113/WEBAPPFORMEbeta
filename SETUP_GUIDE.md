# 🚀 HƯỚNG DẪN CÀI ĐẶT OTOKU CIRCLE

## BƯỚC 1: CHUẨN BỊ MAMP

### Trên Mac:
1. Tải MAMP từ https://www.mamp.info/en/downloads/
2. Cài đặt và mở MAMP
3. Bấm **Start Servers**
4. Kiểm tra ports:
   - Apache: 8888
   - MySQL: 8889

### Trên Windows:
1. Tải MAMP từ https://www.mamp.info/en/downloads/
2. Cài đặt và mở MAMP
3. Bấm **Start Servers**
4. Kiểm tra ports:
   - Apache: 80
   - MySQL: 3306

---

## BƯỚC 2: TẠO DATABASE

1. Mở trình duyệt, vào: **http://localhost:8889/phpmyadmin** (Mac) hoặc **http://localhost/phpmyadmin** (Windows)

2. Tạo database mới:
   - Click tab **"New"** ở menu bên trái
   - Nhập tên database: `otoku_circle`
   - Chọn Collation: `utf8mb4_unicode_ci`
   - Click **"Create"**

3. Import database schema:
   - Click vào database `otoku_circle` vừa tạo
   - Click tab **"SQL"** ở menu trên
   - Mở file `/workspace/database.sql` trong project
   - Copy TOÀN BỘ nội dung file
   - Paste vào ô SQL
   - Click **"Go"**
   - ✅ Nếu thành công sẽ hiện thông báo xanh với 9 queries executed

---

## BƯỚC 3: KIỂM TRA KẾT NỐI

1. Tạo file test: `/workspace/test_db.php` với nội dung:

```php
<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

echo "<h1>✅ Database Connection Test</h1>";

try {
    $db = getDB();
    echo "<p style='color: green;'><strong>KẾT NỐI THÀNH CÔNG!</strong></p>";
    
    // Test query
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h2>Các tables trong database:</h2>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li><strong>{$table}</strong></li>";
    }
    echo "</ul>";
    
    // Test tags
    $stmt = $db->query("SELECT * FROM tags");
    $tags = $stmt->fetchAll();
    
    echo "<h2>Các tags mặc định:</h2>";
    echo "<ul>";
    foreach ($tags as $tag) {
        echo "<li>{$tag['name']} ({$tag['slug']})</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'><strong>LỖI: " . $e->getMessage() . "</strong></p>";
}
?>
```

2. Mở trình duyệt, vào: **http://localhost:8888/test_db.php** (Mac) hoặc **http://localhost/test_db.php** (Windows)

3. ✅ Nếu thấy danh sách 9 tables và 8 tags → **THÀNH CÔNG!**

---

## BƯỚC 4: CHẠY ỨNG DỤNG

### Đăng ký tài khoản:
1. Vào: **http://localhost:8888/register.php** (Mac) hoặc **http://localhost/register.php** (Windows)
2. Điền thông tin:
   - Username: testuser
   - Email: test@example.com
   - Password: 12345678
   - Confirm password: 12345678
3. Click **"Create account"**
4. ✅ Nếu chuyển hướng đến profile → **THÀNH CÔNG!**

### Đăng nhập:
1. Vào: **http://localhost:8888/login.php** (Mac) hoặc **http://localhost/login.php** (Windows)
2. Điền email và password vừa đăng ký
3. Click **"Log in"**
4. ✅ Nếu chuyển hướng đến profile → **THÀNH CÔNG!**

---

## BƯỚC 5: PUSH LÊN GITHUB

### Tạo repository mới trên GitHub:
1. Vào https://github.com/new
2. Nhập tên repository: `otoku-circle`
3. Chọn **Public** hoặc **Private**
4. **KHÔNG** tick vào "Initialize this repository with a README"
5. Click **"Create repository"**

### Push code lên GitHub:
Mở terminal và chạy lần lượt các lệnh sau:

```bash
cd /workspace

# Thêm remote repository (thay YOUR_USERNAME bằng username GitHub của bạn)
git remote add origin https://github.com/YOUR_USERNAME/otoku-circle.git

# Đổi tên branch thành main (optional)
git branch -M main

# Push lên GitHub
git push -u origin main
```

Nếu dùng HTTPS và được yêu cầu nhập password:
- Dùng **GitHub Personal Access Token** thay vì password
- Tạo token tại: https://github.com/settings/tokens
- Chọn scopes: `repo`, `workflow`
- Copy token và paste khi được yêu cầu password

---

## CẤU TRÚC PROJECT

```
/workspace
├── includes/              # Thư mục chứa các file dùng chung
│   ├── config.php         # Cấu hình database, upload, session
│   ├── db.php             # Kết nối database (Singleton pattern)
│   ├── auth.php           # Functions đăng nhập/đăng xuất
│   ├── functions.php      # Helper functions (CSRF, upload, sanitize...)
│   ├── data.php           # Data access layer (queries database)
│   ├── header.php         # Header chung cho tất cả pages
│   └── footer.php         # Footer chung cho tất cả pages
├── uploads/               # Thư mục chứa ảnh upload
├── database.sql           # Schema database (9 tables)
├── index.php              # Trang chủ (danh sách posts)
├── login.php              # Trang đăng nhập
├── register.php           # Trang đăng ký
├── logout.php             # Xử lý đăng xuất
├── create.php             # Tạo post mới
├── create_store.php       # Tạo store mới
├── post_detail.php        # Chi tiết post + comments
├── search.php             # Tìm kiếm posts
├── nearby.php             # Xem stores gần đây
├── profile.php            # Profile người dùng
├── notifications.php      # Thông báo
├── styles.css             # CSS chính
├── script.js              # JavaScript chính
└── app.js                 # Dark mode toggle
```

---

## CÁC TABLES TRONG DATABASE

1. **users** - Lưu thông tin người dùng
2. **stores** - Lưu thông tin siêu thị/cửa hàng
3. **posts** - Lưu bài đăng giảm giá
4. **tags** - Lưu các tags (kanji-help, halal, vegetarian...)
5. **post_tags** - Liên kết posts với tags
6. **comments** - Lưu bình luận
7. **likes** - Lưu likes
8. **bookmarks** - Lưu bookmarks
9. **notifications** - Lưu thông báo

---

## XỬ LÝ SỰ CỐ

### Lỗi: "Database connection failed"
- Kiểm tra MAMP đã start chưa
- Kiểm tra port MySQL trong `includes/config.php`
  - Mac: `DB_PORT = 8889`
  - Windows: `DB_PORT = 3306`
- Kiểm tra username/password:
  - Username: `root`
  - Password: `root` (Mac) hoặc `` (Windows - không có password)

### Lỗi: "Table doesn't exist"
- Chưa import file `database.sql`
- Vào phpMyAdmin và import lại

### Lỗi: "Cannot modify header information - headers already sent"
- Có khoảng trắng hoặc echo trước khi gọi `header()`
- Kiểm tra file PHP bị lỗi

### Lỗi: Upload ảnh không hoạt động
- Kiểm tra thư mục `/workspace/uploads/` tồn tại
- Kiểm tra permissions: `chmod 755 uploads/`

---

## LIÊN HỆ

Nếu gặp vấn đề, check:
1. MAMP logs: `/Applications/MAMP/logs/` (Mac)
2. PHP errors: Bật trong `includes/config.php`:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

---

**🎉 CHÚC BẠN THÀNH CÔNG!**
