# 🚀 WORKFLOW TRIỂN KHAI OTOKU CIRCLE

## ✅ ĐÃ HOÀN THÀNH (Phase 1 - Core Infrastructure)

### 1. Thư mục `includes/` với các file thiết yếu
- ✅ `config.php` - Cấu hình database, upload, session, security
- ✅ `db.php` - Singleton pattern cho PDO connection
- ✅ `auth.php` - Authentication helpers (login, logout, session management)
- ✅ `functions.php` - Helper functions (CSRF, upload, sanitize, paginate, etc.)
- ✅ `header.php` - Common header với navigation và flash messages
- ✅ `footer.php` - Common footer

### 2. Database Schema hoàn chỉnh (`database.sql`)
- ✅ `users` - Bảng users với verification, reset password tokens
- ✅ `stores` - Bảng stores với geolocation (lat/lng), opening hours
- ✅ `posts` - Bảng posts với prices, discounts, expiration, stats counters
- ✅ `tags` - Bảng tags với colors và descriptions
- ✅ `post_tags` - Many-to-many relationship giữa posts và tags
- ✅ `comments` - Bảng comments với nested replies (parent_id)
- ✅ `likes` - Bảng likes cho posts và comments
- ✅ `bookmarks` - Bảng bookmarks
- ✅ `notifications` - Bảng notifications với types
- ✅ Default tags được insert sẵn (8 tags)

### 3. Upload directory
- ✅ `/workspace/uploads/` - Thư mục chứa uploaded images

---

## 📋 CÁC BƯỚC TIẾP THEO

### Phase 2: Setup Database & Test Connection

```bash
# 1. Import database schema vào MySQL
mysql -u root -p < /workspace/database.sql

# 2. Kiểm tra database đã tạo
mysql -u root -p -e "USE otoku_circle; SHOW TABLES;"

# 3. Kiểm tra default tags
mysql -u root -p -e "USE otoku_circle; SELECT * FROM tags;"
```

### Phase 3: Cập nhật các file PHP hiện có

#### Bước 3.1: Cập nhật `register.php`
- Include `includes/config.php`, `includes/db.php`, `includes/functions.php`
- Sử dụng CSRF token
- Hash password với `password_hash()`
- Insert user vào database
- Redirect với flash message

#### Bước 3.2: Cập nhật `login.php`
- Include auth helpers
- Verify password với `password_verify()`
- Login user với `loginUser()`
- Session management

#### Bước 3.3: Cập nhật `create.php`
- Include tất cả includes files
- Xử lý form submit với CSRF verification
- Upload image với `uploadImage()`
- Insert post vào database
- Redirect với flash message

#### Bước 3.4: Cập nhật `index.php`
- Fetch posts từ database với JOIN users, stores
- Pagination
- Display real data thay vì mock data

#### Bước 3.5: Cập nhật `post_detail.php`
- Fetch single post với user info
- Fetch comments với nested replies
- Like/comment/bookmark functionality

### Phase 4: Dynamic Features (AJAX/API)

#### Tạo file `api/like.php`
```php
// Handle like/unlike post
// Return JSON response
```

#### Tạo file `api/comment.php`
```php
// Handle add comment
// Return JSON response
```

#### Tạo file `api/bookmark.php`
```php
// Handle bookmark/unbookmark
// Return JSON response
```

### Phase 5: Security Enhancements

- ✅ CSRF tokens (đã implement trong functions.php)
- ⏳ Rate limiting cho login/register
- ⏳ Input validation chi tiết
- ⏳ Email verification flow
- ⏳ Forgot password flow
- ⏳ Secure HTTP headers

### Phase 6: Performance Optimization

- ⏳ Pagination cho posts/comments
- ⏳ Image optimization (resize, compress)
- ⏳ Database indexes (đã thêm trong schema)
- ⏳ Query optimization
- ⏳ Caching mechanism

---

## 🔧 HƯỚNG DẪN SETUP NHANH

### 1. Cài đặt MAMP/Môi trường PHP

```bash
# Nếu dùng MAMP trên Mac:
# - Start MAMP
# - Đảm bảo PHP và MySQL đang chạy
# - Port mặc định: 8888 (HTTP), 8889 (MySQL)

# Nếu dùng Docker:
docker run -d --name otoku-circle \
  -p 8888:80 \
  -p 3306:3306 \
  -v /workspace:/var/www/html \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=otoku_circle \
  php:8.2-apache
```

### 2. Import Database

```bash
# Kết nối MySQL và import schema
mysql -h localhost -P 8889 -u root -proot < /workspace/database.sql
```

### 3. Cấu hình `includes/config.php`

Cập nhật thông tin database nếu cần:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'otoku_circle');
define('DB_USER', 'root');
define('DB_PASS', 'root'); // Hoặc password của bạn
define('APP_URL', 'http://localhost:8888');
```

### 4. Phân quyền thư mục uploads

```bash
chmod 755 /workspace/uploads
chown www-data:www-data /workspace/uploads  # Nếu dùng Apache
```

### 5. Truy cập ứng dụng

```
http://localhost:8888/index.php
http://localhost:8888/register.php
http://localhost:8888/login.php
```

---

## 📊 KIẾN TRÚC DATABASE

```
users (1) ──< (N) posts
  │              │
  │              ├──> stores (N)
  │              │
  │              ├──< (N) comments
  │              ├──< (N) likes
  │              ├──< (N) bookmarks
  │              └──< (N) notifications
  │
  └──< (N) stores
  
posts (1) ──< (N) comments
   │           │
   │           └──> parent_id (self-reference for replies)
   │
   ├──< (N) likes
   ├──< (N) bookmarks
   └──< (N) post_tags >── (1) tags
```

---

## 🎯 ƯU TIÊN TIẾP THEO

1. **Test database connection** - Tạo file test đơn giản
2. **Update register.php** - Hoàn thiện registration flow
3. **Update login.php** - Hoàn thiện login flow
4. **Update create.php** - Implement post creation với image upload
5. **Update index.php** - Fetch và display posts từ database

Bạn muốn tôi tiếp tục implement phần nào trước? Tôi recommend bắt đầu với **register.php** và **login.php** để hoàn thiện authentication flow! 🔥
