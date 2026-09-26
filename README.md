# 🚀 Setup Project Laravel

Dokumentasi ini digunakan untuk menjalankan project Laravel di laptop baru.

---

## 📋 Requirements

Pastikan sudah menginstall:

* Git
* PHP (>= 8.x)
* Composer
* MySQL
* Node.js & npm

---

## 📥 1. Clone Repository

```bash
git clone https://github.com/USERNAME/NAMA_PROJECT.git
cd NAMA_PROJECT
```

---

## 📦 2. Install Dependency Backend

```bash
composer install
```

---

## ⚙️ 3. Setup Environment

Copy file `.env`:

```bash
cp .env.example .env
```

Generate key:

```bash
php artisan key:generate
```

---

## 🗄️ 4. Setup Database

1. Buat database baru di MySQL
   (contoh: `laravel_db`)

2. Import database:

```bash
mysql -u root -p laravel_db < backup.sql
```

3. Sesuaikan `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🎨 5. Install & Build Frontend

```bash
npm install
npm run build
```

---

## ▶️ 6. Jalankan Project

```bash
php artisan serve
```

Akses di browser:

```
http://127.0.0.1:8000
```

---

## ⚠️ Troubleshooting

### ❌ Vite manifest not found

```bash
npm run build
```

### ❌ Composer error

```bash
composer install
```

### ❌ Database error

* Pastikan database sudah dibuat
* Pastikan `.env` sudah benar

---

## 📁 Catatan Penting

File berikut tidak perlu diupload ke GitHub:

```
/vendor
/node_modules
.env
```

---

## 👨‍💻 Author

Project by: [Nama Kamu]

---
