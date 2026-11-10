# Home Lab Store

Website bán hàng viết bằng Laravel 9 (PHP 8), có trang quản trị và thanh toán VNPay.

## Yêu cầu

- PHP 8.0 trở lên (Docker dùng PHP 8.2), Composer
- MySQL 8
- Node.js + npm (chỉ cần khi sửa CSS/JS trong `resources/`)

Thư mục `vendor/` đã có sẵn trong bản này. Nếu bị thiếu, chạy `composer install`.

---

## Cách 1: Chạy bằng Docker

```bash
cp .env.example .env
```

Sửa `.env` để app kết nối được với container MySQL:

```
APP_URL=http://localhost:8020
DB_HOST=db
DB_PORT=3306
DB_USERNAME=homelab
DB_PASSWORD=matkhau123
```

> Không đặt `DB_USERNAME=root`: image MySQL không cho tạo thêm user tên `root`.

```bash
sudo chmod -R 777 storage/ bootstrap/cache/
sudo docker-compose up -d --build

sudo docker exec -it appwhl composer install --ignore-platform-reqs
sudo docker exec -it appwhl php artisan key:generate
```

Import database (container MySQL tên `dbwhl`):

```bash
sudo docker exec -i dbwhl sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"' < database/home-lab-store.sql
```

Mở trình duyệt: http://localhost:8020

---

## Cách 2: Chạy trực tiếp trên máy (XAMPP, Laragon...)

1. Tạo database tên `home-lab-store` (utf8mb4) trong phpMyAdmin.
2. Import file `database/home-lab-store.sql` vào database đó.
3. Cấu hình và chạy:

```bash
cp .env.example .env          # Windows: copy .env.example .env
# sửa DB_HOST=127.0.0.1, DB_USERNAME, DB_PASSWORD trong .env cho đúng máy bạn
php artisan key:generate
php artisan storage:link       # nếu báo "already exists" thì bỏ qua, thư mục đã có sẵn
php artisan serve
```

Mở trình duyệt: http://localhost:8000 (nhớ đổi `APP_URL` trong `.env` cho khớp).

---

## Cấu hình thêm (không bắt buộc)

| Tính năng | Cần điền |
|---|---|
| Thanh toán VNPay | `VNPAY_TMN_CODE`, `VNPAY_HASH_SECRET` trong `.env` (đăng ký tại https://sandbox.vnpayment.vn/) |
| Gửi email | `MAIL_USERNAME`, `MAIL_PASSWORD` (với Gmail là *App password*), `MAIL_FROM_ADDRESS` |
| Hàng đợi (gửi mail nền) | Chạy thêm `php artisan queue:work` |
| Thông báo / chat realtime ở trang admin | Điền cấu hình Firebase vào `public/firebase/fb.js`. Để trống thì admin vẫn chạy, chỉ tắt phần realtime. |

## Ghi chú

- Sau khi import `home-lab-store.sql` thì **không cần** chạy `php artisan migrate`: file SQL đã có sẵn các cột thanh toán và bảng `payment_logs`. Nếu lỡ chạy cũng không sao, migration sẽ tự bỏ qua phần đã có.
- Ảnh sản phẩm, bài viết, logo... nằm trong `public/images/`. File `public/images.zip` là bản sao lưu của thư mục này, không cần giải nén.
- Nếu sửa CSS/JS trong `resources/`: chạy `npm install` rồi `npm run dev` để build lại vào `public/`.
- Không commit file `.env` (chứa mật khẩu và khóa VNPay). Muốn thêm biến mới thì thêm tên biến vào `.env.example` để người khác biết cần điền.
