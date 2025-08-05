# Sistem Penatausahaan Keuangan

Aplikasi berbasis Laravel untuk pengelolaan penatausahaan keuangan seperti pegawai, kegiatan, keuangan, dan lainnya. Menggunakan template [Stisla](https://stisla.dev/) sebagai antarmuka.

---

## ⚙️ Requirements

| Tools        | Versi Minimal   |
|--------------|-----------------|
| PHP          | 8.1 atau lebih  |
| Composer     | 10.x             |
| MySQL        | 11.8.2 atau lebih  |
| Node.js      | 14.x atau lebih |
| Yarn         | 1.22.x          |
| Git          | Terinstal       |

---

## 🧩 Instalasi Proyek

**Clone Repository**

```bash
git clone https://github.com/Shafirasal/penatausahaan_keuangan
```

**masuk ke direktori proyek:**

```bash
cd penatausahaan_keuangan
```

**buka melalui code editor dan buka terminal**
```bash
cp .env.example .env
```
**Ubah isi .env sesuai konfigurasi database lokal:**

```php
DB_DATABASE=penatausahaan_keuangan
DB_USERNAME=root
DB_PASSWORD=
```

**install dependensi backend:**

```bash
composer install
composer require yajra/laravel-datatables-oracle
```

**generate App Key:**

```bash
php artisan key:generate
```

**migrasi dan seed database:**

```bash
php artisan migrate --seed
```

**masuk ke folder template:**

```bash
cd stisla1
yarn
yarn dist
cd ..
```
**pastikan node.js sudah teristall. jika belum instal di terminal komputer:**
```bash
npm install --global yarn
```
**Link Storage (untuk akses file/foto):**

```bash
php artisan storage:link
```

**jalankan di server lokal:**
```bash
php artisan serve
```

---

**🔐 LOGIN DEFAULT:**
username ```12345```
password ```12345```
