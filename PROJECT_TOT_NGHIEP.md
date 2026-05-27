# Project TOT NGHIEP

## Ten du an

Otoku Circle

## Y tuong chinh

Day la mot web app dang mini forum, giong Reddit/Locket don gian, danh cho nguoi nuoc ngoai moi sang Nhat. Muc tieu la giup ho chia se thong tin giam gia o sieu thi, vi nguoi moi sang thuong gap kho khan voi Kanji, nhan sale, ten san pham, gia da giam va moi truong song moi.

App khong can lay du lieu chinh thuc tu sieu thi. Noi dung se do user tu dang:

- Anh san pham hoac nhan sale
- Mo ta bang tieng Anh
- Ten sieu thi
- Gia da giam / tiet kiem duoc bao nhieu
- Tag huu ich nhu kanji-help, halal, vegetarian, beginner, night-deal
- Like, comment, bookmark, notification

## Doi tuong su dung

Nguoi nuoc ngoai o Nhat, dac biet la nguoi moi sang:

- Khong doc tot Kanji
- Khong biet sieu thi nao re
- Khong hieu nhan giam gia
- Can thong tin tu cong dong nguoi cung hoan canh

## Van de can giai quyet

Nguoi nuoc ngoai moi sang Nhat gap rao can ngon ngu trong sinh hoat hang ngay, dac biet khi di sieu thi. Bang gia, nhan sale, ten san pham va thong tin han su dung thuong bang tieng Nhat/Kanji, khien ho kho biet san pham nao dang giam gia va nen mua o dau.

## Giai phap

Tao mot web app mini forum bang tieng Anh, noi nguoi dung co the tu dang bai chia se sale. Thong tin khong phu thuoc vao sieu thi hay API ben thu ba, ma duoc xay dung boi cong dong user.

## Ly do phu hop voi do an tot nghiep

- Van de thuc te, de giai thich trong bao cao
- Doi tuong ro rang: nguoi nuoc ngoai o Nhat
- Khong can du lieu kho lay tu sieu thi
- Phu hop voi stack da hoc
- Co the trien khai bang web app don gian
- Co tinh ung dung thuc te

## Tech stack

- HTML
- CSS
- JavaScript
- PHP
- MySQL
- MAMP

## Huong UI da chon

Giao dien theo huong Locket + mini forum:

- Home co mot bai post lon noi bat
- Ben duoi la cac post nho de xem nhanh
- Post co the la anh, text, hoac ca hai
- Giao dien bang tieng Anh
- Co dark mode/light mode
- Phong cach tre, fresh, de dung lau
- Tap trung vao gia tri nhanh: deal gan toi, tiet kiem duoc bao nhieu, user dang tin cay

## Cac man hinh User da tao

1. Home
   - Post lon kieu Locket
   - Thumbnail post nho ben duoi
   - Loc theo All, Near me, Text tips, Photos, Ending soon
   - Bang xep hang helper

2. Search
   - Tim kiem theo san pham, cua hang, tag
   - Tag goi y: kanji-help, halal, vegetarian, night-deal, beginner

3. Create Post
   - Them anh
   - Tieu de bai dang
   - Mo ta tieng Anh
   - Ten cua hang
   - So tien tiet kiem uoc tinh
   - Tag
   - Tinh trang deal

4. Nearby
   - Ban do gia lap don gian
   - Pin cac cua hang gan do
   - Danh sach store duoc tao tu bai post user

5. Profile
   - Thong tin user
   - So bai dang
   - Tong tien tiet kiem
   - Helpful votes
   - Saved posts

6. Notifications
   - Like
   - Comment
   - Badge
   - Deal gan vi tri

7. Post Detail
   - Anh/text bai dang
   - Mo ta
   - Store
   - Tag
   - Comment

## File hien co

- `index.html`
- `styles.css`
- `script.js`
- `local-server.cjs`
- `app.js`
- `index.php`
- `search.php`
- `create.php`
- `nearby.php`
- `profile.php`
- `notifications.php`
- `post_detail.php`
- `create_store.php`
- `setup_check.php`
- `MAMP_SETUP.md`
- `includes/data.php`
- `includes/functions.php`
- `includes/header.php`
- `includes/footer.php`
- `login.php`
- `register.php`
- `logout.php`
- `database.sql`
- `includes/config.php`
- `includes/db.php`
- `includes/auth.php`

