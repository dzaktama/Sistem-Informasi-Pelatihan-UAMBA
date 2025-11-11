# SISTEM INFORMASI PELATIHAN UAMBA

<p align="center">
  <strong>Sistem Informasi Pelatihan untuk Universitas AMBA</strong>
  <br>
  Project E-Learning sederhana untuk manajemen materi, progres, dan sertifikat mahasiswa.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" />
</p>

---

## 🚀 Akun Buat Login

Gunakan akun berikut untuk login dan menguji sistem.

| Peran | Email / Username | Password |
| :--- | :--- | :--- |
| 👨‍💼 **Admin** | `admin@amba.ac.id` | `1` |
| 🎓 **User** | `124230024@upnyk.ac.id` | `1` |

*(Catatan: Akun User (mahasiswa) lain dapat ditambahkan melalui panel Admin di "Kelola Pengguna")*

---

## 🛠️ Cara Jalanin di Lokal

1.  **Impor Database**
    * Nyalain XAMPP (Apache & MySQL).
    * Buka **phpMyAdmin**, buat database baru namanya `db_pelatihan_amba`.
    * Impor file `db_pelatihan_amba.sql` ke database itu.

2.  **Koneksi PHP**
    * Buka file `konfigurasi/koneksi_db.php`.
    * Ubah `$user_db` dan `$pass_db` sesuai settingan MySQL masing masing. Biasanya sih `root` dan passwordnya kosong `''`.

3.  **Install Tailwind**
    * Buka terminal di folder proyek (`/sistem_pelatihan_amba/`).
    * Jalanin perintah ini sekali:
    ```bash
    npm install
    ```

4.  **Compile CSS & Jalanin Proyek**
    * Masih di terminal yang sama, jalanin perintah ini. **Jangan tutup terminal ini selama ngerjain**.
    ```bash
    npx tailwindcss -i ./aset/css/input.css -o ./aset/css/output.css --watch
    ```
    * Buka browser dan akses URL ini:
    ```
    http://localhost/sistem_pelatihan_amba/masuk.php
    ```

---

## 📁 Struktur Folder

Struktur file dan folder proyek ini adalah sebagai berikut:

```text
/sistem_pelatihan_amba/
├── admin/
│   ├── index.php
│   ├── kelola_evaluasi.php
│   ├── kelola_materi.php
│   ├── kelola_nilai_sesi.php
│   ├── kelola_pengguna.php
│   ├── kelola_presensi.php
│   ├── kelola_sertifikat.php
│   ├── kelola_sesi.php
│   ├── laporan_akhir.php
│   └── laporan_progres.php
├── aset/
│   ├── css/
│   │   ├── input.css
│   │   └── output.css
│   ├── dokumen_modul/
│   ├── dokumen_sertifikat/
│   ├── img/
│   └── js/
│       └── fungsi_pencarian.js
├── konfigurasi/
│   ├── fungsi_autentikasi.php
│   ├── fungsi_umum.php
│   └── koneksi_db.php
├── mahasiswa/
│   ├── dashboard.php
│   ├── index.php
│   ├── jadwal.php
│   ├── lihat_materi.php
│   ├── materi.php
│   ├── progres_belajar.php
│   └── sertifikat.php
├── node_modules/
├── templat/
│   ├── footer_admin.php
│   ├── footer_mahasiswa.php
│   ├── footer_publik.php
│   ├── header_admin.php
│   ├── header_mahasiswa.php
│   └── header_publik.php
├── buat_hash.php
├── db_pelatihan_amba.sql
├── index.php
├── keluar.php
├── masuk.php
├── package-lock.json
├── package.json
├── README.md
└── tailwind.config.js
