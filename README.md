# Hotringo Contact API

API backend untuk formulir kontak **hotringo.tech**.
Setiap pesan yang dikirim dari website akan:

1. **Disimpan ke database** (`contact_messages`)
2. **Diteruskan via email** ke admin (AWS SES)
3. Bisa dipantau dan dianalisis kemudian

---

## Fitur Utama

- Endpoint **healthcheck** untuk cek status API (`/api/ping`)
- Endpoint **contact form** (`/api/contact`) untuk:
  - validasi input (nama, email, subject, pesan)
  - mengirim email ke admin menggunakan **AWS SES**
  - menyimpan pesan ke database
- Konfigurasi **AWS SES mailer** di Laravel
- Spesifikasi **OpenAPI 3** ada di `doc/api-documentation.yml`
- Deploy ke VPS (Nginx + PHP-FPM) dan di-*otomatisasi* via **GitHub Actions**

---

## Tech Stack

- **PHP** 8.4
- **Laravel** 12.x
- **MySQL** 
- **AWS SES** (Simple Email Service) – mailer
- **GitHub Actions** – CI/CD deploy ke VPS
- **OpenAPI 3.0.3** – dokumentasi API (`doc/api-documentation.yml`)
- **Redis**

---

## 🌐 Base URL

* **Production**: `http://127.0.0.1:8000`

Semua endpoint menggunakan prefix `/api`, contoh:

* `http://127.0.0.1:8000/api/ping`
* `http://127.0.0.1:8000/api/contact`

---

## 🚦 Ringkasan Endpoint

### 1. Healthcheck — `GET /api/ping`

Cek apakah API sedang berjalan.

**Contoh Request**

```http
GET /api/ping
Host: 127.0.0.1:8000
Accept: application/json
```

**Contoh Response 200**

```json
{
  "success": true,
  "message": "API hotringo-ses berjalan",
  "data": {
    "service": "contact-api"
  },
  "errors": null
}
```

---

### 2. Kirim Pesan Kontak — `POST /api/contact`

Endpoint ini dipanggil oleh form kontak di website. Data akan:

* divalidasi,
* disimpan ke database,
* dikirim ke admin via email (AWS SES).

**Request Body (JSON)**

```json
{
  "name": "Nur Oktavia Nanda",
  "email": "nanda@example.com",
  "subject": "Pertanyaan kerjasama",
  "message": "Halo, saya tertarik menggunakan layanan Anda..."
}
```

**Aturan Validasi**

* `name` – required, string, max 255
* `email` – required, email, max 255
* `subject` – required, string, max 255
* `message` – required, string

**Contoh Response 201 (Sukses)**

```json
{
  "success": true,
  "message": "Pesan Anda sudah tersimpan dan terkirim. Balasan akan dikirim maksimal 1×24 jam (hari kerja).",
  "data": {
    "id": 1
    "name": "Nanda"
    "email": "nanda@example.com"
  },
  "errors": null
}
```

Jika validasi gagal, response akan mengikuti pola error standar (`success=false`, `errors` berisi detail field) — detail skema bisa dilihat di dokumentasi Bump.sh.

---

## 🧱 Arsitektur Singkat

Repository ini menggunakan pola API yang sederhana dan bersih:

### Model

* `App\Models\ContactMessage`

  * Menyimpan data utama pesan kontak (name, email, subject, message)
  * Menyimpan info teknis: `status`, `source`, `ip_address`, `user_agent`
  * Extend `BaseModel` yang sudah memiliki kolom audit:

    * `created_at`, `created_by`
    * `updated_at`, `updated_by`

### BaseModel

`App\Models\BaseModel` menangani:

* Proteksi kolom audit dengan `$guarded`
* Casting tanggal (`created_at`, `updated_at`)
* Event `creating` & `updating` untuk mengisi `created_by` dan `updated_by` otomatis berdasarkan user yang login

### Controller

