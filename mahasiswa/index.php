<?php
$judul_halaman = 'Dashboard';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pengguna = $_SESSION['id_pengguna'];
$id_pelatihan_default = 1;
$error = '';

try {
    // 1. Ambil Progres Materi ONLINE
    $stmt_total_materi = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_materi->execute([$id_pelatihan_default]);
    $total_materi = $stmt_total_materi->fetchColumn();

    $stmt_materi_selesai = $pdo->prepare("SELECT COUNT(id_progres) FROM progres_materi pm JOIN materi m ON pm.id_materi = m.id_materi WHERE pm.id_pengguna = ? AND m.id_pelatihan = ?");
    $stmt_materi_selesai->execute([$id_pengguna, $id_pelatihan_default]);
    $materi_selesai = $stmt_materi_selesai->fetchColumn();
    $persen_materi = ($total_materi > 0) ? ($materi_selesai / $total_materi) * 100 : 0;

    // 2. Ambil Progres Kehadiran OFFLINE
    $stmt_total_sesi_offline = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_sesi_offline->execute([$id_pelatihan_default]);
    $total_sesi_offline = $stmt_total_sesi_offline->fetchColumn();

    $stmt_hadir = $pdo->prepare("SELECT COUNT(id_presensi) FROM presensi p JOIN materi m ON p.id_materi = m.id_materi WHERE p.id_pengguna = ? AND m.id_pelatihan = ? AND p.status = 'hadir'");
    $stmt_hadir->execute([$id_pengguna, $id_pelatihan_default]);
    $total_hadir = $stmt_hadir->fetchColumn();
    $persen_hadir = ($total_sesi_offline > 0) ? ($total_hadir / $total_sesi_offline) * 100 : 0;

    // 3. Ambil Nilai Pre-Test
    $stmt_eval = $pdo->prepare("SELECT e.nilai_pretest FROM evaluasi e JOIN pendaftaran_pelatihan pp ON e.id_pendaftaran = pp.id_pendaftaran WHERE pp.id_pengguna = ? AND pp.id_pelatihan = ?");
    $stmt_eval->execute([$id_pengguna, $id_pelatihan_default]);
    $evaluasi = $stmt_eval->fetch();
    $nilai_pretest = $evaluasi['nilai_pretest'] ?? 0;

    // 4. Ambil Materi ONLINE Berikutnya (yang BELUM selesai)
    $stmt_materi_next = $pdo->prepare("SELECT m.id_materi, m.judul_materi FROM materi m LEFT JOIN progres_materi pm ON m.id_materi = pm.id_materi AND pm.id_pengguna = ? WHERE pm.id_progres IS NULL AND m.id_pelatihan = ? ORDER BY m.jadwal_sesi ASC LIMIT 1");
    $stmt_materi_next->execute([$id_pengguna, $id_pelatihan_default]);
    $materi_berikutnya = $stmt_materi_next->fetch();

    // 5. Ambil Sesi OFFLINE Berikutnya (yang akan datang)
    $stmt_sesi_next = $pdo->prepare("SELECT judul_materi, jadwal_sesi FROM materi WHERE id_pelatihan = ? AND jadwal_sesi > NOW() ORDER BY jadwal_sesi ASC LIMIT 1");
    $stmt_sesi_next->execute([$id_pelatihan_default]);
    $sesi_offline_berikutnya = $stmt_sesi_next->fetch();

} catch (PDOException $e) {
    $error = 'Gagal mengambil data dashboard: ' . $e->getMessage();
    // Set default values on error
    $total_materi = $materi_selesai = $persen_materi = 0;
    $total_sesi_offline = $total_hadir = $persen_hadir = 0;
    $nilai_pretest = 0;
    $materi_berikutnya = null;
    $sesi_offline_berikutnya = null;
}
?>

