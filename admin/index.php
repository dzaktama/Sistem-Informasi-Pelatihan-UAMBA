<?php
$judul_halaman = 'Dashboard';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

try {
    $stmt_mhs = $pdo->query("SELECT COUNT(id_pengguna) FROM pengguna WHERE peran = 'mahasiswa'");
    $jumlah_mahasiswa = $stmt_mhs->fetchColumn();

    $stmt_sesi = $pdo->query("SELECT COUNT(id_materi) FROM materi");
    $jumlah_sesi = $stmt_sesi->fetchColumn();
    
    $stmt_lulus = $pdo->query("SELECT COUNT(id_pendaftaran) FROM pendaftaran_pelatihan WHERE status_kelulusan = 'lulus'");
    $jumlah_lulus = $stmt_lulus->fetchColumn();

} catch (PDOException $e) {
    $jumlah_mahasiswa = 0;
    $jumlah_sesi = 0;
    $jumlah_lulus = 0;
}
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
        <h3 class="text-lg font-medium text-gray-600">Total Mahasiswa</h3>
        <p class="text-4xl font-bold text-gray-900 mt-2"><?php echo $jumlah_mahasiswa; ?></p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
        <h3 class="text-lg font-medium text-gray-600">Total Sesi Pelatihan</h3>
        <p class="text-4xl font-bold text-gray-900 mt-2"><?php echo $jumlah_sesi; ?></p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
        <h3 class="text-lg font-medium text-gray-600">Mahasiswa Lulus</h3>
        <p class="text-4xl font-bold text-gray-900 mt-2"><?php echo $jumlah_lulus; ?></p>
    </div>
</div>

<div class="mt-8 bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Akses Cepat</h3>
    <div class="flex flex-wrap gap-4">
        <a href="kelola_pengguna.php" class="py-3 px-5 bg-amba-hijau-tua text-white rounded-lg hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
            Kelola Pengguna
        </a>
        <a href="kelola_presensi.php" class="py-3 px-5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
            Input Presensi Hari Ini
        </a>
        <a href="laporan_akhir.php" class="py-3 px-5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition duration-200">
            Cetak Laporan
        </a>
    </div>
</div>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>