* `App\Http\Controllers\ContactController`

  * Method utama: `submitApi(Request $request)`
  * Tugas:

    * Validasi request
    * Membuat `ContactMessage`
    * Mengirim email ke admin (`ContactAdminMail`)
    * Mengembalikan JSON dengan helper `success()` / `internalError()`

### Base Controller

* `App\Http\Controllers\Controller`

  * Berfungsi sebagai **BaseController** untuk semua controller
  * Menyediakan helper:

    * `success($data, $message, $status=200)`
    * `fail($message, $status=400, $errors=null)`
    * `internalError($e, $message='Internal server error')`
  * Memastikan format response JSON konsisten:

```json
{
  "success": true,
  "message": "...",
  "data": { ... },
  "errors": null
}
```

### Mail

* `App\Mail\ContactAdminMail`

  * Digunakan untuk mengirim notifikasi ke admin ketika ada pesan baru
  * Menggunakan view `emails.contact-admin`
  * `replyTo` di-set ke `email` & `name` pengirim sehingga admin bisa langsung membalas

---

## 🚀 Deployment

Deploy ke VPS dilakukan dengan GitHub Actions.

### Workflow: Deploy ke VPS

File: `.github/workflows/deploy-vps.yml`

* Trigger:

  * `push` ke branch `main`
  * manual via **Actions → Run workflow**
* Langkah utama:

  1. Checkout kode
  2. Setup SSH agent dengan `VPS_SSH_KEY`
  3. SSH ke VPS (`VPS_USER` @ `VPS_HOST`)
  4. `git pull origin main`
  5. `composer install --no-dev --optimize-autoloader`
  6. `php artisan migrate --force`
  7. Set permission `storage` & `bootstrap/cache`
  8. Clear & cache config + route

Credensial VPS (host, user, SSH key) disimpan sebagai **GitHub Secrets**:

* `VPS_HOST`
* `VPS_USER`
* `VPS_SSH_KEY`

---

## 📚 Integrasi Bump.sh

Workflow lain digunakan untuk mengelola dokumentasi API di Bump.sh dan mengecek perubahan API saat pull request.

* File definisi OpenAPI: `doc/api-documentation.yml`
* Workflow (contoh): `.github/workflows/api-docs-bumpsh.yml`
* Fungsi:

  * `push` ke `main/master` → deploy dokumen ke Bump.sh
  * `pull_request` ke `main/master` → generate API diff dan komentar otomatis di PR

Token Bump.sh disimpan sebagai secret `BUMP_TOKEN`.

---

## 🧪 Menjalankan Secara Lokal

1. Clone repository:

```bash
git clone <url-repo>
cd <nama-folder-repo>
```

2. Install dependency:

```bash
composer install
```

3. Salin file `.env` dan sesuaikan konfigurasi:

```bash
cp .env.example .env
php artisan key:generate
```

Atur minimal:

* koneksi database (DB_*)
* konfigurasi mail / AWS SES

4. Jalankan migrasi:

```bash
php artisan migrate
```

5. Jalankan server lokal:

```bash
php artisan serve
```

Akses:

* `GET http://localhost:8000/api/ping`
* `POST http://localhost:8000/api/contact`

---

## 🔒 Catatan Keamanan

* Endpoint `/api/contact` **tidak memerlukan autentikasi**, tapi:

  * validasi input wajib,
  * disarankan menambah rate limiting / CAPTCHA jika traffic publik sudah besar.
* Email admin untuk notifikasi SES sebaiknya disimpan di konfigurasi, misalnya:

  * di `.env`:

    ```env
    CONTACT_ADMIN_EMAIL=theo@example.com
    ```

  * di `config/mail.php` atau config khusus:

    ```php
    'contact_admin_email' => env('CONTACT_ADMIN_EMAIL', 'theo@example.com'),
    ```

  * di controller:

    ```php
    $adminEmail = config('mail.contact_admin_email');
    ```

Seiring API berkembang (endpoint baru / versi baru), ingat untuk:

* update `doc/api-documentation.yml`,
* memastikan workflow Bump.sh dan deploy tetap hijau,
* menambah test bila diperlukan (feature test untuk endpoint utama).