<div class="p-6 h-full overflow-y-auto scrollbar-custom">

    <?php if ($error): ?>
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="mb-6 p-6 bg-amba-hijau-tua text-white rounded-lg shadow-lg animate-fade-in-up">
        <h2 class="text-3xl font-bold">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h2>
        <p class="mt-1 text-lg text-amba-hijau-muda">Selamat datang kembali di Dashboard Pelatihan Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.1s;">
            <h3 class="text-base font-semibold text-gray-500 uppercase tracking-wider">Progres Materi (Online)</h3>
            <div class="flex justify-between items-end mt-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo round($persen_materi, 0); ?>%</span>
                <span class="text-sm font-medium text-gray-500"><?php echo $materi_selesai; ?>/<?php echo $total_materi; ?> materi</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
                <div class="bg-amba-hijau-tua h-2.5 rounded-full" style="width: <?php echo $persen_materi; ?>%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.2s;">
            <h3 class="text-base font-semibold text-gray-500 uppercase tracking-wider">Kehadiran (Offline)</h3>
            <div class="flex justify-between items-end mt-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo round($persen_hadir, 0); ?>%</span>
                <span class="text-sm font-medium text-gray-500"><?php echo $total_hadir; ?>/<?php echo $total_sesi_offline; ?> sesi</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo $persen_hadir; ?>%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.3s;">
            <h3 class="text-base font-semibold text-gray-500 uppercase tracking-wider">Nilai Pre-Test</h3>
            <div class="flex justify-between items-end mt-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo htmlspecialchars($nilai_pretest); ?></span>
                <span class="text-sm font-medium text-gray-500">/ 100 Poin</span>
            </div>
            <p class="text-xs text-gray-500 mt-3">Nilai Post-Test akan muncul di halaman Progres Belajar.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.4s;">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Lanjutkan Belajar (Online)</h3>
            <?php if ($materi_berikutnya): ?>
                <p class="text-sm text-gray-500">Materi Anda berikutnya:</p>
                <p class="text-2xl font-bold text-amba-hijau-tua my-2">
                    <?php echo htmlspecialchars($materi_berikutnya['judul_materi']); ?>
                </p>
                <a href="lihat_materi.php?id=<?php echo $materi_berikutnya['id_materi']; ?>" class="inline-block mt-3 py-2 px-5 bg-amba-hijau-tua text-white rounded-lg hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200 font-medium">
                    Mulai Belajar &rarr;
                </a>
            <?php elseif ($total_materi > 0): ?>
                <p class="text-xl font-bold text-green-600">Luar biasa!</p>
                <p class="text-gray-600 mt-2">Anda telah menyelesaikan semua materi online.</p>
            <?php else: ?>
                 <p class="text-gray-500">Admin belum menambahkan materi online.</p>
            <?php endif; ?>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.5s;">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Jadwal Sesi Berikutnya (Offline)</h3>
            <?php if ($sesi_offline_berikutnya): ?>
                <p class="text-sm text-gray-500">Sesi tatap muka Anda berikutnya di lab:</p>
                <p class="text-2xl font-bold text-blue-600 my-2">
                    <?php echo htmlspecialchars($sesi_offline_berikutnya['judul_materi']); ?>
                </p>
                <p class="text-lg font-medium text-gray-700">
                    <?php echo format_tanggal_indonesia($sesi_offline_berikutnya['jadwal_sesi']); ?>
                </p>
            <?php else: ?>
                <p class="text-gray-500 mt-2">Tidak ada jadwal sesi offline yang akan datang.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.6s;">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Akses Cepat</h3>
        <div class="flex flex-wrap gap-4">
            <a href="materi.php" class="py-3 px-5 bg-amba-hijau-tua text-white rounded-lg hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
                Lihat Semua Materi
            </a>
            <a href="progres_belajar.php" class="py-3 px-5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                Lihat Rekap Progres Lengkap
            </a>
            <a href="jadwal.php" class="py-3 px-5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition duration-200">
                Lihat Semua Jadwal Offline
            </a>
        </div>
    </div>

</div> <?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>