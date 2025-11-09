<?php
$judul_halaman = 'Dashboard';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pengguna = $_SESSION['id_pengguna'];
$id_pelatihan_default = 1;

try {
    
    $stmt_sesi = $pdo->prepare("SELECT COUNT(id_progres) 
                               FROM progres_materi pm
                               JOIN materi m ON pm.id_materi = m.id_materi
                               WHERE pm.id_pengguna = ? AND m.id_pelatihan = ?");
    $stmt_sesi->execute([$id_pengguna, $id_pelatihan_default]);
    $sesi_dihadiri = $stmt_sesi->fetchColumn();

    $stmt_total_sesi = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_sesi->execute([$id_pelatihan_default]);
    $total_sesi = $stmt_total_sesi->fetchColumn();
    
    $progres = 0;
    if ($total_sesi > 0) {
        $progres = ($sesi_dihadiri / $total_sesi) * 100;
    }

    $stmt_sesi_berikutnya = $pdo->prepare("
        SELECT m.id_materi, m.judul_materi 
        FROM materi m
        LEFT JOIN progres_materi pm ON m.id_materi = pm.id_materi AND pm.id_pengguna = ?
        WHERE pm.id_progres IS NULL AND m.id_pelatihan = ?
        ORDER BY m.jadwal_sesi ASC 
        LIMIT 1
    ");
    $stmt_sesi_berikutnya->execute([$id_pengguna, $id_pelatihan_default]);
    $sesi_berikutnya = $stmt_sesi_berikutnya->fetch();

} catch (PDOException $e) {
    $sesi_dihadiri = 0;
    $total_sesi = 0;
    $progres = 0;
    $sesi_berikutnya = null;
}
?>

<div class="bg-white p-6 rounded-lg shadow-md mb-6 animate-fade-in-up">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
        Selamat Datang di Pelatihan Dasar Pemrograman
    </h2>
    <p class="text-gray-600">
        Ini adalah pusat kendali Anda. Anda dapat melihat materi, memeriksa jadwal, dan melacak progres Anda selama pelatihan.
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in-up" style="animation-delay: 0.1s;">
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-medium text-gray-600 mb-4">Progres Materi Online Anda</h3>
        <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
            <div class="bg-amba-hijau-tua h-4 rounded-full transition-all duration-500" style="width: <?php echo round($progres, 2); ?>%"></div>
        </div>
        <p class="text-right font-medium text-amba-hijau-tua">
            <?php echo round($progres, 2); ?>% Selesai
        </p>
        <p class="text-sm text-gray-500 mt-2">
            Anda telah menyelesaikan <?php echo $sesi_dihadiri; ?> dari <?php echo $total_sesi; ?> materi.
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-medium text-gray-600 mb-4">Materi Anda Berikutnya</h3>
        <?php if ($sesi_berikutnya): ?>
            <p class="text-xl font-bold text-amba-hijau-tua">
                <?php echo htmlspecialchars($sesi_berikutnya['judul_materi']); ?>
            </p>
            <a href="lihat_materi.php?id=<?php echo $sesi_berikutnya['id_materi']; ?>" class="inline-block mt-3 py-2 px-4 bg-amba-hijau-tua text-white rounded hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
                Lanjutkan Belajar &rarr;
            </a>
        <?php elseif ($total_sesi > 0): ?>
            <p class="text-gray-500">
                Luar biasa! Semua materi telah selesai.
            </p>
        <?php else: ?>
             <p class="text-gray-500">
                Admin belum menambahkan materi.
            </p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-8 bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.2s;">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Akses Cepat</h3>
    <div class="flex flex-wrap gap-4">
        <a href="materi.php" class="py-3 px-5 bg-amba-hijau-tua text-white rounded-lg hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
            Lihat Semua Materi
        </a>
        <a href="progres_belajar.php" class="py-3 px-5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
            Lihat Nilai & Kehadiran
        </a>
    </div>
</div>

<?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>