## Cach chay preview

Chay lenh:

```bash
node local-server.cjs
```

Mo trinh duyet:

```text
http://127.0.0.1:9911
```

## Trang thai hien tai

Da hoan thanh giao dien User tinh bang HTML/CSS/JavaScript.

Da tach them thanh bo trang PHP nhieu file de chuan bi noi backend:

- `index.php`: Home Locket-style
- `search.php`: Search/filter
- `create.php`: Form tao post
- `nearby.php`: Nearby/map gia lap
- `profile.php`: Profile user
- `notifications.php`: Thong bao
- `post_detail.php`: Chi tiet bai dang va comments
- `includes/data.php`: Du lieu mau
- `includes/functions.php`: Helper render va escape HTML
- `includes/header.php`: Layout header/context/nav
- `includes/footer.php`: Layout footer/nav/script
- `app.js`: Toggle dark/light mode cho bo PHP

Da lam tiep B va D:

- Them login/register/logout bang PHP
- Them `users` table trong `database.sql`
- Them ket noi PDO trong `includes/db.php`
- Them config database trong `includes/config.php`
- Them session auth trong `includes/auth.php`
- Header hien Login neu chua dang nhap
- Profile hien thong tin user neu da dang nhap
- Them UI auth card, alert error, focus state cho form, upload zone dep hon

Da doi mo hinh cua hang:

- Bo y tuong store data chinh thuc tu sieu thi
- Doi tab `Nearby` thanh `Places`
- `nearby.php` thanh man hinh `Community places`
- Store/place info la du lieu do user tu tao sau khi da di thuc te
- Them `create_store.php` de user them place da ghe
- Them bang `stores` trong `database.sql`
- `create_store.php` co the luu store vao MySQL neu user da login va database da tao
- `nearby.php` doc store tu MySQL neu co, neu chua co database thi fallback sang du lieu mau
- `create.php` them link de user tao community place neu place chua co

Da lam huong dan chay bang MAMP/phpMyAdmin:

- Them `MAMP_SETUP.md` voi cac buoc copy vao `C:\MAMP\htdocs\otoku-circle`, import `database.sql`, mo URL bang localhost
- Them `setup_check.php` de kiem tra PHP version, ket noi database, bang `users`, bang `stores`
- Neu database chua import, `setup_check.php` van mo duoc va hien thong bao can import SQL

Da test:

- Chay PHP lint bang `C:\MAMP\bin\php\php8.3.1\php.exe -l`
- Tat ca file PHP khong co loi syntax
- Chay PHP built-in server va kiem tra `index.php`, `login.php`, `register.php`, `profile.php` deu tra HTTP 200
- Chay PHP built-in server va kiem tra `nearby.php`, `create_store.php`, `create.php` deu tra HTTP 200
- Chay PHP built-in server va kiem tra `setup_check.php`, `index.php`, `register.php`, `nearby.php` deu tra HTTP 200

Chua lam:

- Database cho posts/comments/likes/bookmarks/notifications
- PHP create/read post
- Upload anh that
- Like/comment that
- Ket noi frontend voi backend

## Nguyen tac lam tiep

Nguoi dung muon lam xong phan giao dien User truoc. Sau khi hoan thanh moi hoi tiep theo lam gi. Ve sau cung lam theo cach nay: lam xong mot phan ro rang, tom tat lai, roi hoi buoc tiep theo.

Neu doan chat dai hoac gan het token/context, phai save backup lai vao file nay truoc. Backup can gom:

- Viec da lam
- File da sua/tao
- Trang thai hien tai
- Loi hoac gioi han neu co
- Buoc tiep theo nen lam

## Buoc tiep theo co the lam

1. Chinh UI neu can dep hon
2. Thiet ke database MySQL
3. Lam PHP login/register
4. Chuyen giao dien thanh cac file PHP
5. Ket noi Create Post voi MySQL
6. Lam like/comment bang JavaScript + PHP API
