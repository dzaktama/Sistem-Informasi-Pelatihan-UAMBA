-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2025 pada 08.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pelatihan_amba`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluasi`
--

CREATE TABLE `evaluasi` (
  `id_evaluasi` int(11) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `nilai_pretest` decimal(5,2) DEFAULT NULL,
  `nilai_posttest` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `evaluasi`
--

INSERT INTO `evaluasi` (`id_evaluasi`, `id_pendaftaran`, `nilai_pretest`, `nilai_posttest`) VALUES
(1, 1, 100.00, 95.00),
(2, 2, NULL, NULL),
(3, 3, NULL, NULL),
(4, 4, NULL, NULL),
(5, 5, NULL, NULL),
(6, 6, NULL, NULL),
(7, 7, NULL, NULL),
(8, 8, NULL, NULL),
(9, 9, NULL, NULL),
(10, 10, NULL, NULL),
(11, 11, NULL, NULL),
(12, 12, NULL, NULL),
(13, 13, NULL, NULL),
(14, 14, 90.00, 100.00),
(15, 15, NULL, NULL),
(16, 16, NULL, NULL),
(17, 17, NULL, NULL),
(18, 18, NULL, NULL),
(19, 19, NULL, NULL),
(20, 20, NULL, NULL),
(21, 21, NULL, NULL),
(22, 22, NULL, NULL),
(23, 23, NULL, NULL),
(24, 24, NULL, NULL),
(25, 25, NULL, NULL),
(26, 26, NULL, NULL),
(27, 27, NULL, NULL),
(28, 28, NULL, NULL),
(29, 29, NULL, NULL),
(30, 30, NULL, NULL),
(31, 31, NULL, NULL),
(32, 32, NULL, NULL),
(33, 33, NULL, NULL),
(34, 34, NULL, NULL),
(35, 35, NULL, NULL),
(36, 36, NULL, NULL),
(37, 37, NULL, NULL),
(38, 38, NULL, NULL),
(39, 39, NULL, NULL),
(40, 40, NULL, NULL),
(41, 41, NULL, NULL),
(42, 42, NULL, NULL),
(43, 43, NULL, NULL),
(44, 44, NULL, NULL),
(45, 45, NULL, NULL),
(46, 46, NULL, NULL),
(47, 47, NULL, NULL),
(48, 48, NULL, NULL),
(49, 49, NULL, NULL),
(50, 50, NULL, NULL),
(51, 51, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_pelatihan` int(11) DEFAULT NULL,
  `judul_materi` varchar(255) NOT NULL,
  `deskripsi_sesi` text DEFAULT NULL,
  `konten_web` longtext DEFAULT NULL,
  `file_modul` varchar(255) DEFAULT NULL,
  `jadwal_sesi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id_materi`, `id_pelatihan`, `judul_materi`, `deskripsi_sesi`, `konten_web`, `file_modul`, `jadwal_sesi`) VALUES
(91, 1, 'Sesi 1: Pengenalan Algoritma', 'Memahami konsep dasar algoritma, flowchart, dan pseudocode.', '<h1>Sesi 1: Pengenalan Algoritma & Logika</h1>\r\n<p>Selamat datang di materi pertama! Sebelum kita menyentuh kode, kita harus belajar \"berpikir\" seperti programmer. Pemrograman bukan hanya tentang menghafal sintaks, tapi tentang <strong>memecahkan masalah</strong>.</p>\r\n<p><strong>Algoritma</strong> adalah inti dari pemecahan masalah. Ini adalah serangkaian instruksi langkah-demi-langkah yang terurut, logis, dan terbatas yang dirancang untuk menyelesaikan masalah tertentu.</p>\r\n<p>Anggap saja algoritma seperti <strong>resep masakan</strong>. Jika Anda ingin membuat nasi goreng, Anda perlu resep (algoritma) yang jelas.</p>\r\n<hr class=\"my-6\">\r\n<h2>Flowchart (Diagram Alir)</h2>\r\n<p>Flowchart adalah cara visual untuk merepresentasikan algoritma. Ini menggunakan simbol standar untuk menggambarkan alur proses.</p>\r\n<ul>\r\n    <li><strong class=\"text-blue-600\">Terminator (Oval):</strong> Untuk memulai (START) atau mengakhiri (END).</li>\r\n    <li><strong class=\"text-green-600\">Proses (Persegi Panjang):</strong> Untuk operasi atau perhitungan (misal: <code>luas = panjang * lebar</code>).</li>\r\n    <li><strong class=\"text-yellow-600\">Data (Jajar Genjang):</strong> Untuk input atau output (misal: <code>BACA panjang</code>, <code>TULIS luas</code>).</li>\r\n    <li><strong class=\"text-red-600\">Keputusan (Berlian):</strong> Untuk percabangan (<code>IF...THEN...</code>).</li>\r\n</ul>\r\n<hr class=\"my-6\">\r\n<h2>Pseudocode</h2>\r\n<p>Pseudocode (kode semu) adalah cara menulis algoritma menggunakan bahasa yang mirip bahasa manusia, tapi mengikuti struktur bahasa pemrograman. Ini bukan kode sungguhan, tapi membantu kita merancang logika.</p>\r\n<pre><code class=\"language-c\">MULAI\r\n  // Minta input dari pengguna\r\n  BACA nilai_ujian\r\n\r\n  // Proses keputusan\r\n  JIKA nilai_ujian > 75 MAKA\r\n    TULIS \"Selamat, Anda Lulus!\"\r\n  JIKA TIDAK\r\n    TULIS \"Maaf, Anda Gagal. Coba lagi.\"\r\n  AKHIR JIKA\r\n\r\nSELESAI</code></pre>\r\n<p>Di sesi berikutnya, kita akan mulai menerjemahkan logika ini menjadi kode sungguhan.</p>', NULL, '2025-09-16 09:00:00'),
(92, 1, 'Sesi 2: Setup Lingkungan', 'Instalasi Python/C++ dan IDE (VS Code).', '<h1>Sesi 2: Setup Lingkungan</h1>\r\n<p>Untuk memulai, kita perlu \"alat perang\" kita. Dalam pelatihan ini, kita akan fokus pada bahasa <strong>Python</strong> karena mudah dibaca dan sangat populer di industri.</p>\r\n<h2>1. Instalasi Python</h2>\r\n<p>Kunjungi situs web resmi Python di <a href=\"https://www.python.org/downloads/\" target=\"_blank\" class=\"text-blue-600 hover:underline\">python.org</a> dan unduh versi stabil terbaru (misal: Python 3.11+). Saat instalasi, <strong>pastikan Anda mencentang kotak \"Add Python to PATH\"</strong> di bagian bawah jendela installer. Ini sangat penting agar terminal bisa menemukan Python.</p>\r\n<h2>2. Instalasi Visual Studio Code (VS Code)</h2>\r\n<p>Ini adalah editor kode kita. Unduh dari <a href=\"https://code.visualstudio.com/\" target=\"_blank\" class=\"text-blue-600 hover:underline\">code.visualstudio.com</a>. VS Code gratis, ringan, dan sangat canggih.</p>\r\n<p>Setelah VS Code terinstal, buka dan pergi ke tab <strong>Extensions</strong> (logo kotak di samping) dan install ekstensi \"<strong>Python</strong>\" dari Microsoft. Ini akan memberikan *syntax highlighting* dan *linting* (pengecekan error) otomatis.</p>\r\n<h2>3. Program Pertama Anda (\"Hello, World!\")</h2>\r\n<p>Mari kita pastikan semuanya bekerja. Buka VS Code, buat file baru bernama <code>program_pertama.py</code> (ekstensi <code>.py</code> wajib untuk Python), dan ketik baris kode pertama Anda:</p>\r\n<pre><code class=\"language-python\"># Ini adalah baris komentar, diawali tanda pagar\r\n# Komentar tidak akan dieksekusi oleh komputer\r\nprint(\"Hello, AMBA!\")\r\nprint(\"Saya siap belajar pemrograman!\")</code></pre>\r\n<p>Simpan file (<code>Ctrl + S</code>). Untuk menjalankannya, buka terminal di VS Code (<code>Ctrl + `</code>), dan jalankan file dengan mengetik:</p>\r\n<pre><code class=\"language-bash\">python program_pertama.py</code></pre>\r\n<p>Jika Anda melihat \"Hello, AMBA!\" dan \"Saya siap belajar pemrograman!\" muncul di terminal, selamat! Anda sudah resmi menjadi seorang programmer.</p>', NULL, '2025-09-18 09:00:00'),
(93, 1, 'Sesi 3: Variabel & Tipe Data', 'Mempelajari cara menyimpan data (int, string, bool, float).', '<h1>Sesi 3: Variabel & Tipe Data</h1>\r\n<p>Variabel adalah seperti sebuah \"kotak\" di dalam memori komputer yang kita beri nama. Kotak ini bisa kita isi dengan berbagai jenis data.</p>\r\n<p>Di Python, Anda tidak perlu mendeklarasikan tipe data. Anda cukup beri nama dan isi nilainya, Python akan mengetahuinya secara otomatis (Dynamic Typing).</p>\r\n<h2>Tipe Data Dasar (Primitif)</h2>\r\n<p>Setiap data memiliki tipe. Ini adalah yang paling umum:</p>\r\n<ul>\r\n    <li><strong>String (<code>str</code>)</strong>: Teks. Selalu di dalam tanda kutip (<code>\"</code> atau <code>\'\'</code>).\r\n        <br>Contoh: <code>\"Budi\"</code>, <code>\"Jalan Ringroad Utara No.104\"</code>, <code>\'\'2510001\'\'</code></li>\r\n    <li><strong>Integer (<code>int</code>)</strong>: Angka bulat (tanpa koma).\r\n        <br>Contoh: <code>10</code>, <code>-5</code>, <code>0</code></li>\r\n    <li><strong>Float (<code>float</code>)</strong>: Angka desimal (pecahan). Menggunakan titik (<code>.</code>) bukan koma (<code>,</code>).\r\n        <br>Contoh: <code>3.14</code>, <code>-0.5</code>, <code>99.0</code></li>\r\n    <li><strong>Boolean (<code>bool</code>)</strong>: Hanya berisi <code>True</code> atau <code>False</code> (huruf T dan F harus kapital). Digunakan untuk logika.</li>\r\n</ul>\r\n<h2>Contoh Kode</h2>\r\n<p>Coba ketik ini di file <code>.py</code> Anda dan jalankan:</p>\r\n<pre><code class=\"language-python\"># Membuat variabel\r\nnama_mahasiswa = \"Muhammad Dzaky Wiratama\"\r\nnim = 2510001\r\nsudah_lulus_sma = True\r\nipk_target = 3.95\r\n\r\n# Mencetak isi variabel\r\nprint(\"Nama Mahasiswa:\", nama_mahasiswa)\r\nprint(\"NIM:\", nim)\r\n\r\n# Kita juga bisa mengecek tipenya dengan fungsi type()\r\nprint(\"Tipe data dari nama_mahasiswa adalah:\", type(nama_mahasiswa))\r\nprint(\"Tipe data dari nim adalah:\", type(nim))\r\nprint(\"Tipe data dari ipk_target adalah:\", type(ipk_target))</code></pre>', NULL, '2025-09-23 09:00:00'),
(94, 1, 'Sesi 4: Operator Dasar', 'Operator Aritmatika (+, -, *, /) dan Logika (and, or, not).', '<h1>Sesi 4: Operator Dasar</h1>\r\n<p>Operator adalah simbol khusus yang digunakan untuk melakukan operasi pada variabel dan nilai. Mari kita bagi menjadi 3 kategori utama:</p>\r\n<h2>1. Operator Aritmatika</h2>\r\n<p>Digunakan untuk operasi matematika dasar:</p>\r\n<ul>\r\n    <li><code>+</code> (Tambah)</li>\r\n    <li><code>-</code> (Kurang)</li>\r\n    <li><code>*</code> (Kali)</li>\r\n    <li><code>/</code> (Bagi, hasil selalu float, misal: <code>10 / 2</code> hasilnya <code>5.0</code>)</li>\r\n    <li><code>//</code> (Bagi bulat / Floor Division, hasil dibulatkan ke bawah, misal: <code>7 // 3</code> hasilnya <code>2</code>)</li>\r\n    <li><code>%</code> (Modulo / Sisa Bagi, misal: <code>7 % 3</code> hasilnya <code>1</code>)</li>\r\n    <li><code>**</code> (Pangkat, misal: <code>2 ** 3</code> hasilnya <code>8</code>)</li>\r\n</ul>\r\n<pre><code class=\"language-python\">a = 10\r\nb = 3\r\nprint(a / b)  # Output: 3.333...\r\nprint(a // b) # Output: 3\r\nprint(a % b)  # Output: 1</code></pre>\r\n<h2>2. Operator Perbandingan</h2>\r\n<p>Digunakan untuk membandingkan dua nilai. Hasilnya selalu <strong>Boolean</strong> (<code>True</code> atau <code>False</code>).</p>\r\n<ul>\r\n    <li><code>==</code> (Sama dengan)</li>\r\n    <li><code>!=</code> (Tidak sama dengan)</li>\r\n    <li><code>></code> (Lebih besar dari)</li>\r\n    <li><code><</code> (Lebih kecil dari)</li>\r\n    <li><code>>=</code> (Lebih besar atau sama dengan)</li>\r\n    <li><code><=</code> (Lebih kecil atau sama dengan)</li>\r\n</ul>\r\n<pre><code class=\"language-python\">nilai_a = 75\r\nnilai_b = 80\r\nprint(nilai_a == nilai_b) # Output: False\r\nprint(nilai_a < nilai_b)  # Output: True</code></pre>\r\n<h2>3. Operator Logika</h2>\r\n<p>Digunakan untuk menggabungkan dua atau lebih kondisi Boolean.</p>\r\n<ul>\r\n    <li><code>and</code> (Bernilai <code>True</code> hanya jika <strong>kedua</strong> kondisi True)</li>\r\n    <li><code>or</code> (Bernilai <code>True</code> jika <strong>salah satu</strong> kondisi True)</li>\r\n    <li><code>not</code> (Membalik nilai, <code>not True</code> menjadi <code>False</code>)</li>\r\n</ul>\r\n<pre><code class=\"language-python\">punya_ktm = True\r\nsudah_bayar = False\r\n\r\n# Boleh masuk ujian JIKA punya ktm DAN sudah bayar\r\nprint(punya_ktm and sudah_bayar) # Output: False\r\n\r\n# Boleh ambil diskon JIKA punya ktm ATAU member\r\nprint(punya_ktm or sudah_bayar) # Output: True\r\n\r\n# Cek kebalikan\r\nprint(not punya_ktm) # Output: False</code></pre>', NULL, '2025-09-25 09:00:00'),
(95, 1, 'Sesi 5: Percabangan (If-Else)', 'Membuat program mengambil keputusan.', '<h1>Sesi 5: Percabangan (If-Else)</h1>\r\n<p>Program Anda sekarang bisa \"berpikir\" dan mengambil keputusan! Kita menggunakan <code>if</code>, <code>elif</code> (singkatan dari else if), dan <code>else</code> untuk mengontrol alur program.</p>\r\n<h2>Logika dasarnya adalah:</h2>\r\n<p>\"JIKA kondisi A benar, LAKUKAN blok kode A. JIKA TIDAK, JIKA kondisi B benar, LAKUKAN blok kode B. JIKA TIDAK (semua salah), LAKUKAN blok kode C.\"</p>\r\n<p><strong>Penting:</strong> Python menggunakan <strong>indentasi</strong> (spasi/tab yang menjorok ke dalam) untuk menandai blok kode. Kode di dalam <code>if</code>, <code>elif</code>, atau <code>else</code> harus menjorok.</p>\r\n<h2>Contoh 1: If-Else Sederhana</h2>\r\n<pre><code class=\"language-python\">umur = 17\r\n\r\nif umur >= 17:\r\n  print(\"Anda boleh membuat KTP.\")\r\nelse:\r\n  print(\"Anda belum cukup umur.\")</code></pre>\r\n<h2>Contoh 2: If-Elif-Else (Studi Kasus Nilai)</h2>\r\n<p>Ini adalah penggunaan paling umum untuk menentukan grade nilai.</p>\r\n<pre><code class=\"language-python\">nilai = 85\r\n\r\nif nilai >= 90:\r\n  grade = \"A\"\r\nelif nilai >= 80:\r\n  grade = \"B\"\r\nelif nilai >= 70:\r\n  grade = \"C\"\r\nelif nilai >= 60:\r\n  grade = \"D\"\r\nelse:\r\n  grade = \"E\"\r\n\r\nprint(f\"Nilai Anda {nilai}, Grade Anda adalah {grade}\")\r\n# Output: Nilai Anda 85, Grade Anda adalah B</code></pre>\r\n<h2>Contoh 3: Nested If (If Bersarang)</h2>\r\n<p>Anda bisa meletakkan <code>if</code> di dalam <code>if</code> lain.</p>\r\n<pre><code class=\"language-python\">punya_tiket = True\r\nbawa_paspor = False\r\n\r\nif punya_tiket == True:\r\n  print(\"Pengecekan tiket OK.\")\r\n  if bawa_paspor == True:\r\n    print(\"Pengecekan paspor OK. Silakan terbang.\")\r\n  else:\r\n    print(\"Pengecekan paspor GAGAL. Anda tidak boleh terbang.\")\r\nelse:\r\n  print(\"Anda tidak punya tiket.\")</code></pre>', NULL, '2025-09-30 09:00:00'),
(96, 1, 'Sesi 6: Percabangan (Switch-Case)', 'Alternatif percabangan if-else (jika didukung bahasa).', '<h1>Sesi 6: Percabangan (Switch-Case)</h1>\r\n<p>Ini adalah materi yang sedikit unik. Banyak bahasa pemrograman (seperti C++, Java, JavaScript) memiliki struktur <code>switch-case</code> untuk percabangan multi-kondisi yang rapi. Ini berguna jika Anda membandingkan satu variabel dengan banyak nilai spesifik.</p>\r\n<pre><code class=\"language-javascript\">// Contoh di JavaScript\r\nlet hari = 3;\r\nlet namaHari;\r\n\r\nswitch(hari) {\r\n  case 1:\r\n    namaHari = \"Senin\";\r\n    break;\r\n  case 2:\r\n    namaHari = \"Selasa\";\r\n    break;\r\n  case 3:\r\n    namaHari = \"Rabu\";\r\n    break;\r\n  default:\r\n    namaHari = \"Hari tidak valid\";\r\n}\r\n// namaHari sekarang \"Rabu\"</code></pre>\r\n<h2>Bagaimana dengan Python?</h2>\r\n<p>Secara tradisional, Python <strong>tidak memiliki</strong> struktur <code>switch-case</code>. Alasannya, para pengembang Python percaya bahwa konstruksi <code>if-elif-else</code> yang ada sudah cukup jelas dan \"Pythonic\" (sesuai filosofi Python).</p>\r\n<p>Jadi, jika Anda ingin membuat logika seperti di atas, Anda harus menggunakan <code>if-elif-else</code>:</p>\r\n<pre><code class=\"language-python\">hari = 3\r\nnama_hari = \"\"\r\n\r\nif hari == 1:\r\n  nama_hari = \"Senin\"\r\nelif hari == 2:\r\n  nama_hari = \"Selasa\"\r\nelif hari == 3:\r\n  nama_hari = \"Rabu\"\r\nelse:\r\n  nama_hari = \"Hari tidak valid\"\r\n\r\n# nama_hari sekarang \"Rabu\"</code></pre>\r\n<h2>Pembaruan: Python 3.10+ (<code>match-case</code>)</h2>\r\n<p>Sejak versi 3.10, Python memperkenalkan fitur baru bernama <strong>Structural Pattern Matching</strong> (<code>match-case</code>) yang fungsinya sangat mirip dengan <code>switch-case</code>, namun jauh lebih canggih.</p>\r\n<pre><code class=\"language-python\"># Hanya berfungsi di Python 3.10 ke atas!\r\nhari = 3\r\nnama_hari = \"\"\r\n\r\nmatch hari:\r\n  case 1:\r\n    nama_hari = \"Senin\"\r\n  case 2:\r\n    nama_hari = \"Selasa\"\r\n  case 3:\r\n    nama_hari = \"Rabu\"\r\n  case _: # Ini adalah default\r\n    nama_hari = \"Hari tidak valid\"\r\n\r\n# nama_hari sekarang \"Rabu\"</code></pre>\r\n<p><strong>Kesimpulan:</strong> Untuk saat ini, <code>if-elif-else</code> adalah cara standar yang wajib Anda kuasai.</p>', NULL, '2025-10-02 09:00:00'),
(97, 1, 'Sesi 7: Perulangan (For Loop)', 'Looping untuk jumlah iterasi yang diketahui.', '<h1>Sesi 7: Perulangan (For Loop)</h1>\r\n<p>Looping (perulangan) adalah konsep fundamental. Ini memungkinkan kita mengeksekusi blok kode yang sama berulang kali tanpa harus menulisnya berkali-kali.</p>\r\n<h2>For Loop (Perulangan Terhitung)</h2>\r\n<p><code>for</code> loop digunakan saat kita tahu pasti berapa kali kita ingin mengulang. Di Python, <code>for</code> loop biasanya digunakan untuk \"mengiterasi\" (menelusuri) sebuah urutan (seperti list, string, atau range angka).</p>\r\n<h2>Fungsi <code>range()</code></h2>\r\n<p><code>range()</code> adalah fungsi bawaan yang sangat berguna untuk menghasilkan urutan angka. Cara kerjanya:</p>\r\n<ul>\r\n    <li><code>range(stop)</code>: Membuat urutan dari 0 sampai <strong>sebelum</strong> <code>stop</code>.\r\n        <br><code>range(5)</code> → 0, 1, 2, 3, 4</li>\r\n    <li><code>range(start, stop)</code>: Membuat urutan dari <code>start</code> sampai <strong>sebelum</strong> <code>stop</code>.\r\n        <br><code>range(1, 6)</code> → 1, 2, 3, 4, 5</li>\r\n    <li><code>range(start, stop, step)</code>: Membuat urutan dari <code>start</code> sampai <strong>sebelum</strong> <code>stop</code>, dengan lompatan <code>step</code>.\r\n        <br><code>range(0, 10, 2)</code> → 0, 2, 4, 6, 8</li>\r\n</ul>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\"># Contoh 1: Menggunakan range(stop)\r\nprint(\"--- Loop 1 ---\")\r\nfor i in range(5):\r\n  print(f\"Perulangan ke: {i}\")\r\n\r\n# Contoh 2: Menggunakan range(start, stop)\r\nprint(\"\n--- Loop 2 ---\")\r\nfor nomor in range(1, 6):\r\n  print(f\"Nomor urut: {nomor}\")\r\n\r\n# Contoh 3: Menelusuri string\r\nprint(\"\n--- Loop 3 ---\")\r\nfor huruf in \"AMBA\":\r\n  print(huruf)\r\n\r\n# Contoh 4: Menelusuri list (akan dibahas lebih lanjut)\r\nprint(\"\n--- Loop 4 ---\")\r\nbuah = [\"Apel\", \"Jeruk\", \"Mangga\"]\r\nfor b in buah:\r\n  print(f\"Saya suka buah {b}\")</code></pre>', NULL, '2025-10-07 09:00:00'),
(98, 1, 'Sesi 8: Perulangan (While Loop)', 'Looping selama kondisi tertentu benar.', '<h1>Sesi 8: Perulangan (While Loop)</h1>\r\n<p>Berbeda dengan <code>for</code> loop, <code>while</code> loop adalah perulangan tak terhitung. Ini akan terus mengulang <strong>selama</strong> sebuah kondisi bernilai <code>True</code>.</p>\r\n<p><strong>Peringatan Keras:</strong> Anda harus sangat hati-hati dengan <code>while</code> loop. Pastikan ada sesuatu di dalam loop yang pada akhirnya akan membuat kondisi menjadi <code>False</code>. Jika tidak, Anda akan menciptakan <strong>Infinite Loop</strong> (Loop Tak Terbatas) dan program Anda akan macet (harus di-stop paksa)!</p>\r\n<h2>Struktur Dasar</h2>\r\n<pre><code class=\"language-python\"># 1. Tentukan nilai awal untuk kondisi\r\nangka = 1\r\n\r\n# 2. Tulis kondisi di while\r\nwhile angka <= 5:\r\n  # 3. Blok kode yang akan diulang\r\n  print(f\"Angka: {angka}\")\r\n  \r\n  # 4. PERBARUI KONDISI! (Paling penting)\r\n  # Jika baris ini tidak ada, `angka` akan selalu 1 dan loop tidak akan berhenti.\r\n  angka = angka + 1 \r\n\r\nprint(\"Selesai.\")</code></pre>\r\n<h2>Kata Kunci <code>break</code> dan <code>continue</code></h2>\r\n<p>Kita bisa mengontrol alur loop lebih jauh:</p>\r\n<ul>\r\n    <li><code>break</code>: Memaksa loop untuk <strong>berhenti total</strong> saat itu juga, meskipun kondisinya masih <code>True</code>.</li>\r\n    <li><code>continue</code>: Menghentikan iterasi saat ini dan <strong>langsung lompat ke iterasi berikutnya</strong>.</li>\r\n</ul>\r\n<pre><code class=\"language-python\">angka = 0\r\nwhile True: # Ini contoh infinite loop...\r\n  angka = angka + 1\r\n  \r\n  if angka == 3:\r\n    print(\"Angka 3 dilewati!\")\r\n    continue # ...tapi kita skip iterasi ini...\r\n\r\n  if angka > 5:\r\n    print(\"Angka sudah lebih dari 5, berhenti.\")\r\n    break # ...dan kita hentikan paksa di sini.\r\n    \r\n  print(f\"Angka sekarang: {angka}\")\r\n\r\n# Output:\r\n# Angka sekarang: 1\r\n# Angka sekarang: 2\r\n# Angka 3 dilewati!\r\n# Angka sekarang: 4\r\n# Angka sekarang: 5\r\n# Angka sudah lebih dari 5, berhenti.</code></pre>', NULL, '2025-10-09 09:00:00'),
(99, 1, 'Sesi 9: Studi Kasus 1', 'Membuat program kalkulator sederhana.', '<h1>Sesi 9: Studi Kasus 1 - Kalkulator Sederhana</h1>\r\n<p>Saatnya menggabungkan semua yang telah kita pelajari: <strong>Variabel, Tipe Data, Operator, Input, dan IF-ELSE</strong>.</p>\r\n<p>Kita akan membuat program yang meminta 2 angka dan 1 operator dari pengguna, lalu memberikan hasilnya. Kita juga akan menambahkan <code>try-except</code> (dari Sesi 22) agar program tidak *crash* jika inputnya salah.</p>\r\n<h2>Fungsi <code>input()</code></h2>\r\n<p>Kita menggunakan <code>input(\"Teks prompt: \")</code> untuk meminta masukan dari pengguna. <strong>Catatan:</strong> Semua masukan dari <code>input()</code> akan dianggap sebagai <strong>String</strong>. Kita perlu mengubahnya ke <code>float</code> (angka desimal) agar bisa dihitung.</p>\r\n<h2>Kode Lengkap</h2>\r\n<pre><code class=\"language-python\">print(\"--- Kalkulator Sederhana AMBA ---\")\r\n\r\ntry:\r\n  # 1. Minta input dan konversi ke float\r\n  angka1 = float(input(\"Masukkan angka pertama: \"))\r\n  operator = input(\"Masukkan operator (+, -, *, /): \")\r\n  angka2 = float(input(\"Masukkan angka kedua: \"))\r\n\r\n  hasil = 0\r\n  \r\n  # 2. Logika percabangan\r\n  if operator == \"+\":\r\n    hasil = angka1 + angka2\r\n  elif operator == \"-\":\r\n    hasil = angka1 - angka2\r\n  elif operator == \"*\":\r\n    hasil = angka1 * angka2\r\n  elif operator == \"/\":\r\n    # Cek pembagian nol\r\n    if angka2 == 0:\r\n      print(\"Error: Tidak bisa membagi dengan nol!\")\r\n      hasil = \"Tidak terdefinisi\"\r\n    else:\r\n      hasil = angka1 / angka2\r\n  else:\r\n    print(\"Error: Operator tidak dikenal!\")\r\n    hasil = \"Tidak valid\"\r\n\r\n  # 3. Tampilkan hasil\r\n  print(f\"Hasil dari {angka1} {operator} {angka2} = {hasil}\")\r\n\r\nexcept ValueError:\r\n  # 4. Tangkap error jika input bukan angka\r\n  print(\"Error: Input yang Anda masukkan (angka pertama atau kedua) bukan angka yang valid!\")\r\nexcept Exception as e:\r\n  # 5. Tangkap semua error lain\r\n  print(f\"Terjadi error tak terduga: {e}\")\r\n\r\nprint(\"--- Program Selesai ---\")</code></pre>', NULL, '2025-10-14 09:00:00'),
(100, 1, 'Sesi 10: Array (List)', 'Menyimpan banyak data dalam satu variabel.', '<h1>Sesi 10: Array (List)</h1>\r\n<p>Bagaimana jika kita ingin menyimpan 50 nama mahasiswa? Tentu tidak efisien jika membuat <code>nama1</code>, <code>nama2</code>, <code>nama3</code>... <code>nama50</code>.</p>\r\n<p>Di sinilah <strong>List</strong> (atau Array di bahasa lain) berguna. List adalah variabel \"super\" yang bisa menampung banyak data sekaligus, dan datanya terurut. Di Python, List dibuat menggunakan kurung siku <code>[]</code>.</p>\r\n<h2>Fitur List:</h2>\r\n<ul>\r\n    <li><strong>Terurut (Ordered):</strong> Data disimpan sesuai urutan saat dimasukkan.</li>\r\n    <li><strong>Dapat Diubah (Mutable):</strong> Isinya bisa diubah, ditambah, atau dihapus.</li>\r\n    <li><strong>Bisa Campuran:</strong> Bisa berisi berbagai tipe data (walau tidak disarankan, misal: <code>[1, \"Halo\", True]</code>).</li>\r\n    <li><strong>Indexing:</strong> Datanya bisa diakses menggunakan indeks (angka).</li>\r\n</ul>\r\n<h2>Indexing (Sangat Penting!)</h2>\r\n<p>Indexing di pemrograman hampir selalu dimulai dari <strong>nol (0)</strong>.</p>\r\n<pre><code class=\"language-python\"># Membuat sebuah List\r\ndaftar_buah = [\"Apel\", \"Jeruk\", \"Mangga\", \"Durian\"]\r\n# Indeks:       0        1        2         3\r\n\r\n# Mengakses data (Positif, dari depan)\r\nprint(\"Buah pertama (indeks 0):\", daftar_buah[0])  # Output: Apel\r\nprint(\"Buah ketiga (indeks 2):\", daftar_buah[2])  # Output: Mangga\r\n\r\n# Mengakses data (Negatif, dari belakang)\r\nprint(\"Buah terakhir (indeks -1):\", daftar_buah[-1]) # Output: Durian\r\nprint(\"Buah kedua dari akhir (indeks -2):\", daftar_buah[-2]) # Output: Mangga\r\n\r\n# Ini akan error \"IndexError\" karena indeks 4 tidak ada\r\n# print(daftar_buah[4])</code></pre>', NULL, '2025-10-16 09:00:00'),
(101, 1, 'Sesi 11: Operasi Array', 'Menambah, menghapus, dan mengubah data di array.', '<h1>Sesi 11: Operasi Array (List)</h1>\r\n<p>Karena List bersifat *mutable* (bisa diubah), ada banyak hal yang bisa kita lakukan. Ini adalah beberapa metode (fungsi bawaan) List yang paling sering digunakan.</p>\r\n<h2>Metode List yang Paling Umum:</h2>\r\n<ul>\r\n    <li><code>.append(data)</code>: Menambah <code>data</code> baru di <strong>akhir</strong> list.</li>\r\n    <li><code>.insert(indeks, data)</code>: Menyisipkan <code>data</code> di <code>indeks</code> tertentu tanpa menghapus.</li>\r\n    <li><code>.pop(indeks)</code>: Menghapus data di <code>indeks</code> tertentu. Jika dikosongkan (<code>.pop()</code>), akan menghapus data terakhir.</li>\r\n    <li><code>.remove(data)</code>: Menghapus <code>data</code> pertama yang cocok (berdasarkan nilainya, bukan indeks).</li>\r\n    <li><code>.sort()</code>: Mengurutkan list (A-Z atau 0-9).</li>\r\n    <li><code>len(list)</code>: (Bukan metode, tapi fungsi) Untuk mendapatkan jumlah total data di dalam list.</li>\r\n</ul>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\">data_mahasiswa = [\"Budi\", \"Siti\", \"Eko\"]\r\nprint(f\"Data awal: {data_mahasiswa}, Jumlah: {len(data_mahasiswa)}\")\r\n\r\n# Menambah data\r\ndata_mahasiswa.append(\"Dewi\")\r\nprint(f\"Data setelah .append(\'Dewi\'): {data_mahasiswa}\")\r\n\r\n# Menyisipkan data\r\ndata_mahasiswa.insert(1, \"Asep\") # Sisipkan di indeks 1\r\nprint(f\"Data setelah .insert(1, \'Asep\'): {data_mahasiswa}\")\r\n\r\n# Menghapus data (Eko ada di indeks 3)\r\ndata_mahasiswa.pop(3)\r\nprint(f\"Data setelah .pop(3): {data_mahasiswa}\")\r\n\r\n# Menghapus data (berdasarkan nama)\r\ndata_mahasiswa.remove(\"Budi\")\r\nprint(f\"Data setelah .remove(\'Budi\'): {data_mahasiswa}\")\r\n\r\n# Mengurutkan\r\ndata_mahasiswa.sort()\r\nprint(f\"Data setelah .sort(): {data_mahasiswa}\")</code></pre>', NULL, '2025-10-21 09:00:00'),
(102, 1, 'Sesi 12: Fungsi (Function)', 'Membuat blok kode yang dapat digunakan kembali.', '<h1>Sesi 12: Fungsi (Function)</h1>\r\n<p>Fungsi adalah blok kode yang kita beri nama, yang hanya akan berjalan ketika kita panggil. Ini adalah salah satu konsep terpenting dalam pemrograman.</p>\r\n<h2>Prinsip DRY (Don\'t Repeat Yourself)</h2>\r\n<p>Jangan Ulangi Dirimu. Jika Anda menemukan diri Anda menyalin-tempel blok kode yang sama di beberapa tempat, itu adalah tanda bahwa Anda membutuhkan sebuah fungsi.</p>\r\n<p>Bayangkan Anda harus menghitung luas persegi panjang di 10 tempat berbeda. Tanpa fungsi, Anda harus menulis <code>luas = panjang * lebar</code> 10 kali. Jika rumusnya salah (misal: harusnya <code>* 0.5</code>), Anda harus ganti di 10 tempat. Dengan fungsi, Anda cukup ganti di 1 tempat.</p>\r\n<h2>Struktur Fungsi</h2>\r\n<p>Dibuat menggunakan kata kunci <code>def</code> (define).</p>\r\n<pre><code class=\"language-python\"># 1. Mendefinisikan Fungsi\r\n# Blok kode di dalam fungsi tidak akan berjalan\r\n# sampai fungsi itu dipanggil.\r\ndef cetak_pembatas():\r\n  print(\"====================================\")\r\n\r\n# 2. Memanggil Fungsi\r\nprint(\"Selamat Datang di Program AMBA\")\r\ncetak_pembatas() # Memanggil fungsi\r\n\r\nprint(\"Silakan pilih menu:\")\r\nprint(\"1. Login\")\r\nprint(\"2. Keluar\")\r\ncetak_pembatas() # Memanggil fungsi lagi</code></pre>', NULL, '2025-10-23 09:00:00'),
(103, 1, 'Sesi 13: Parameter & Return', 'Memberi input ke fungsi dan mendapatkan output.', '<h1>Sesi 13: Parameter & Return</h1>\r\n<p>Fungsi bisa menjadi jauh lebih kuat jika kita bisa memberinya \"input\" (disebut <strong>Parameter</strong>) dan memintanya memberikan \"output\" (disebut <strong>Return Value</strong>).</p>\r\n<h2>Parameter (Input)</h2>\r\n<p>Parameter adalah variabel yang kita definisikan di dalam kurung <code>()</code> saat membuat fungsi. Ini adalah data yang dibutuhkan fungsi untuk bekerja. Saat memanggil fungsi, data yang kita kirim disebut <strong>Argumen</strong>.</p>\r\n<h2>Return (Output)</h2>\r\n<p>Kata kunci <code>return</code> digunakan untuk mengembalikan nilai dari fungsi. Setelah <code>return</code> dieksekusi, fungsi akan berhenti.</p>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\"># `nama` adalah parameter\r\n# `umur` adalah parameter dengan nilai default\r\ndef sapa(nama, umur=18):\r\n  print(f\"Halo, {nama}! Umur Anda {umur} tahun.\")\r\n\r\n# \"Budi\" adalah argumen\r\nsapa(\"Budi\") # Akan menggunakan umur default 18\r\nsapa(\"Siti\", 21) # Mengirim argumen untuk umur\r\n\r\n# `panjang` dan `lebar` adalah parameter\r\ndef hitung_luas_persegi(panjang, lebar):\r\n  print(f\"Menghitung luas dari {panjang} x {lebar}\")\r\n  if panjang <= 0 or lebar <= 0:\r\n    return \"Input tidak valid\" # Fungsi berhenti di sini\r\n    \r\n  luas = panjang * lebar\r\n  return luas # Mengembalikan hasil perhitungan\r\n\r\n# Kita \"tangkap\" nilai return ke dalam variabel\r\nluas_ruang_1 = hitung_luas_persegi(10, 5)\r\nluas_ruang_2 = hitung_luas_persegi(7, 3)\r\n\r\nprint(\"Luas Ruang 1:\", luas_ruang_1) # Output: 50\r\nprint(\"Luas Ruang 2:\", luas_ruang_2) # Output: 21\r\nprint(\"Hasil Coba Error:\", hitung_luas_persegi(10, -2)) # Output: Input tidak valid</code></pre>', NULL, '2025-10-28 09:00:00'),
(104, 1, 'Sesi 14: Scope Variabel', 'Perbedaan variabel global dan lokal.', '<h1>Sesi 14: Scope Variabel</h1>\r\n<p>Scope (Ruang Lingkup) adalah konsep penting yang menentukan di mana saja sebuah variabel bisa diakses.</p>\r\n<h2>1. Variabel Lokal (Local Scope)</h2>\r\n<p>Variabel yang dibuat di dalam sebuah fungsi. Variabel ini <strong>hanya hidup dan hanya bisa diakses di dalam fungsi itu saja</strong>. Setelah fungsi selesai, variabel itu \"hancur\" dari memori.</p>\r\n<h2>2. Variabel Global (Global Scope)</h2>\r\n<p>Variabel yang dibuat di luar fungsi (di bagian utama kode). Variabel ini bisa <strong>diakses (dibaca)</strong> dari mana saja, baik di luar maupun di dalam fungsi.</p>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\">nama_global = \"Admin AMBA\" # Ini variabel global\r\n\r\ndef fungsi_satu():\r\n  nama_lokal = \"Budi\" # Ini variabel lokal\r\n  print(\"Dari fungsi_satu (lokal):\", nama_lokal)\r\n  print(\"Dari fungsi_satu (global):\", nama_global) # Bisa membaca global\r\n\r\nfungsi_satu()\r\n\r\nprint(\"Dari luar fungsi (global):\", nama_global)\r\n# Baris di bawah ini akan ERROR, karena `nama_lokal` tidak dikenal di luar fungsi\r\n# print(\"Dari luar fungsi (lokal):\", nama_lokal) </code></pre>\r\n<h2>Kata Kunci <code>global</code></h2>\r\n<p>Bagaimana jika kita ingin <strong>mengubah</strong> variabel global dari dalam fungsi? Kita harus menggunakan kata kunci <code>global</code>.</p>\r\n<pre><code class=\"language-python\">skor = 100 # Global\r\n\r\ndef kurangi_skor():\r\n  global skor # Beritahu Python kita mau ubah var global\r\n  skor = skor - 10\r\n  print(f\"Skor di dalam fungsi: {skor}\")\r\n\r\nkurangi_skor()\r\nprint(f\"Skor di luar fungsi: {skor}\") # Output: 90</code></pre>', NULL, '2025-10-30 09:00:00'),
(105, 1, 'Sesi 15: Studi Kasus 2', 'Membuat program CRUD sederhana (versi 1).', '<h1>Sesi 15: Studi Kasus 2 - CRUD Sederhana (v1)</h1>\r\n<p>Saatnya menggabungkan <strong>List, Loop, dan Fungsi</strong> untuk membuat program manajemen kontak sederhana. CRUD adalah singkatan dari <strong>Create, Read, Update, Delete</strong>.</p>\r\n<p>Kita akan menggunakan satu List global untuk menyimpan data.</p>\r\n<h2>Struktur Kode</h2>\r\n<pre><code class=\"language-python\"># Database sementara kita\r\nkontak = [\"Budi (08123)\", \"Siti (08111)\"]\r\n\r\n# Fungsi untuk READ\r\ndef tampilkan_kontak():\r\n  print(\"\n--- Daftar Kontak ---\")\r\n  if len(kontak) == 0:\r\n    print(\"Daftar kontak masih kosong.\")\r\n  else:\r\n    # Enumerate untuk mendapatkan indeks dan nilai\r\n    for i, k in enumerate(kontak):\r\n      print(f\"{i}. {k}\")\r\n  print(\"---------------------\")\r\n\r\n# Fungsi untuk CREATE\r\ndef tambah_kontak():\r\n  nama = input(\"Masukkan nama: \")\r\n  nomor = input(\"Masukkan nomor: \")\r\n  kontak.append(f\"{nama} ({nomor})\")\r\n  print(f\"Kontak \'\'{nama}\'\' berhasil ditambahkan.\")\r\n\r\n# Fungsi untuk UPDATE\r\ndef ubah_kontak():\r\n  tampilkan_kontak()\r\n  try:\r\n    indeks = int(input(\"Masukkan nomor indeks yang ingin diubah: \"))\r\n    if 0 <= indeks < len(kontak):\r\n      nama = input(\"Masukkan nama baru: \")\r\n      nomor = input(\"Masukkan nomor baru: \")\r\n      kontak[indeks] = f\"{nama} ({nomor})\"\r\n      print(\"Kontak berhasil diubah.\")\r\n    else:\r\n      print(\"Indeks tidak valid.\")\r\n  except ValueError:\r\n    print(\"Input harus angka.\")\r\n\r\n# Fungsi untuk DELETE\r\ndef hapus_kontak():\r\n  tampilkan_kontak()\r\n  try:\r\n    indeks = int(input(\"Masukkan nomor indeks yang ingin dihapus: \"))\r\n    if 0 <= indeks < len(kontak):\r\n      nama_terhapus = kontak.pop(indeks)\r\n      print(f\"Kontak \'\'{nama_terhapus}\'\' berhasil dihapus.\")\r\n    else:\r\n      print(\"Indeks tidak valid.\")\r\n  except ValueError:\r\n    print(\"Input harus angka.\")\r\n\r\n\r\n# Program utama (Loop tak terbatas untuk menu)\r\nwhile True:\r\n  print(\"\nMenu Manajemen Kontak:\")\r\n  print(\"1. Tampilkan Semua Kontak (Read)\")\r\n  print(\"2. Tambah Kontak Baru (Create)\")\r\n  print(\"3. Ubah Kontak (Update)\")\r\n  print(\"4. Hapus Kontak (Delete)\")\r\n  print(\"5. Keluar\")\r\n  pilihan = input(\"Pilih menu (1/2/3/4/5): \")\r\n\r\n  if pilihan == \"1\":\r\n    tampilkan_kontak()\r\n  elif pilihan == \"2\":\r\n    tambah_kontak()\r\n  elif pilihan == \"3\":\r\n    ubah_kontak()\r\n  elif pilihan == \"4\":\r\n    hapus_kontak()\r\n  elif pilihan == \"5\":\r\n    print(\"Terima kasih. Program ditutup.\")\r\n    break\r\n  else:\r\n    print(\"Menu tidak valid. Silakan pilih 1-5.\")\r\n</code></pre>', NULL, '2025-11-04 09:00:00'),
(106, 1, 'Sesi 16: Pengenalan OOP', 'Konsep Object-Oriented Programming.', '<h1>Sesi 16: Pengenalan OOP</h1>\r\n<p>Selamat datang di Pemrograman Berorientasi Objek (Object-Oriented Programming/OOP). Ini adalah sebuah paradigma atau cara berpikir dalam menulis kode. OOP sangat dominan di industri perangkat lunak skala besar.</p>\r\n<p>Selama ini kita menulis kode secara <strong>prosedural</strong> (urutan langkah-langkah/fungsi). Dalam OOP, kita memodelkan dunia nyata ke dalam \"Objek\".</p>\r\n<p>Alih-alih memikirkan \"langkah apa dulu?\", kita memikirkan \"ada benda apa saja?\".</p>\r\n<p>Bayangkan sebuah sistem akademik. Kita tidak lagi berpikir \"langkah 1: input nama, langkah 2: input nilai...\". Kita berpikir:</p>\r\n<ul>\r\n    <li>Ada objek <strong>Mahasiswa</strong>.\r\n        <ul>\r\n            <li>Mahasiswa punya <strong>data/properti</strong> (disebut <strong>Atribut</strong>): <code>nama</code>, <code>nim</code>, <code>ipk</code>.</li>\r\n            <li>Mahasiswa punya <strong>perilaku/fungsi</strong> (disebut <strong>Method</strong>): <code>ambil_krs()</code>, <code>cetak_khs()</code>, <code>lulus()</code>.</li>\r\n        </ul>\r\n    </li>\r\n    <li>Ada objek <strong>Dosen</strong>.\r\n        <ul>\r\n            <li>Atribut: <code>nama</code>, <code>nidn</code>.</li>\r\n            <li>Method: <code>input_nilai()</code>, <code>buka_kelas()</code>.</li>\r\n        </ul>\r\n    </li>\r\n</ul>\r\n<p>OOP membungkus data dan fungsi yang saling berhubungan ini ke dalam satu kesatuan yang disebut <strong>Objek</strong>.</p>\r\n<h2>Mengapa OOP?</h2>\r\n<ul>\r\n    <li><strong>Encapsulation (Pembungkusan):</strong> Data dan method disatukan, menyembunyikan kerumitan internal.</li>\r\n    <li><strong>Reusable (Dapat Digunakan Ulang):</strong> Kita bisa membuat banyak \"Mahasiswa\" dari satu cetakan (Class).</li>\r\n    <li><strong>Maintainable (Mudah Dikelola):</strong> Jauh lebih mudah dikelola untuk proyek skala besar. Jika ada bug di KHS, kita tahu harus memperbaiki method <code>cetak_khs()</code> di Class <code>Mahasiswa</code>.</li>\r\n</ul>', NULL, '2025-11-06 09:00:00'),
(107, 1, 'Sesi 17: Class & Object', 'Membuat blueprint (class) dan instansinya (object).', '<h1>Sesi 17: Class & Object</h1>\r\n<p>Untuk membuat Objek (misal: mahasiswa Budi, mahasiswa Siti), kita perlu \"cetakannya\" terlebih dahulu. Cetakan ini disebut <strong>Class</strong>.</p>\r\n<p><strong>Class</strong> adalah <em>blueprint</em> atau cetakan. (Misal: Class <code>Mahasiswa</code>)</p>\r\n<p><strong>Object</strong> adalah hasil jadi (instansiasi) dari cetakan tersebut. (Misal: <code>budi</code>, <code>siti</code>, yang merupakan objek dari Class <code>Mahasiswa</code>)</p>\r\n<h2>Membuat Class</h2>\r\n<p>Kita menggunakan kata kunci <code>class</code>. Sesuai konvensi, nama Class diawali huruf kapital (PascalCase).</p>\r\n<pre><code class=\"language-python\"># 1. Membuat Cetakan (Class)\n\n# Ini adalah blueprint untuk semua mahasiswa\r\nclass Mahasiswa:\r\n  # Ini adalah Atribut Class (akan sama untuk semua objek)\r\n  jurusan = \"Informatika\"\r\n  kampus = \"Universitas AMBA\"\r\n\r\n# 2. Membuat Objek (Hasil Cetakan)\r\n# Ini disebut \"instansiasi\"\r\nbudi = Mahasiswa()\r\nsiti = Mahasiswa()\r\n\r\n# 3. Mengakses Atribut Objek\r\nprint(f\"Budi kuliah di {budi.kampus} jurusan {budi.jurusan}\")\r\nprint(f\"Siti kuliah di {siti.kampus} jurusan {siti.jurusan}\")\r\n\r\n# Atribut objek bisa diubah\r\n# (Ini akan membuat atribut instan baru untuk siti)\r\nsiti.jurusan = \"Sistem Informasi\" \r\nprint(f\"Budi tetap di jurusan {budi.jurusan}\")\r\nprint(f\"Siti pindah ke jurusan {siti.jurusan}\")</code></pre>\r\n<p>Masalahnya: Bagaimana jika kita ingin setiap mahasiswa punya nama dan NIM yang berbeda saat dibuat? Jawabannya ada di sesi berikutnya: Constructor.</p>', NULL, '2025-11-11 09:00:00'),
(108, 1, 'Sesi 18: Constructor (__init__)', 'Fungsi yang otomatis dipanggil saat object dibuat.', '<h1>Sesi 18: Constructor (__init__)</h1>\r\n<p>Pada sesi sebelumnya, semua mahasiswa yang kita buat tidak punya nama/NIM. Kita harus mengaturnya manual. Ini tidak efisien.</p>\r\n<p>Di sinilah <strong>Constructor</strong> berperan. Constructor adalah *method* khusus yang akan otomatis dipanggil <strong>tepat saat</strong> sebuah objek baru dibuat. Ini adalah tempat yang sempurna untuk mengatur atribut unik setiap objek (seperti nama dan NIM).</p>\r\n<p>Di Python, constructor dinamai <code>__init__()</code> (dua garis bawah sebelum dan sesudah).</p>\r\n<h2>Parameter <code>self</code></h2>\r\n<p><code>self</code> adalah parameter wajib di setiap *method* dalam *class*. Ini merujuk pada objek itu sendiri (misal: <code>budi</code>, <code>siti</code>) yang sedang dibuat atau sedang memanggil *method*.</p>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\">class Mahasiswa:\r\n  kampus = \"Universitas AMBA\" # Atribut Class\r\n\r\n  # Ini adalah Constructor\r\n  def __init__(self, input_nama, input_nim):\r\n    # `self.nama` dan `self.nim` adalah Atribut Instan (unik per objek)\r\n    self.nama = input_nama\r\n    self.nim = input_nim\r\n    print(f\"Objek Mahasiswa baru dibuat: {self.nama} ({self.nim})\")\r\n\r\n# Sekarang kita BISA dan WAJIB memasukkan parameter saat membuat objek\r\nbudi = Mahasiswa(\"Budi Santoso\", \"2510001\")\r\nsiti = Mahasiswa(\"Siti Aminah\", \"2510002\")\r\n\r\n# Sekarang setiap objek punya data uniknya sendiri\r\nprint(f\"Nama: {budi.nama}, Kampus: {budi.kampus}\")\r\nprint(f\"Nama: {siti.nama}, Kampus: {siti.kampus}\")</code></pre>', NULL, '2025-11-13 09:00:00'),
(109, 1, 'Sesi 19: Method', 'Fungsi yang ada di dalam Class.', '<h1>Sesi 19: Method</h1>\r\n<p><strong>Method</strong> adalah fungsi yang berada di dalam sebuah Class. Method mendefinisikan perilaku atau apa yang bisa dilakukan oleh sebuah objek (contoh: <code>mahasiswa.ambil_krs()</code>, <code>mobil.gas()</code>).</p>\r\n<p>Seperti <code>__init__</code>, parameter pertama dari sebuah method harus <code>self</code>, yang merujuk pada objek itu sendiri. Ini memungkinkan *method* untuk mengakses atau mengubah atribut lain dari objek tersebut (seperti <code>self.nama</code> atau <code>self.kecepatan</code>).</p>\r\n<h2>Contoh Kode</h2>\r\n<p>Mari kita tambahkan perilaku pada Class <code>Mahasiswa</code> kita.</p>\r\n<pre><code class=\"language-python\">class Mahasiswa:\r\n  def __init__(self, nama, nim):\r\n    self.nama = nama\r\n    self.nim = nim\r\n    self.sks_diambil = 0 # Atribut instan baru\r\n\r\n  # Ini adalah method\r\n  def ambil_krs(self, jumlah_sks):\r\n    # Method ini bisa mengakses self.nama dan mengubah self.sks_diambil\r\n    self.sks_diambil = self.sks_diambil + jumlah_sks\r\n    print(f\"Halo {self.nama}, Anda berhasil mengambil {jumlah_sks} SKS.\")\r\n    print(f\"Total SKS Anda semester ini: {self.sks_diambil} SKS.\")\r\n\r\n  # Ini method lain\r\n  def cetak_ktm(self):\r\n    print(\"--- KARTU TANDA MAHASISWA ---\")\r\n    print(f\" Nama: {self.nama}\")\r\n    print(f\" NIM : {self.nim}\")\r\n    print(\"-------------------------------\")\r\n\r\n# Membuat objek\r\nbudi = Mahasiswa(\"Budi Santoso\", \"2510001\")\r\nsiti = Mahasiswa(\"Siti Aminah\", \"2510002\")\r\n\r\n# Memanggil method dari objek\r\nbudi.cetak_ktm()\r\nsiti.ambil_krs(18)\r\nsiti.ambil_krs(3) # Menambah SKS lagi</code></pre>', NULL, '2025-11-18 09:00:00'),
(110, 1, 'Sesi 20: Inheritance (Pewarisan)', 'Class turunan yang mewarisi sifat induknya.', '<h1>Sesi 20: Inheritance (Pewarisan)</h1>\r\n<p>Inheritance adalah salah satu pilar utama OOP. Ini memungkinkan kita membuat sebuah Class baru (disebut <strong>Child Class</strong> atau Subclass) yang <strong>mewarisi</strong> semua atribut dan method dari Class yang sudah ada (disebut <strong>Parent Class</strong> atau Superclass).</p>\r\n<p>Ini sangat berguna untuk prinsip DRY (Don\'t Repeat Yourself). Jika <code>Dosen</code> dan <code>Mahasiswa</code> sama-sama punya <code>nama</code> dan <code>umur</code>, kita bisa buat Parent Class <code>Orang</code>, dan keduanya bisa mewarisi dari <code>Orang</code>.</p>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\"># 1. Parent Class (Umum)\r\nclass Orang:\r\n  def __init__(self, nama, umur):\r\n    self.nama = nama\r\n    self.umur = umur\r\n\r\n  def perkenalan(self):\r\n    print(f\"Halo, nama saya {self.nama} dan umur saya {self.umur} tahun.\")\r\n\r\n# 2. Child Class (Spesifik)\r\n# Mewarisi dari `Orang`\r\nclass Mahasiswa(Orang):\r\n  def __init__(self, nama, umur, nim):\r\n    # Memanggil constructor Parent (`Orang`) untuk mengisi self.nama dan self.umur\r\n    super().__init__(nama, umur)\r\n    # Menambah atribut baru khusus Mahasiswa\r\n    self.nim = nim\r\n\r\n  # Method baru khusus Mahasiswa\r\n  def belajar(self):\r\n    print(f\"{self.nama} dengan NIM {self.nim} sedang belajar.\")\r\n\r\n# --- Menggunakan Class ---\r\nbudi = Mahasiswa(\"Budi\", 20, \"2510001\")\r\n\r\n# Budi bisa memanggil method `perkenalan()` (dari Parent)\r\nbudi.perkenalan()\r\n\r\n# Budi juga bisa memanggil method `belajar()` (dari Child)\r\nbudi.belajar()</code></pre>', NULL, '2025-11-20 09:00:00'),
(111, 1, 'Sesi 21: Studi Kasus 3', 'Membuat program data inventaris menggunakan OOP.', '<h1>Sesi 21: Studi Kasus 3 - Inventaris Gudang (OOP)</h1>\r\n<p>Saatnya mempraktikkan OOP. Kita akan membuat program untuk mengelola inventaris barang di gudang. Ini adalah cara yang jauh lebih bersih daripada menggunakan List atau Dictionary biasa.</p>\r\n<p>Kita akan membuat <strong>Class Barang</strong> untuk menyimpan info tiap barang, dan <strong>Class Gudang</strong> untuk mengelola (CRUD) semua objek <code>Barang</code> tersebut.</p>\r\n<h2>Kode Lengkap</h2>\r\n<pre><code class=\"language-python\"># 1. Class Cetakan untuk Data (Blueprint)\r\nclass Barang:\r\n  def __init__(self, kode, nama, stok):\r\n    self.kode = kode\r\n    self.nama = nama\r\n    self.stok = stok\r\n\r\n  # Method untuk menampilkan info diri sendiri\r\n  def tampilkan_info(self):\r\n    print(f\"| {self.kode:<10} | {self.nama:<20} | {self.stok:<5} |\")\r\n\r\n# 2. Class untuk Mengelola (Controller)\r\nclass Gudang:\r\n  def __init__(self):\r\n    # Gudang punya list untuk menyimpan OBJEK Barang\r\n    self.daftar_barang = []\r\n    print(\"Gudang AMBA berhasil dibuat.\")\r\n\r\n  def tambah_barang(self):\r\n    print(\"\n--- Tambah Barang Baru ---\")\r\n    kode = input(\"Masukkan Kode Barang: \")\r\n    nama = input(\"Masukkan Nama Barang: \")\r\n    stok = int(input(\"Masukkan Stok Awal: \"))\r\n    \r\n    # Buat objek baru dari cetakan Barang\r\n    barang_baru = Barang(kode, nama, stok)\r\n    \r\n    # Masukkan objek itu ke list milik gudang\r\n    self.daftar_barang.append(barang_baru)\r\n    print(f\"Barang \'\'{nama}\'\' berhasil ditambah!\")\r\n\r\n  def lihat_semua_barang(self):\r\n    print(\"\n--- Daftar Stok Barang di Gudang ---\")\r\n    print(\"==========================================\")\r\n    print(f\"| {\'\'KODE\'\':<10} | {\'\'NAMA BARANG\'\':<20} | {\'\'STOK\'\':<5} |\")\r\n    print(\"==========================================\")\r\n    for barang in self.daftar_barang:\r\n      barang.tampilkan_info() # Panggil method dari objek Barang\r\n    print(\"------------------------------------------\")\r\n\r\n# --- Program Utama ---\r\ngudang_utama = Gudang()\r\n\r\n# Menu (disederhanakan)\r\ngudang_utama.tambah_barang() # Tambah barang 1\r\ngudang_utama.tambah_barang() # Tambah barang 2\r\ngudang_utama.lihat_semua_barang() # Lihat hasilnya</code></pre>', NULL, '2025-11-25 09:00:00'),
(112, 1, 'Sesi 22: Error Handling (Try-Except)', 'Menangani error agar program tidak crash.', '<h1>Sesi 22: Error Handling (Try-Except)</h1>\r\n<p>Program kita pasti akan menghadapi error. Misal, kita minta input angka (<code>int(input())</code>), tapi pengguna mengetik huruf (misal: \"lima\"). Atau kita mencoba membagi angka dengan nol.</p>\r\n<p>Jika tidak ditangani, error ini akan membuat program kita <strong>CRASH</strong> (berhenti total) dengan pesan error merah.</p>\r\n<p><strong>Error Handling</strong> adalah cara kita \"menangkap\" error tersebut agar program tetap berjalan dengan baik dan memberi pesan yang lebih ramah kepada pengguna.</p>\r\n<h2>Struktur <code>try-except</code></h2>\r\n<p>Kita gunakan blok <code>try</code> untuk membungkus kode yang berpotensi error. Jika error terjadi di dalam <code>try</code>, Python akan melompat ke blok <code>except</code> yang sesuai.</p>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\">try:\r\n  # Blok kode yang berpotensi error\r\n  angka_pembilang = 10\r\n  angka_penyebut = int(input(\"Masukkan angka pembagi (selain 0): \"))\r\n  \r\n  hasil_bagi = angka_pembilang / angka_penyebut\r\n  print(f\"Hasil bagi 10 dengan {angka_penyebut} adalah {hasil_bagi}\")\r\n\r\nexcept ValueError:\r\n  # Ini hanya akan berjalan jika int(input()) gagal\r\n  # (misal: pengguna mengetik \"dua\")\r\n  print(\"ERROR: Anda tidak memasukkan angka!\")\r\n\r\nexcept ZeroDivisionError:\r\n  # Ini hanya akan berjalan jika pengguna memasukkan angka 0\r\n  print(\"ERROR: Angka pembagi tidak boleh nol!\")\r\n\r\nexcept Exception as e:\r\n  # Menangkap semua jenis error lain yang tidak terduga\r\n  print(f\"Terjadi error tak terduga: {e}\")\r\n\r\nfinally:\r\n  # Blok ini akan SELALU dieksekusi,\r\n  # baik ada error maupun tidak.\r\n  # Berguna untuk \"membersihkan\" sesuatu.\r\n  print(\"\nBlok \'\'finally\'\' selalu berjalan. Program selesai.\")</code></pre>', NULL, '2025-11-27 09:00:00'),
(113, 1, 'Sesi 23: File Handling (Membaca)', 'Membaca data dari file .txt.', '<h1>Sesi 23: File Handling (Membaca)</h1>\r\n<p>Data kita di variabel, list, atau objek akan hilang begitu program ditutup. Untuk menyimpannya secara permanen (persistent), kita harus menuliskannya ke dalam file (misal: <code>.txt</code>, <code>.csv</code>, <code>.json</code>).</p>\r\n<p>Kita akan belajar cara membaca data dari file teks.</p>\r\n<h2>Fungsi <code>open()</code> & Mode</h2>\r\n<p>Kita menggunakan <code>open(\"namafile\", \"mode\")</code>.</p>\r\n<ul>\r\n    <li><strong>Mode \"r\" (Read):</strong> Mode default. Untuk membaca file. Akan error jika file tidak ada.</li>\r\n</ul>\r\n<p><strong>Cara Terbaik: <code>with open()</code></strong>\r\n<br>Menggunakan <code>with open(...) as f:</code> adalah cara yang paling disarankan. Ini disebut \"Context Manager\". Kelebihannya, file akan <strong>otomatis ditutup</strong> (<code>f.close()</code>) bahkan jika terjadi error di dalamnya.</p>\r\n<h2>Contoh Kode (Membaca)</h2>\r\n<p>Buat file <code>data.txt</code> di folder yang sama dengan file <code>.py</code> Anda. Isi dengan beberapa baris teks, misal:</p>\r\n<pre><code class=\"language-text\">Baris pertama\r\nBaris kedua\r\nIni baris ketiga</code></pre>\r\n<p>Sekarang, jalankan kode Python ini:</p>\r\n<pre><code class=\"language-python\">file_target = \"data.txt\"\r\n\r\ntry:\r\n  with open(file_target, \"r\") as f:\r\n    \r\n    # Cara 1: Membaca seluruh isi file jadi 1 string besar\r\n    # isi_file = f.read()\r\n    # print(isi_file)\r\n\r\n    # Cara 2: Membaca file jadi List (per baris)\r\n    # .read().splitlines() akan membaca semua\r\n    # dan menghapus karakter enter (\n)\r\n    daftar_baris = f.read().splitlines()\r\n    print(\"Isi file sebagai List:\")\r\n    print(daftar_baris)\r\n\r\n    print(\"\nMembaca ulang per baris:\")\r\n    for baris in daftar_baris:\r\n        print(f\"--> {baris}\")\r\n        \r\nexcept FileNotFoundError:\r\n  print(f\"ERROR: File \'\'{file_target}\'\' tidak ditemukan!\")\r\nexcept Exception as e:\r\n  print(f\"Terjadi error: {e}\")</code></pre>', NULL, '2025-12-02 09:00:00'),
(114, 1, 'Sesi 24: File Handling (Menulis)', 'Menulis atau menimpa data ke file .txt.', '<h1>Sesi 24: File Handling (Menulis)</h1>\r\n<p>Sekarang kita akan belajar cara menyimpan data ke dalam file.</p>\r\n<h2>Mode Menulis</h2>\r\n<ul>\r\n    <li><strong>Mode \"w\" (Write):</strong> Mode Menulis.\r\n        <br><strong>SANGAT BERBAHAYA!</strong> Mode ini akan <strong>menghapus total (menimpa)</strong> isi file lama jika file sudah ada. Jika file belum ada, file baru akan dibuat.</li>\r\n    <li><strong>Mode \"a\" (Append):</strong> Mode Menambah.\r\n        <br>Mode ini akan <strong>menambahkan data baru</strong> di baris paling akhir file. Isi file lama akan tetap aman. Jika file belum ada, file baru akan dibuat.</li>\r\n</ul>\r\n<h2>Contoh Kode (Menulis & Menambah)</h2>\r\n<pre><code class=\"language-python\">nama_file = \"log_aktivitas.txt\"\r\n\r\n# 1. Mode \"w\" (Write) - Hati-hati!\r\ntry:\r\n  with open(nama_file, \"w\") as f:\r\n    f.write(\"Log dimulai...\n\")\r\n    f.write(\"Menulis baris pertama.\n\")\r\n  print(f\"File \'\'{nama_file}\'\' berhasil DITULIS (ditimpa).\")\r\nexcept Exception as e:\r\n  print(f\"Error saat menulis: {e}\")\r\n\r\n\r\n# 2. Mode \"a\" (Append) - Aman\r\ntry:\r\n  with open(nama_file, \"a\") as f:\r\n    f.write(\"Menambah baris baru dengan mode Append.\n\")\r\n    f.write(\"Aktivitas lain tercatat.\n\")\r\n  print(f\"File \'\'{nama_file}\'\' berhasil DITAMBAH.\")\r\nexcept Exception as e:\r\n  print(f\"Error saat menambah: {e}\")\r\n\r\n# Coba buka file log_aktivitas.txt di folder Anda.\r\n# Jalankan skrip ini beberapa kali dan lihat perbedaannya.\r\n# Jika Anda ubah mode \"a\" jadi \"w\", log Anda akan selalu ter-reset.</code></pre>', NULL, '2025-12-04 09:00:00');
INSERT INTO `materi` (`id_materi`, `id_pelatihan`, `judul_materi`, `deskripsi_sesi`, `konten_web`, `file_modul`, `jadwal_sesi`) VALUES
(115, 1, 'Sesi 25: Studi Kasus 4', 'Menyimpan data CRUD ke file .txt.', '<h1>Sesi 25: Studi Kasus 4 - CRUD ke File TXT</h1>\r\n<p>Ini adalah peningkatan besar dari Studi Kasus 2. Kita akan membuat program CRUD (data kontak) yang datanya disimpan secara permanen ke <code>kontak.txt</code>.</p>\r\n<p>Kita akan gabungkan <strong>Fungsi, List, Looping, dan File Handling</strong>.</p>\r\n<h2>Logika Utama:</h2>\r\n<ol>\r\n    <li><strong>Saat program dimulai (LOAD):</strong> Baca data dari <code>kontak.txt</code> dan masukkan ke List global <code>kontak_list</code>.</li>\r\n    <li><strong>Saat program berjalan (CRUD):</strong> Semua operasi (tambah, ubah, hapus) hanya memanipulasi <code>kontak_list</code> di memori.</li>\r\n    <li><strong>Saat program ditutup (SAVE):</strong> Tulis seluruh data dari <code>kontak_list</code> ke <code>kontak.txt</code> (timpa file lama).</li>\r\n</ol>\r\n<pre><code class=\"language-python\">FILE_KONTAK = \"kontak.txt\"\r\n\r\n# Fungsi untuk LOAD data dari file ke list\r\ndef muat_dari_file():\r\n  try:\r\n    with open(FILE_KONTAK, \"r\") as f:\r\n      kontak = f.read().splitlines()\r\n      return kontak\r\n  except FileNotFoundError:\r\n    return [] # Kembalikan list kosong jika file belum ada\r\n\r\n# Fungsi untuk SAVE data dari list ke file\r\ndef simpan_ke_file(daftar_kontak):\r\n  with open(FILE_KONTAK, \"w\") as f:\r\n    for kontak in daftar_kontak:\r\n      f.write(kontak + \"\n\") # Tulis tiap kontak sebagai baris baru\r\n  print(\"Data berhasil disimpan ke file.\")\r\n\r\n# --- Program Utama ---\r\nkontak_list = muat_dari_file() # 1. Load data saat start\r\n\r\nprint(f\"Berhasil memuat {len(kontak_list)} data kontak.\")\r\n\r\nwhile True:\r\n  # ... (Tampilkan menu: 1. Tambah, 2. Tampil, 3. Keluar) ...\r\n  # (Ini adalah versi sederhana, Anda bisa gabungkan dengan kode CRUD dari Sesi 15)\r\n  print(\"\nMenu: 1. Tambah, 2. Tampil, 3. Keluar & Simpan\")\r\n  pilihan = input(\"Pilih: \")\r\n  \r\n  if pilihan == \"1\":\r\n    nama = input(\"Nama: \")\r\n    kontak_list.append(nama)\r\n    print(f\"\'\'{nama}\'\' ditambah ke memori.\")\r\n    \r\n  elif pilihan == \"2\":\r\n    print(\"--- Daftar Kontak (di memori) ---\")\r\n    for k in kontak_list:\r\n      print(k)\r\n      \r\n  elif pilihan == \"3\":\r\n    simpan_ke_file(kontak_list) # 2. Save data saat mau keluar\r\n    print(\"Terima kasih.\")\r\n    break\r\n</code></pre>', NULL, '2025-12-09 09:00:00'),
(116, 1, 'Sesi 26: Pengenalan Git & GitHub', 'Dasar-dasar Version Control System.', '<h1>Sesi 26: Pengenalan Git & GitHub</h1>\r\n<p>Selamat, Anda sudah bisa membuat program. Sekarang, bagaimana jika Anda bekerja dalam tim? Atau jika program Anda error dan Anda ingin \"mundur\" ke versi 3 hari lalu?</p>\r\n<p>Di sinilah <strong>Version Control System (VCS)</strong> berperan.</p>\r\n<h2>Apa itu Git?</h2>\r\n<p><strong>Git</strong> adalah VCS terdistribusi yang paling populer. Ini adalah *software* di komputer lokal Anda yang melacak setiap perubahan pada setiap file di proyek Anda. Ini seperti \"mesin waktu\" untuk kode Anda. Anda bisa mengambil \"snapshot\" (disebut <strong>commit</strong>) dari proyek Anda kapanpun.</p>\r\n<h2>Apa itu GitHub?</h2>\r\n<p><strong>GitHub</strong> (juga ada GitLab, Bitbucket) adalah *layanan hosting* berbasis web untuk menyimpan repositori (proyek) Git Anda secara *online*. Ini adalah \"penyimpanan cloud\" untuk kode Anda.</p>\r\n<p><strong>Git != GitHub.</strong> Git adalah alatnya, GitHub adalah tempat menyimpannya secara online.</p>\r\n<h2>Mengapa Penting?</h2>\r\n<ul>\r\n    <li><strong>Kolaborasi Tim:</strong> Beberapa orang bisa mengerjakan file yang sama. Git membantu menggabungkan (merge) perubahan tersebut.</li>\r\n    <li><strong>Backup & Histori:</strong> Kode Anda aman di cloud. Anda bisa melihat siapa mengubah apa, kapan, dan mengapa.</li>\r\n    <li><strong>Branching (Pencabangan):</strong> Ini fitur terbaiknya. Anda bisa mengerjakan fitur baru (misal: \"fitur_login\") di \"cabang\" (branch) terpisah tanpa merusak kode utama (branch \"main\" atau \"master\"). Jika fitur baru sudah stabil, baru digabungkan (merge).</li>\r\n</ul>', NULL, '2025-12-11 09:00:00'),
(117, 1, 'Sesi 27: Perintah Dasar Git', 'git init, add, commit, push, pull, clone.', '<h1>Sesi 27: Perintah Dasar Git</h1>\r\n<p>Untuk menggunakan Git, kita menggunakan perintah di terminal. Instal Git terlebih dahulu dari <a href=\"https://git-scm.com/downloads\" target=\"_blank\" class=\"text-blue-600 hover:underline\">git-scm.com</a>. Setelah instal, buka terminal dan cek versi:</p>\r\n<pre><code class=\"language-bash\">git --version</code></pre>\r\n<h2>Alur Kerja Dasar (Lokal)</h2>\r\n<p>Ini adalah siklus kerja Anda sehari-hari di komputer Anda.</p>\r\n<ol>\r\n    <li><strong><code>git init</code></strong>: (Hanya sekali per proyek) Membuat repositori Git baru di folder proyek Anda. Ini akan membuat folder tersembunyi <code>.git</code>.</li>\r\n    <li><strong>(Anda membuat/mengedit file, misal <code>kalkulator.py</code>)</strong></li>\r\n    <li><strong><code>git status</code></strong>: (Opsional) Melihat file apa saja yang sudah Anda ubah (ditandai \"modified\" - merah).</li>\r\n    <li><strong><code>git add .</code></strong>: Menandai semua file yang berubah untuk \"disiapkan\" ke *commit* berikutnya. Ini disebut \"Staging Area\". (Seperti memasukkan barang ke kardus).</li>\r\n    <li><strong><code>git commit -m \"Pesan commit yang jelas\"</code></strong>: Menyimpan \"snapshot\" perubahan secara permanen ke histori Git lokal Anda. (Seperti menyegel dan melabeli kardus).\r\n    <br>Contoh pesan: <code>git commit -m \"Membuat fitur kalkulator dasar\"</code></li>\r\n</ol>\r\n<h2>Alur Kerja dengan GitHub (Kolaborasi)</h2>\r\n<p>Ini adalah cara Anda sinkronisasi antara lokal (laptop) dan remote (GitHub).</p>\r\n<ol>\r\n    <li><strong><code>git clone [url_repo_github.git]</code></strong>: (Hanya sekali) Mengunduh proyek dari GitHub ke laptop Anda.</li>\r\n    <li><strong><code>git pull</code></strong>: Mengambil perubahan terbaru dari GitHub (wajib dilakukan setiap pagi sebelum mulai kerja).</li>\r\n    <li><strong>(Anda kerja: edit file, `git add .`, `git commit ...`)</strong></li>\r\n    <li><strong><code>git push</code></strong>: Mengirim hasil *commit* Anda dari laptop ke GitHub (biasa dilakukan di sore hari atau setelah fitur selesai).</li>\r\n</ol>', NULL, '2025-12-16 09:00:00'),
(118, 1, 'Sesi 28: Debugging', 'Teknik mencari dan memperbaiki bug dalam kode.', '<h1>Sesi 28: Debugging</h1>\r\n<p>Setiap programmer pasti bertemu <strong>Bug</strong> (error dalam program). <strong>Debugging</strong> adalah seni mencari dan memperbaiki bug tersebut.</p>\r\n<h2>Jenis Bug</h2>\r\n<ol>\r\n    <li><strong>Syntax Error:</strong> Salah ketik. Paling mudah diperbaiki karena program tidak akan jalan sama sekali. (Misal: <code>prnt(\"Halo\")</code> bukannya <code>print(\"Halo\")</code>).</li>\r\n    <li><strong>Runtime Error:</strong> Error yang terjadi saat program berjalan. (Misal: <code>ValueError</code>, <code>ZeroDivisionError</code>, <code>IndexError</code>). Program akan *crash*.</li>\r\n    <li><strong>Logical Error:</strong> Bug paling jahat. Program berjalan normal, tidak *crash*, tapi hasilnya salah. (Misal: seharusnya <code>a + b</code>, tapi Anda tulis <code>a - b</code>).</li>\r\n</ol>\r\n<h2>Teknik Debugging Sederhana</h2>\r\n<h3>1. \"Print Debugging\" (Cara Klasik)</h3>\r\n<p>Cara paling cepat dan umum. Letakkan <code>print()</code> di berbagai tempat di kode Anda untuk melacak alur program dan nilai variabel.</p>\r\n<pre><code class=\"language-python\">def hitung_luas(p, l):\r\n  print(f\"DEBUG: Masuk fungsi, nilai p={p}, nilai l={l}\")\r\n  if p <= 0:\r\n    print(\"DEBUG: p bernilai nol atau negatif!\")\r\n  hasil = p * l\r\n  print(f\"DEBUG: Hasil perhitungan={hasil}\")\r\n  return hasil\r\n\r\nhitung_luas(10, -5)</code></pre>\r\n<h3>2. Rubber Duck Debugging</h3>\r\n<p>Teknik psikologis. Jelaskan kode Anda baris demi baris kepada \"seseorang\" (bisa teman, atau bahkan boneka bebek karet). Seringkali, saat menjelaskan, Anda akan menemukan letak kesalahan logika Anda sendiri.</p>\r\n<h3>3. Gunakan Debugger Bawaan IDE (Cara Profesional)</h3>\r\n<p>VS Code punya debugger canggih. Anda bisa memasang \"Breakpoint\" (titik berhenti) di kode Anda, menjalankan program dalam mode debug, dan program akan berhenti tepat di situ, memungkinkan Anda memeriksa semua nilai variabel saat itu juga tanpa perlu <code>print()</code>.</p>', NULL, '2025-12-18 09:00:00'),
(119, 1, 'Sesi 29: Struktur Data (Dict)', 'Pengenalan Dictionary (Key-Value Pair).', '<h1>Sesi 29: Struktur Data (Dictionary)</h1>\r\n<p>Selain List/Array, ada struktur data super penting lainnya: <strong>Dictionary</strong> (Dict).</p>\r\n<p>Perbedaan utamanya adalah cara akses:</p>\r\n<ul>\r\n    <li><strong>List</strong>: diakses menggunakan <strong>indeks angka</strong> (0, 1, 2, ...). <code>list[0]</code></li>\r\n    <li><strong>Dictionary</strong>: diakses menggunakan <strong>Key (Kunci)</strong>. <code>dict[\"kunci\"]</code></li>\r\n</ul>\r\n<p>Dict adalah kumpulan pasangan <strong>Key-Value</strong> (Kunci-Nilai). Dibuat dengan kurung kurawal <code>{}</code>. Ini sangat mirip dengan format JSON.</p>\r\n<h2>Kapan Menggunakan Dict?</h2>\r\n<p>Saat data Anda memiliki label. Daripada <code>mahasiswa = [\"Budi\", \"2510001\", \"Informatika\"]</code> (di mana kita harus hafal <code>[0]</code> itu nama, <code>[1]</code> itu nim), kita lebih baik pakai Dict.</p>\r\n<h2>Contoh Kode</h2>\r\n<pre><code class=\"language-python\"># Membuat Dictionary\r\nmahasiswa = {\r\n  \"nama\": \"Budi Santoso\",\r\n  \"nim\": \"2510001\",\r\n  \"lulus\": True,\r\n  \"mata_kuliah\": [\"Algo\", \"Web\", \"Data\"]\r\n}\r\n\r\n# Mengakses data (menggunakan Key, bukan indeks)\r\nprint(\"Nama mahasiswa:\", mahasiswa[\"nama\"])\r\nprint(\"NIM mahasiswa:\", mahasiswa[\"nim\"])\r\nprint(\"Mata kuliah pertama:\", mahasiswa[\"mata_kuliah\"][0]) # List di dalam Dict\r\n\r\n# Mengubah data\r\nmahasiswa[\"lulus\"] = False\r\nprint(\"Status lulus:\", mahasiswa[\"lulus\"])\r\n\r\n# Menambah data baru\r\nmahasiswa[\"jurusan\"] = \"Informatika\"\r\nprint(mahasiswa)\r\n\r\n# Cara aman mengakses data (pakai .get())\r\n# Jika key tidak ada, tidak akan error, tapi hasilnya None\r\nprint(\"Alamat:\", mahasiswa.get(\"alamat\"))\r\nprint(\"Nama (aman):\", mahasiswa.get(\"nama\"))</code></pre>\r\n<p><strong>Studi Kasus:</strong> Alih-alih <code>kontak_list</code> (Sesi 25) berisi string, akan jauh lebih baik jika isinya adalah <strong>List of Dictionaries</strong>. Contoh: <code>[ {\"nama\": \"Budi\", \"telp\": \"0812\"}, {\"nama\": \"Siti\", \"telp\": \"0811\"} ]</code></p>', NULL, '2025-12-23 09:00:00'),
(120, 1, 'Sesi 30: Review & Post-test', 'Review total dan evaluasi akhir (Post-test).', '<h1>Sesi 30: Review & Post-test</h1>\r\n<p>Luar biasa! Anda telah mencapai sesi terakhir dari pelatihan dasar ini. Mari kita tinjau kembali apa yang telah kita pelajari.</p>\r\n<h2>Review Pilar Pembelajaran</h2>\r\n<ol>\r\n    <li><strong>Dasar (Sesi 1-9):</strong> Dari Algoritma, kita belajar sintaks dasar (Variabel, Tipe Data, Operator), kemudian kita belajar alur logika (If-Else) dan efisiensi (Looping For/While). Diakhiri dengan studi kasus membuat program interaktif.</li>\r\n    <li><strong>Struktur Data (Sesi 10-11, 29):</strong> Kita belajar cara menyimpan data secara terstruktur. Menggunakan <strong>List</strong> (untuk data terurut, diakses via indeks <code>[0]</code>) dan <strong>Dictionary</strong> (untuk data berlabel, diakses via key <code>[\"nama\"]</code>).</li>\r\n    <li><strong>Fungsi (Sesi 12-14):</strong> Kita belajar membuat kode yang modular dan <em>reusable</em> (prinsip DRY) menggunakan <code>def</code>. Kita belajar memberi input (Parameter) dan mendapat output (<code>return</code>), serta memahami Scope (Global vs Lokal).</li>\r\n    <li><strong>OOP (Sesi 16-21):</strong> Kita belajar paradigma baru yang membungkus data (Atribut) dan perilaku (Method) ke dalam satu <strong>Class</strong> (cetakan) untuk membuat <strong>Object</strong> (hasil jadi). Kita juga belajar Constructor (<code>__init__</code>) dan Inheritance (Pewarisan).</li>\r\n    <li><strong>Tools & Teknik (Sesi 22-28):</strong> Kita belajar cara membuat program yang \"dewasa\" dengan menangani error (<code>try-except</code>), menyimpan data permanen (<code>File Handling</code>), berkolaborasi (<code>Git/GitHub</code>), dan mencari kesalahan (<code>Debugging</code>).</li>\r\n</ol>\r\n<h2>Evaluasi Akhir (Post-test)</h2>\r\n<p>Sekarang, silakan kerjakan soal Post-test yang akan diberikan oleh instruktur di laboratorium. Hasil dari tes ini akan digunakan untuk mengukur sejauh mana pemahaman Anda meningkat dibandingkan Pre-test di awal pelatihan.</p>\r\n<h2>Apa Selanjutnya?</h2>\r\n<p>Perjalanan Anda baru saja dimulai. Dasar Anda sudah kuat. Langkah selanjutnya adalah memilih spesialisasi:</p>\r\n<ul>\r\n    <li>Suka data? → Pelajari <strong>Pandas, NumPy, SQL</strong>.</li>\r\n    <li>Suka membuat web? → Pelajari <strong>HTML/CSS/JS</strong> dan framework web (<strong>Flask/Django</strong> untuk Python).</li>\r\n    <li>Suka membuat aplikasi mobile? → Pelajari <strong>Flutter</strong> atau <strong>Kotlin</strong>.</li>\r\n</ul>\r\n<p>Teruslah berlatih, buat proyek-proyek kecil pribadi, dan jangan pernah takut untuk gagal. <strong>Selamat datang di dunia pemrograman!</strong></p>', NULL, '2025-12-25 09:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_sesi`
--

CREATE TABLE `nilai_sesi` (
  `id_nilai_sesi` int(11) NOT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `catatan_instruktur` text DEFAULT NULL,
  `tanggal_penilaian` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_sesi`
--

INSERT INTO `nilai_sesi` (`id_nilai_sesi`, `id_materi`, `id_pengguna`, `nilai`, `catatan_instruktur`, `tanggal_penilaian`) VALUES
(1, 97, 15, NULL, '', '2025-11-09 23:36:32'),
(2, 97, 7, NULL, '', '2025-11-09 23:36:32'),
(3, 97, 46, NULL, '', '2025-11-09 23:36:32'),
(4, 97, 26, NULL, '', '2025-11-09 23:36:32'),
(5, 97, 10, NULL, '', '2025-11-09 23:36:32'),
(6, 97, 43, NULL, '', '2025-11-09 23:36:32'),
(7, 97, 28, NULL, '', '2025-11-09 23:36:32'),
(8, 97, 34, NULL, '', '2025-11-09 23:36:32'),
(9, 97, 3, NULL, '', '2025-11-09 23:36:32'),
(10, 97, 27, NULL, '', '2025-11-09 23:36:32'),
(11, 97, 6, NULL, '', '2025-11-09 23:36:32'),
(12, 97, 21, NULL, '', '2025-11-09 23:36:32'),
(13, 97, 18, NULL, '', '2025-11-09 23:36:32'),
(14, 97, 42, NULL, '', '2025-11-09 23:36:32'),
(15, 97, 50, NULL, '', '2025-11-09 23:36:32'),
(16, 97, 5, NULL, '', '2025-11-09 23:36:32'),
(17, 97, 31, NULL, '', '2025-11-09 23:36:32'),
(18, 97, 24, NULL, '', '2025-11-09 23:36:32'),
(19, 97, 36, NULL, '', '2025-11-09 23:36:32'),
(20, 97, 16, NULL, '', '2025-11-09 23:36:32'),
(21, 97, 38, NULL, '', '2025-11-09 23:36:32'),
(22, 97, 47, NULL, '', '2025-11-09 23:36:32'),
(23, 97, 13, NULL, '', '2025-11-09 23:36:32'),
(24, 97, 48, NULL, '', '2025-11-09 23:36:32'),
(25, 97, 30, NULL, '', '2025-11-09 23:36:32'),
(26, 97, 9, NULL, '', '2025-11-09 23:36:32'),
(27, 97, 44, NULL, '', '2025-11-09 23:36:32'),
(28, 97, 39, NULL, '', '2025-11-09 23:36:32'),
(29, 97, 12, NULL, '', '2025-11-09 23:36:32'),
(30, 97, 14, NULL, '', '2025-11-09 23:36:32'),
(31, 97, 23, NULL, '', '2025-11-09 23:36:32'),
(32, 97, 2, 98.00, 'mantapppp jekk', '2025-11-09 23:36:32'),
(33, 97, 33, NULL, '', '2025-11-09 23:36:32'),
(34, 97, 45, NULL, '', '2025-11-09 23:36:32'),
(35, 97, 25, NULL, '', '2025-11-09 23:36:32'),
(36, 97, 52, NULL, '', '2025-11-09 23:36:32'),
(37, 97, 40, NULL, '', '2025-11-09 23:36:32'),
(38, 97, 20, NULL, '', '2025-11-09 23:36:32'),
(39, 97, 8, NULL, '', '2025-11-09 23:36:32'),
(40, 97, 17, NULL, '', '2025-11-09 23:36:32'),
(41, 97, 29, NULL, '', '2025-11-09 23:36:32'),
(42, 97, 49, NULL, '', '2025-11-09 23:36:32'),
(43, 97, 4, NULL, '', '2025-11-09 23:36:32'),
(44, 97, 22, NULL, '', '2025-11-09 23:36:32'),
(45, 97, 35, NULL, '', '2025-11-09 23:36:32'),
(46, 97, 32, NULL, '', '2025-11-09 23:36:32'),
(47, 97, 51, NULL, '', '2025-11-09 23:36:32'),
(48, 97, 41, NULL, '', '2025-11-09 23:36:32'),
(49, 97, 19, NULL, '', '2025-11-09 23:36:32'),
(50, 97, 11, NULL, '', '2025-11-09 23:36:32'),
(51, 97, 37, NULL, '', '2025-11-09 23:36:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelatihan`
--

CREATE TABLE `pelatihan` (
  `id_pelatihan` int(11) NOT NULL,
  `nama_pelatihan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelatihan`
--

INSERT INTO `pelatihan` (`id_pelatihan`, `nama_pelatihan`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`) VALUES
(1, 'Pelatihan Dasar Pemrograman 2025', 'Pelatihan untuk mahasiswa baru Fakultas Sistem Informasi dan Networking Global', '2025-09-15', '2025-12-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran_pelatihan`
--

CREATE TABLE `pendaftaran_pelatihan` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_pelatihan` int(11) DEFAULT NULL,
  `status_kelulusan` enum('terdaftar','lulus','tidak_lulus') DEFAULT 'terdaftar',
  `file_sertifikat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran_pelatihan`
--

INSERT INTO `pendaftaran_pelatihan` (`id_pendaftaran`, `id_pengguna`, `id_pelatihan`, `status_kelulusan`, `file_sertifikat`) VALUES
(1, 2, 1, 'lulus', '69109e33f0c9e-Sertifikat Staff Ekraf BEM FTI_Muhammad Dzaky Wiratama.pdf'),
(2, 3, 1, 'terdaftar', NULL),
(3, 4, 1, 'terdaftar', NULL),
(4, 5, 1, 'terdaftar', NULL),
(5, 6, 1, 'terdaftar', NULL),
(6, 7, 1, 'terdaftar', NULL),
(7, 8, 1, 'terdaftar', NULL),
(8, 9, 1, 'terdaftar', NULL),
(9, 10, 1, 'terdaftar', NULL),
(10, 11, 1, 'terdaftar', NULL),
(11, 12, 1, 'terdaftar', NULL),
(12, 13, 1, 'terdaftar', NULL),
(13, 14, 1, 'terdaftar', NULL),
(14, 15, 1, 'lulus', NULL),
(15, 16, 1, 'terdaftar', NULL),
(16, 17, 1, 'terdaftar', NULL),
(17, 18, 1, 'terdaftar', NULL),
(18, 19, 1, 'terdaftar', NULL),
(19, 20, 1, 'terdaftar', NULL),
(20, 21, 1, 'terdaftar', NULL),
(21, 22, 1, 'terdaftar', NULL),
(22, 23, 1, 'terdaftar', NULL),
(23, 24, 1, 'terdaftar', NULL),
(24, 25, 1, 'terdaftar', NULL),
(25, 26, 1, 'terdaftar', NULL),
(26, 27, 1, 'terdaftar', NULL),
(27, 28, 1, 'terdaftar', NULL),
(28, 29, 1, 'terdaftar', NULL),
(29, 30, 1, 'terdaftar', NULL),
(30, 31, 1, 'terdaftar', NULL),
(31, 32, 1, 'terdaftar', NULL),
(32, 33, 1, 'terdaftar', NULL),
(33, 34, 1, 'terdaftar', NULL),
(34, 35, 1, 'terdaftar', NULL),
(35, 36, 1, 'terdaftar', NULL),
(36, 37, 1, 'terdaftar', NULL),
(37, 38, 1, 'terdaftar', NULL),
(38, 39, 1, 'terdaftar', NULL),
(39, 40, 1, 'terdaftar', NULL),
(40, 41, 1, 'terdaftar', NULL),
(41, 42, 1, 'terdaftar', NULL),
(42, 43, 1, 'terdaftar', NULL),
(43, 44, 1, 'terdaftar', NULL),
(44, 45, 1, 'terdaftar', NULL),
(45, 46, 1, 'terdaftar', NULL),
(46, 47, 1, 'terdaftar', NULL),
(47, 48, 1, 'terdaftar', NULL),
(48, 49, 1, 'terdaftar', NULL),
(49, 50, 1, 'terdaftar', NULL),
(50, 51, 1, 'terdaftar', NULL),
(51, 52, 1, 'terdaftar', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `nomor_induk` varchar(20) DEFAULT NULL,
  `peran` enum('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `email`, `kata_sandi`, `nomor_induk`, `peran`) VALUES
(1, 'Admin Utama', 'admin@amba.ac.id', '1', 'ADMIN-001', 'admin'),
(2, 'Muhammad Dzaky Wiratama', '124230024@student.upnyk.ac.id', '1', '124230024', 'mahasiswa'),
(3, 'Budi Santoso', '2510001@amba.ac.id', 'siswa123', '2510001', 'mahasiswa'),
(4, 'Siti Aminah', '2510002@amba.ac.id', 'siswa123', '2510002', 'mahasiswa'),
(5, 'Eko Prasetyo', '2510003@amba.ac.id', 'siswa123', '2510003', 'mahasiswa'),
(6, 'Dewi Lestari', '2510004@amba.ac.id', 'siswa123', '2510004', 'mahasiswa'),
(7, 'Agus Setiawan', '2510005@amba.ac.id', 'siswa123', '2510005', 'mahasiswa'),
(8, 'Rina Wati', '2510006@amba.ac.id', 'siswa123', '2510006', 'mahasiswa'),
(9, 'Joko Susilo', '2510007@amba.ac.id', 'siswa123', '2510007', 'mahasiswa'),
(10, 'Anita Sari', '2510008@amba.ac.id', 'siswa123', '2510008', 'mahasiswa'),
(11, 'Yusuf Ibrahim', '2510009@amba.ac.id', 'siswa123', '2510009', 'mahasiswa'),
(12, 'Linda Puspita', '2510010@amba.ac.id', 'siswa123', '2510010', 'mahasiswa'),
(13, 'Hendra Wijaya', '2510011@amba.ac.id', 'siswa123', '2510011', 'mahasiswa'),
(14, 'Maya Indah', '2510012@amba.ac.id', 'siswa123', '2510012', 'mahasiswa'),
(15, 'Agung Nugroho', '2510013@amba.ac.id', 'siswa123', '2510013', 'mahasiswa'),
(16, 'Fitri Handayani', '2510014@amba.ac.id', 'siswa123', '2510014', 'mahasiswa'),
(17, 'Rizky Ramadhan', '2510015@amba.ac.id', 'siswa123', '2510015', 'mahasiswa'),
(18, 'Dika Permana', '2510016@amba.ac.id', 'siswa123', '2510016', 'mahasiswa'),
(19, 'Wulan Sari', '2510017@amba.ac.id', 'siswa123', '2510017', 'mahasiswa'),
(20, 'Rian Hidayat', '2510018@amba.ac.id', 'siswa123', '2510018', 'mahasiswa'),
(21, 'Dian Puspita', '2510019@amba.ac.id', 'siswa123', '2510019', 'mahasiswa'),
(22, 'Surya Pratama', '2510020@amba.ac.id', 'siswa123', '2510020', 'mahasiswa'),
(23, 'Mega Lestari', '2510021@amba.ac.id', 'siswa123', '2510021', 'mahasiswa'),
(24, 'Fajar Nugroho', '2510022@amba.ac.id', 'siswa123', '2510022', 'mahasiswa'),
(25, 'Putri Aulia', '2510023@amba.ac.id', 'siswa123', '2510023', 'mahasiswa'),
(26, 'Andi Wijaya', '2510024@amba.ac.id', 'siswa123', '2510024', 'mahasiswa'),
(27, 'Citra Dewi', '2510025@amba.ac.id', 'siswa123', '2510025', 'mahasiswa'),
(28, 'Bambang Sutejo', '2510026@amba.ac.id', 'siswa123', '2510026', 'mahasiswa'),
(29, 'Sari Wahyuni', '2510027@amba.ac.id', 'siswa123', '2510027', 'mahasiswa'),
(30, 'Irfan Hakim', '2510028@amba.ac.id', 'siswa123', '2510028', 'mahasiswa'),
(31, 'Eva Rosita', '2510029@amba.ac.id', 'siswa123', '2510029', 'mahasiswa'),
(32, 'Teguh Santoso', '2510030@amba.ac.id', 'siswa123', '2510030', 'mahasiswa'),
(33, 'Nadia Utami', '2510031@amba.ac.id', 'siswa123', '2510031', 'mahasiswa'),
(34, 'Bayu Krisna', '2510032@amba.ac.id', 'siswa123', '2510032', 'mahasiswa'),
(35, 'Tania Putri', '2510033@amba.ac.id', 'siswa123', '2510033', 'mahasiswa'),
(36, 'Farhan Ali', '2510034@amba.ac.id', 'siswa123', '2510034', 'mahasiswa'),
(37, 'Zahra Alifah', '2510035@amba.ac.id', 'siswa123', '2510035', 'mahasiswa'),
(38, 'Galih Prakoso', '2510036@amba.ac.id', 'siswa123', '2510036', 'mahasiswa'),
(39, 'Lia Marlina', '2510037@amba.ac.id', 'siswa123', '2510037', 'mahasiswa'),
(40, 'Reza Pahlevi', '2510038@amba.ac.id', 'siswa123', '2510038', 'mahasiswa'),
(41, 'Vina Febriani', '2510039@amba.ac.id', 'siswa123', '2510039', 'mahasiswa'),
(42, 'Dimas Anggara', '2510040@amba.ac.id', 'siswa123', '2510040', 'mahasiswa'),
(43, 'Ayu Tingkir', '2510041@amba.ac.id', 'siswa123', '2510041', 'mahasiswa'),
(44, 'Kevin Sanjaya', '2510042@amba.ac.id', 'siswa123', '2510042', 'mahasiswa'),
(45, 'Nita Sofiani', '2510043@amba.ac.id', 'siswa123', '2510043', 'mahasiswa'),
(46, 'Akbar Maulana', '2510044@amba.ac.id', 'siswa123', '2510044', 'mahasiswa'),
(47, 'Gita Permata', '2510045@amba.ac.id', 'siswa123', '2510045', 'mahasiswa'),
(48, 'Ilham Nur', '2510046@amba.ac.id', 'siswa123', '2510046', 'mahasiswa'),
(49, 'Siska Amelia', '2510047@amba.ac.id', 'siswa123', '2510047', 'mahasiswa'),
(50, 'Doni Saputra', '2510048@amba.ac.id', 'siswa123', '2510048', 'mahasiswa'),
(51, 'Tiara Anjani', '2510049@amba.ac.id', 'siswa123', '2510049', 'mahasiswa'),
(52, 'Rendy Pratama', '2510050@amba.ac.id', 'siswa123', '2510050', 'mahasiswa'),
(53, 'Muhammad Sumbul', '124230000@student.upnyk.ac.id', '1', '124230000', 'mahasiswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `waktu_hadir` datetime DEFAULT NULL,
  `status` enum('hadir','absen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id_presensi`, `id_materi`, `id_pengguna`, `waktu_hadir`, `status`) VALUES
(52, 92, 2, NULL, 'hadir'),
(53, 92, 3, NULL, 'absen'),
(54, 92, 4, NULL, 'absen'),
(55, 92, 5, NULL, 'absen'),
(56, 92, 6, NULL, 'absen'),
(57, 92, 7, NULL, 'absen'),
(58, 92, 8, NULL, 'absen'),
(59, 92, 9, NULL, 'absen'),
(60, 92, 10, NULL, 'absen'),
(61, 92, 11, NULL, 'absen'),
(62, 92, 12, NULL, 'absen'),
(63, 92, 13, NULL, 'absen'),
(64, 92, 14, NULL, 'absen'),
(65, 92, 15, NULL, 'absen'),
(66, 92, 16, NULL, 'absen'),
(67, 92, 17, NULL, 'absen'),
(68, 92, 18, NULL, 'absen'),
(69, 92, 19, NULL, 'absen'),
(70, 92, 20, NULL, 'absen'),
(71, 92, 21, NULL, 'absen'),
(72, 92, 22, NULL, 'absen'),
(73, 92, 23, NULL, 'absen'),
(74, 92, 24, NULL, 'absen'),
(75, 92, 25, NULL, 'absen'),
(76, 92, 26, NULL, 'absen'),
(77, 92, 27, NULL, 'absen'),
(78, 92, 28, NULL, 'absen'),
(79, 92, 29, NULL, 'absen'),
(80, 92, 30, NULL, 'absen'),
(81, 92, 31, NULL, 'absen'),
(82, 92, 32, NULL, 'absen'),
(83, 92, 33, NULL, 'absen'),
(84, 92, 34, NULL, 'absen'),
(85, 92, 35, NULL, 'absen'),
(86, 92, 36, NULL, 'absen'),
(87, 92, 37, NULL, 'absen'),
(88, 92, 38, NULL, 'absen'),
(89, 92, 39, NULL, 'absen'),
(90, 92, 40, NULL, 'absen'),
(91, 92, 41, NULL, 'absen'),
(92, 92, 42, NULL, 'absen'),
(93, 92, 43, NULL, 'absen'),
(94, 92, 44, NULL, 'absen'),
(95, 92, 45, NULL, 'absen'),
(96, 92, 46, NULL, 'absen'),
(97, 92, 47, NULL, 'absen'),
(98, 92, 48, NULL, 'absen'),
(99, 92, 49, NULL, 'absen'),
(100, 92, 50, NULL, 'absen'),
(101, 92, 51, NULL, 'absen'),
(102, 92, 52, NULL, 'absen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `progres_materi`
--

CREATE TABLE `progres_materi` (
  `id_progres` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `progres_materi`
--

INSERT INTO `progres_materi` (`id_progres`, `id_pengguna`, `id_materi`, `waktu_selesai`) VALUES
(7, 2, 92, '2025-11-10 04:39:24'),
(8, 2, 93, '2025-11-10 04:39:28'),
(9, 2, 91, '2025-11-10 04:40:04'),
(10, 2, 94, '2025-11-10 04:40:08'),
(11, 2, 95, '2025-11-10 04:40:14'),
(12, 2, 97, '2025-11-10 05:54:05'),
(13, 2, 96, '2025-11-10 05:54:13'),
(14, 2, 101, '2025-11-10 15:33:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD PRIMARY KEY (`id_evaluasi`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_pelatihan` (`id_pelatihan`);

--
-- Indeks untuk tabel `nilai_sesi`
--
ALTER TABLE `nilai_sesi`
  ADD PRIMARY KEY (`id_nilai_sesi`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  ADD PRIMARY KEY (`id_pelatihan`);

--
-- Indeks untuk tabel `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_pelatihan` (`id_pelatihan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nomor_induk` (`nomor_induk`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `progres_materi`
--
ALTER TABLE `progres_materi`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_materi` (`id_materi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  MODIFY `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT untuk tabel `nilai_sesi`
--
ALTER TABLE `nilai_sesi`
  MODIFY `id_nilai_sesi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  MODIFY `id_pelatihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT untuk tabel `progres_materi`
--
ALTER TABLE `progres_materi`
  MODIFY `id_progres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD CONSTRAINT `evaluasi_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran_pelatihan` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `pelatihan` (`id_pelatihan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_sesi`
--
ALTER TABLE `nilai_sesi`
  ADD CONSTRAINT `nilai_sesi_ibfk_1` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_sesi_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  ADD CONSTRAINT `pendaftaran_pelatihan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_pelatihan_ibfk_2` FOREIGN KEY (`id_pelatihan`) REFERENCES `pelatihan` (`id_pelatihan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE,
  ADD CONSTRAINT `presensi_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `progres_materi`
--
ALTER TABLE `progres_materi`
  ADD CONSTRAINT `progres_materi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `progres_materi_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
