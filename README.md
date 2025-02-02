# **Library Management API**  
**Sistem Manajemen Perpustakaan Berbasis API dengan CodeIgniter 4 dan MySQL**

---

## **Deskripsi Proyek**  
Library Management API adalah sistem terintegrasi untuk mengelola perpustakaan digital. Sistem ini dibangun menggunakan framework **CodeIgniter 4** dan database **MySQL**. Proyek ini terdiri dari dua layanan utama:  
1. **Book Management**: Mengelola data buku (CRUD) dan status ketersediaan.  
2. **Borrow Management**: Mengelola proses peminjaman dan pengembalian buku.  

Selain itu, sistem ini dilengkapi dengan **Dashboard Analytics** yang menampilkan statistik real-time seperti total buku, buku yang dipinjam, dan pengguna aktif.

---

## **Fitur Utama**  
1. **Book Management**  
   - Menambah, mengedit, menghapus, dan melihat daftar buku.  
   - Melacak status buku (available/borrowed).  

2. **Borrow Management**  
   - Meminjam dan mengembalikan buku.  
   - Validasi ketersediaan buku sebelum peminjaman.  
   - Riwayat peminjaman buku.  

3. **Dashboard Analytics**  
   - Menampilkan statistik:  
     - Total buku.  
     - Buku yang sedang dipinjam.  
     - Pengguna aktif.  

4. **Autentikasi dan Role-Based Access Control (RBAC)**  
   - Admin dapat mengelola buku dan peminjaman.  
   - Pengguna biasa hanya dapat melihat daftar buku.  

---

## **Teknologi yang Digunakan**  
- **Backend**: CodeIgniter 4 (PHP Framework).  
- **Database**: MySQL.  
- **Tools**: Git, Postman (untuk pengujian API).  

---

## **Struktur Database**  
Database terdiri dari tiga tabel utama:  
1. **`books`**: Menyimpan data buku (id, title, author, description, category, status).  
2. **`borrowers`**: Mencatat data peminjaman (id, name, email, phone_number, id_book, borrow_date, return_date).  
3. **`users`**: Mengelola akun pengguna (id, username, password, role).  

---

## **Cara Menjalankan Proyek**  
1. **Clone Repository**  
   ```bash
   git clone https://github.com/yaafiwputraa/library-management.git
   cd library-management
   ```

2. **Install Dependencies**  
   Pastikan Composer sudah terinstall, lalu jalankan:  
   ```bash
   composer install
   ```

3. **Setup Database**  
   - Buat database baru di MySQL.  
   - Import file SQL yang disediakan (jika ada) atau jalankan migrasi:  
     ```bash
     php spark migrate
     ```

4. **Konfigurasi Environment**  
   - Salin file `.env.example` menjadi `.env`.  
   - Sesuaikan konfigurasi database di file `.env`:  
     ```env
     database.default.hostname = localhost
     database.default.database = nama_database
     database.default.username = username
     database.default.password = password
     ```

5. **Jalankan Server**  
   ```bash
   php spark serve
   ```
   Buka browser dan akses `http://localhost:8080`.

---

## **Endpoint API**  
Berikut adalah beberapa endpoint utama:  

### **Autentikasi**  
- **POST `/authenticate`**: Login pengguna.  
- **GET `/logout`**: Logout pengguna.  
- **POST `/register`**: Registrasi pengguna baru.  

### **Book Management**  
- **GET `/books`**: Menampilkan semua buku.  
- **POST `/books/store`**: Menambah buku baru (hanya admin).  
- **PUT `/books/update/(:num)`**: Mengupdate buku (hanya admin).  
- **DELETE `/books/(:num)`**: Menghapus buku (hanya admin).  

### **Borrow Management**  
- **GET `/borrowers`**: Menampilkan semua peminjaman.  
- **POST `/borrowers`**: Meminjam buku.  
- **POST `/borrowers/return/(:num)`**: Mengembalikan buku.  

### **Dashboard Analytics**  
- **GET `/dashboard/statistics`**: Menampilkan statistik (hanya admin).  

---

## **Contoh Penggunaan**  
### **Login**  
- **Request**:  
  ```bash
  POST /authenticate
  Body: { "username": "admin", "password": "password123" }
  ```
- **Response**:  
  ```json
  {
    "status": "success",
    "message": "Login berhasil",
    "data": {
      "id": 1,
      "username": "admin",
      "role": "admin"
    }
  }
  ```

### **Menambah Buku**  
- **Request**:  
  ```bash
  POST /books/store
  Body: { "title": "Belajar CodeIgniter 4", "author": "John Doe", "category": "Programming" }
  ```
- **Response**:  
  ```json
  {
    "status": "success",
    "message": "Buku berhasil ditambahkan"
  }
  ```

### **Melihat Statistik**  
- **Request**:  
  ```bash
  GET /dashboard/statistics
  ```
- **Response**:  
  ```json
  {
    "total_books": 150,
    "borrowed_books": 45,
    "active_users": 20
  }
  ```

---

## **Kontribusi**  
1. Fork repository ini.  
2. Buat branch baru:  
   ```bash
   git checkout -b fitur-baru
   ```
3. Commit perubahan:  
   ```bash
   git commit -m "Menambahkan fitur baru"
   ```
4. Push ke branch:  
   ```bash
   git push origin fitur-baru
   ```
5. Buat Pull Request.
