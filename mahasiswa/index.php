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
        <h2 class="text-xl font-bold">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h2>
        <p class="mt-1 text-sm text-amba-hijau-muda">Selamat datang kembali di Dashboard Pelatihan Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex justify-between items-start">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Progres Materi (Online)</h3>
                <div class="flex-shrink-0 p-2 bg-amba-hijau-muda/20 rounded-full">
                    <svg style="width: 1.25rem; height: 1.25rem;" class="text-amba-hijau-tua" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="flex justify-between items-end mt-2">
                <span class="text-2xl font-bold text-gray-900"><?php echo round($persen_materi, 0); ?>%</span>
                <span class="text-xs font-medium text-gray-500"><?php echo $materi_selesai; ?>/<?php echo $total_materi; ?> materi</span>
            </div>
            <div style="width: 100%; background-color: #E5E7EB; border-radius: 9999px; height: 0.5rem; margin-top: 0.75rem; overflow: hidden;">
                <div style="background-color: #445535; height: 0.5rem; border-radius: 9999px; width: <?php echo $persen_materi; ?>%;"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex justify-between items-start">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran (Offline)</h3>
                <div class="flex-shrink-0 p-2 bg-blue-100 rounded-full">
                    <svg style="width: 1.25rem; height: 1.25rem;" class="text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex justify-between items-end mt-2">
                <span class="text-2xl font-bold text-gray-900"><?php echo round($persen_hadir, 0); ?>%</span>
                <span class="text-xs font-medium text-gray-500"><?php echo $total_hadir; ?>/<?php echo $total_sesi_offline; ?> sesi</span>
            </div>
            <div style="width: 100%; background-color: #E5E7EB; border-radius: 9999px; height: 0.5rem; margin-top: 0.75rem; overflow: hidden;">
                <div style="background-color: #2563EB; height: 0.5rem; border-radius: 9999px; width: <?php echo $persen_hadir; ?>%;"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="flex justify-between items-start">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai Pre-Test</h3>
                <div class="flex-shrink-0 p-2 bg-yellow-100 rounded-full">
                    <svg style="width: 1.25rem; height: 1.25rem;" class="text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="flex justify-between items-end mt-2">
                <span class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($nilai_pretest); ?></span>
                <span class="text-xs font-medium text-gray-500">/ 100 Poin</span>
            </div>
            <p class="text-xs text-gray-500 mt-3">Nilai Post-Test akan muncul di halaman Progres Belajar.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.4s;">
            <div class="flex items-center space-x-3 mb-4">
                <div class="flex-shrink-0 p-2 bg-amba-hijau-muda/20 rounded-full">
                    <svg style="width: 1.5rem; height: 1.5rem;" class="text-amba-hijau-tua" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Lanjutkan Belajar (Online)</h3>
            </div>
            <?php if ($materi_berikutnya): ?>
                <p class="text-sm text-gray-500">Materi Anda berikutnya:</p>
                <p class="text-lg font-bold text-gray-900 my-2">
                    <?php echo htmlspecialchars($materi_berikutnya['judul_materi']); ?>
                </p>
                <a href="lihat_materi.php?id=<?php echo $materi_berikutnya['id_materi']; ?>" class="inline-block mt-3 py-2 px-4 bg-amba-hijau-tua text-white rounded-lg hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200 font-medium text-sm">
                    Mulai Belajar &rarr;
                </a>
            <?php elseif ($total_materi > 0): ?>
                <p class="text-lg font-bold text-green-600">Luar biasa!</p>
                <p class="text-gray-600 mt-2 text-sm">Anda telah menyelesaikan semua materi online.</p>
            <?php else: ?>
                 <p class="text-gray-500 text-sm">Admin belum menambahkan materi online.</p>
            <?php endif; ?>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex items-center space-x-3 mb-4">
                <div class="flex-shrink-0 p-2 bg-blue-100 rounded-full">
                    <svg style="width: 1.5rem; height: 1.5rem;" class="text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Jadwal Sesi (Offline)</h3>
            </div>
            <?php if ($sesi_offline_berikutnya): ?>
                <p class="text-sm text-gray-500">Sesi tatap muka Anda berikutnya di lab:</p>
                <p class="text-lg font-bold text-gray-900 my-2">
                    <?php echo htmlspecialchars($sesi_offline_berikutnya['judul_materi']); ?>
                </p>
                <p class="text-sm font-medium text-gray-700">
                    <?php echo format_tanggal_indonesia($sesi_offline_berikutnya['jadwal_sesi']); ?>
                </p>
            <?php else: ?>
                <p class="text-gray-500 mt-2 text-sm">Tidak ada jadwal sesi offline yang akan datang.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="materi.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 p-3 bg-amba-hijau-muda/20 rounded-full">
                        <svg style="width: 2rem; height: 2rem;" class="text-amba-hijau-tua" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900">Materi Pelatihan</h4>
                        <p class="text-xs text-gray-500">Lihat semua <?php echo $total_materi; ?> sesi materi online.</p>
                    </div>
                </div>
            </a>

            <a href="progres_belajar.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                        <svg style="width: 2rem; height: 2rem;" class="text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900">Rekap Progres</h4>
                        <p class="text-xs text-gray-500">Lihat nilai & rekap kehadiran offline.</p>
                    </div>
                </div>
            </a>

            <a href="jadwal.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 p-3 bg-gray-200 rounded-full">
                        <svg style="width: 2rem; height: 2rem;" class="text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900">Jadwal Offline</h4>
                        <p class="text-xs text-gray-500">Lihat semua jadwal sesi di lab.</p>
                    </div>
                </div>
            </a>

        </div>
    </div>

</div> <?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>