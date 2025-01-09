# **Library Management System - Book Management Service**

Proyek ini adalah **Book Management Service** dari sistem manajemen perpustakaan, dibangun menggunakan **CodeIgniter 4 (CI4)**. Layanan ini memungkinkan admin perpustakaan untuk mengelola koleksi buku, seperti menambahkan, mengedit, melihat, dan menghapus buku. Sistem ini juga dilengkapi autentikasi dan otorisasi untuk memastikan keamanan akses.

---

## **Fitur**
- **Authentication & Authorization**:
  - Pengguna harus login untuk mengakses layanan.
  - Hanya admin yang dapat menambah, mengedit, dan menghapus buku.
- **Manajemen Buku**:
  - Tambahkan, ubah, lihat, dan hapus data buku.
  - Data buku meliputi judul, pengarang, kategori, deskripsi, dan status (*available* atau *borrowed*).
- **Endpoint RESTful**:
  - CRUD operasi sesuai dengan standar RESTful API.

---

## **Persyaratan Sistem**
- **PHP** versi 7.4 atau lebih baru dengan ekstensi:
  - `pdo`, `pdo_mysql`, `mbstring`, `json`
- **Composer** untuk pengelolaan dependensi.
- **MySQL** sebagai database.
- **PHP CLI server** untuk menjalankan aplikasi (tidak perlu XAMPP).

---

## **Langkah-Langkah Instalasi**
1. **Clone Repository**
   Clone repository ini ke komputer lokal Anda:
   ```bash
   git clone https://github.com/your-repository/library-book-management.git
   cd library-book-management
   ```

2. **Install Dependensi**
   Pastikan Composer sudah terinstal, lalu jalankan:
   ```bash
   composer install
   ```

3. **Konfigurasikan File `.env`**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Kredensial database default sudah diatur untuk menggunakan database yang telah di-*deploy*. Anda tidak perlu mengubahnya kecuali jika ingin menggunakan database Anda sendiri.

4. **Jalankan Server**
   Gunakan server bawaan PHP untuk menjalankan aplikasi:
   ```bash
   php spark serve
   ```
   Aplikasi dapat diakses di `http://localhost:8080/books`.

---

## **Struktur Endpoint API**

### **Authentication**
- `POST /authenticate` - Login pengguna.
- `GET /logout` - Logout pengguna.

### **Books**
- `GET /books` - Menampilkan daftar buku.
- `POST /books/store` - Menambahkan buku baru (*hanya admin*).
- `GET /books/edit/{id}` - Mengedit data buku (*hanya admin*).
- `POST /books/update/{id}` - Memperbarui data buku (*hanya admin*).
- `DELETE /books/{id}` - Menghapus buku (*hanya admin*).

---

## **Contoh Request**
### **Menghapus Buku**
**Request:**
```bash
DELETE /books/1 HTTP/1.1
Host: localhost:8080
Authorization: Bearer <your-session-token>
```

**Response:**
```json
{
  "success": true,
  "message": "Book deleted successfully."
}
```

---

## **File yang Disertakan**
- **Kode Aplikasi**: Semua file di folder `app/`.
- **File Konfigurasi Penting**:
  - `composer.json` dan `composer.lock`
  - `.env.example`
- **File Migrasi Database**: Terletak di `app/Database/Migrations/`.

**File yang Tidak Disertakan:**
- `.env` asli untuk melindungi informasi sensitif.
- Folder `writable/` yang berisi log dan cache runtime.

---

## **Akses ke Aplikasi**
- **Database**:
  - Host: `mysql-1e73275c-tst-01.h.aivencloud.com`
  - Port: `21959`
  - Nama Database: `defaultdb`
  - Username: `avnadmin`
  - Password: `AVNS__A_pxyQwbTPWRVRmbcF`
- **Aplikasi Dapat Dijalankan di `http://localhost:8080`**

---

## **Demo Video**
Demo cara kerja aplikasi ini dapat ditemukan di YouTube:
- [Link Video Demo](https://youtu.be/your-demo-video-link)

---

## **Kontributor**
- **[Muhammad Yaafi Wasesa Putra]**: Layanan Manajemen Buku


>>>>>>> 690a022f81ba0de42ddbb83229e1bcba986cc211
