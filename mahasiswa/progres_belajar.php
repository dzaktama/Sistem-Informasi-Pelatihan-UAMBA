<?php
$judul_halaman = 'Rekapitulasi Progres Belajar';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pelatihan_default = 1;
$id_pengguna = $_SESSION['id_pengguna'];
$error = '';

try {
    $stmt_eval = $pdo->prepare("SELECT e.nilai_pretest, e.nilai_posttest FROM evaluasi e JOIN pendaftaran_pelatihan pp ON e.id_pendaftaran = pp.id_pendaftaran WHERE pp.id_pengguna = ? AND pp.id_pelatihan = ?");
    $stmt_eval->execute([$id_pengguna, $id_pelatihan_default]);
    $evaluasi = $stmt_eval->fetch();
    
    $stmt_total_materi = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_materi->execute([$id_pelatihan_default]);
    $total_materi = $stmt_total_materi->fetchColumn();

    $stmt_materi_selesai = $pdo->prepare("SELECT COUNT(pm.id_progres) FROM progres_materi pm JOIN materi m ON pm.id_materi = m.id_materi WHERE pm.id_pengguna = ? AND m.id_pelatihan = ?");
    $stmt_materi_selesai->execute([$id_pengguna, $id_pelatihan_default]);
    $materi_selesai = $stmt_materi_selesai->fetchColumn();
    
    $persen_materi = ($total_materi > 0) ? ($materi_selesai / $total_materi) * 100 : 0;

    $stmt_total_sesi = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_sesi->execute([$id_pelatihan_default]);
    $total_sesi = $stmt_total_sesi->fetchColumn();

    $stmt_hadir = $pdo->prepare("SELECT COUNT(p.id_presensi) FROM presensi p JOIN materi m ON p.id_materi = m.id_materi WHERE p.id_pengguna = ? AND m.id_pelatihan = ? AND p.status = 'hadir'");
    $stmt_hadir->execute([$id_pengguna, $id_pelatihan_default]);
    $total_hadir = $stmt_hadir->fetchColumn();
    
    $persen_hadir = ($total_sesi > 0) ? ($total_hadir / $total_sesi) * 100 : 0;
} catch (PDOException $e) {
    $error = 'Gagal mengambil data progres: ' . $e->getMessage();
    $evaluasi = null;
    $total_materi = 0;
    $materi_selesai = 0;
    $persen_materi = 0;
    $total_sesi = 0;
    $total_hadir = 0;
    $persen_hadir = 0;
}
?>

<div class="p-6 h-full overflow-y-auto scrollbar-custom">

    <?php if ($error): ?>
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Progres Materi (Online)</h3>
            <p class="text-sm text-gray-500 mb-2">Seberapa banyak materi yang sudah Anda pelajari secara mandiri.</p>
            <div class="w-full bg-gray-200 rounded-full h-6 mb-2">
                <div class="bg-amba-hijau-tua h-6 rounded-full text-white text-sm font-medium flex items-center justify-center" 
                     style="width: <?php echo round($persen_materi, 2); ?>%">
                    <?php echo round($persen_materi, 1); ?>%
                </div>
            </div>
            <p class="text-center font-medium text-gray-700">
                Total Materi Selesai: 
                <span class="text-2xl font-bold text-amba-hijau-tua"><?php echo $materi_selesai; ?></span> / <?php echo $total_materi; ?> Materi
            </p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Progres Kehadiran (Offline)</h3>
            <p class="text-sm text-gray-500 mb-2">Kehadiran Anda di kelas luring (dicatat oleh admin/instruktur).</p>
            <div class="w-full bg-gray-200 rounded-full h-6 mb-2">
                <div class="bg-blue-600 h-6 rounded-full text-white text-sm font-medium flex items-center justify-center" 
                     style="width: <?php echo round($persen_hadir, 2); ?>%">
                    <?php echo round($persen_hadir, 1); ?>%
                </div>
            </div>
            <p class="text-center font-medium text-gray-700">
                Total Kehadiran: 
                <span class="text-2xl font-bold text-blue-600"><?php echo $total_hadir; ?></span> / <?php echo $total_sesi; ?> Sesi
            </p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mt-6 animate-fade-in-up" style="animation-delay: 0.1s;">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Rekapitulasi Nilai</h3>
        <div class="flex justify-around">
            <div class="text-center">
                <h4 class="text-sm font-medium text-gray-500 uppercase">NILAI PRE-TEST</h4>
                <p class="text-5xl font-bold text-blue-600 mt-2">
                    <?php echo htmlspecialchars($evaluasi['nilai_pretest'] ?? '-'); ?>
                </p>
            </div>
            <div class="text-center">
                <h4 class="text-sm font-medium text-gray-500 uppercase">NILAI POST-TEST</h4>
                <p class="text-5xl font-bold text-green-600 mt-2">
                    <?php echo htmlspecialchars($evaluasi['nilai_posttest'] ?? '-'); ?>
                </p>
            </div>
        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>