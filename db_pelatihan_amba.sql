SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_pelatihan_amba`
--
CREATE DATABASE IF NOT EXISTS `db_pelatihan_amba` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_pelatihan_amba`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluasi`
--

DROP TABLE IF EXISTS `evaluasi`;
CREATE TABLE `evaluasi` (
  `id_evaluasi` int(11) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `nilai_pretest` decimal(5,2) DEFAULT NULL,
  `nilai_posttest` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

DROP TABLE IF EXISTS `materi`;
CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_pelatihan` int(11) DEFAULT NULL,
  `judul_materi` varchar(255) NOT NULL,
  `deskripsi_sesi` text DEFAULT NULL,
  `file_modul` varchar(255) DEFAULT NULL,
  `jadwal_sesi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelatihan`
--

DROP TABLE IF EXISTS `pelatihan`;
CREATE TABLE `pelatihan` (
  `id_pelatihan` int(11) NOT NULL,
  `nama_pelatihan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelatihan`
--

INSERT INTO `pelatihan` (`id_pelatihan`, `nama_pelatihan`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`) VALUES
(1, 'Pelatihan Dasar Pemrograman 2025', 'Pelatihan untuk mahasiswa baru Fakultas Sistem Informasi dan Networking Global', '2025-09-15', '2025-12-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran_pelatihan`
--

DROP TABLE IF EXISTS `pendaftaran_pelatihan`;
CREATE TABLE `pendaftaran_pelatihan` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_pelatihan` int(11) DEFAULT NULL,
  `status_kelulusan` enum('terdaftar','lulus','tidak_lulus') DEFAULT 'terdaftar',
  `file_sertifikat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `nomor_induk` varchar(20) DEFAULT NULL,
  `peran` enum('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
-- (Password untuk admin adalah: admin123)
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `email`, `kata_sandi`, `nomor_induk`, `peran`) VALUES
(1, 'Admin Utama', 'admin@amba.ac.id', '$2y$10$T8.H.4I/0kXUa.Y.lF8Yf.K.w.T4uV.g/u.l/1p.R.p.Q.A.S.T.U', 'ADMIN-001', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

DROP TABLE IF EXISTS `presensi`;
CREATE TABLE `presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `waktu_hadir` datetime DEFAULT NULL,
  `status` enum('hadir','absen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  MODIFY `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  MODIFY `id_pelatihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT;

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
COMMIT;