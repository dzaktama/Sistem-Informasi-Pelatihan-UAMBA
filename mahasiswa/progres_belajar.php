<?php
$judul_halaman = 'Rekapitulasi Progres Belajar';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pelatihan_default = 1;
$id_pengguna = $_SESSION['id_pengguna'];
$error = '';

try {
    // 1. Ambil data Nilai (Evaluasi) Pre/Post
    $stmt_eval = $pdo->prepare("SELECT e.nilai_pretest, e.nilai_posttest FROM evaluasi e JOIN pendaftaran_pelatihan pp ON e.id_pendaftaran = pp.id_pendaftaran WHERE pp.id_pengguna = ? AND pp.id_pelatihan = ?");
    $stmt_eval->execute([$id_pengguna, $id_pelatihan_default]);
    $evaluasi = $stmt_eval->fetch();
    
    // 2. Ambil data Progres Materi (Online)
    $stmt_total_materi = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_materi->execute([$id_pelatihan_default]);
    $total_materi = $stmt_total_materi->fetchColumn();

    $stmt_materi_selesai = $pdo->prepare("SELECT COUNT(pm.id_progres) FROM progres_materi pm JOIN materi m ON pm.id_materi = m.id_materi WHERE pm.id_pengguna = ? AND m.id_pelatihan = ?");
    $stmt_materi_selesai->execute([$id_pengguna, $id_pelatihan_default]);
    $materi_selesai = $stmt_materi_selesai->fetchColumn();
    $persen_materi = ($total_materi > 0) ? ($materi_selesai / $total_materi) * 100 : 0;

    // 3. Ambil data Progres Kehadiran (Offline)
    $stmt_hadir = $pdo->prepare("SELECT COUNT(p.id_presensi) FROM presensi p JOIN materi m ON p.id_materi = m.id_materi WHERE p.id_pengguna = ? AND m.id_pelatihan = ? AND p.status = 'hadir'");
    $stmt_hadir->execute([$id_pengguna, $id_pelatihan_default]);
    $total_hadir = $stmt_hadir->fetchColumn();
    $persen_hadir = ($total_materi > 0) ? ($total_hadir / $total_materi) * 100 : 0; // Total sesi = total materi

    // 4. (BARU) Ambil Rata-rata Nilai Sesi & Daftar Nilai Rinci
    $stmt_nilai_sesi = $pdo->prepare("
        SELECT AVG(ns.nilai) as rata_rata, COUNT(ns.nilai) as jumlah_nilai
        FROM nilai_sesi ns
        JOIN materi m ON ns.id_materi = m.id_materi
        WHERE ns.id_pengguna = ? AND m.id_pelatihan = ? AND ns.nilai IS NOT NULL
    ");
    $stmt_nilai_sesi->execute([$id_pengguna, $id_pelatihan_default]);
    $rekap_nilai = $stmt_nilai_sesi->fetch();
    $rata_rata_nilai = $rekap_nilai['rata_rata'] ?? 0;
    
    // 5. (BARU) Ambil Daftar Rincian Nilai
    $stmt_rincian_nilai = $pdo->prepare("
        SELECT m.judul_materi, m.jadwal_sesi, ns.nilai, ns.catatan_instruktur
        FROM materi m
        LEFT JOIN nilai_sesi ns ON m.id_materi = ns.id_materi AND ns.id_pengguna = ?
        WHERE m.id_pelatihan = ?
        ORDER BY m.jadwal_sesi ASC
    ");
    $stmt_rincian_nilai->execute([$id_pengguna, $id_pelatihan_default]);
    $daftar_nilai_rinci = $stmt_rincian_nilai->fetchAll();


} catch (PDOException $e) {
    $error = 'Gagal mengambil data progres: ' . $e->getMessage();
    $evaluasi = null;
    $persen_materi = 0;
    $persen_hadir = 0;
    $rata_rata_nilai = 0;
    $daftar_nilai_rinci = [];
}
?>

<div class="p-6 h-full overflow-y-auto scrollbar-custom">

    <?php if ($error): ?>
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex justify-between items-start">
                <h3 class="text-base font-semibold text-gray-500 uppercase tracking-wider">Progres Materi (Online)</h3>
                <div class="flex-shrink-0 p-2 bg-amba-hijau-muda/20 rounded-full">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #445535;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <span class="text-4xl font-bold text-gray-900"><?php echo round($persen_materi, 0); ?>%</span>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
                <div class="bg-amba-hijau-tua h-2.5 rounded-full" style="width: <?php echo $persen_materi; ?>%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex justify-between items-start">
                <h3 class="text-base font-semibold text-gray-500 uppercase tracking-wider">Kehadiran (Offline)</h3>
                <div class="flex-shrink-0 p-2 bg-blue-100 rounded-full">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #2563EB;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <span class="text-4xl font-bold text-gray-900"><?php echo round($persen_hadir, 0); ?>%</span>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo $persen_hadir; ?>%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="flex justify-between items-start">
                <h3 class="text-base font-semibold text-gray-500 uppercase tracking-wider">Nilai Rata-Rata Sesi</h3>
                 <div class="flex-shrink-0 p-2 bg-yellow-100 rounded-full">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
            </div>
            <span class="text-4xl font-bold text-gray-900"><?php echo round($rata_rata_nilai, 1); ?></span>
            <p class="text-xs text-gray-500 mt-3">Rata-rata dari nilai tugas/kuis per sesi yang diinput admin.</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up mb-6" style="animation-delay: 0.4s;">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Rekapitulasi Nilai Ujian</h3>
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

    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.5s;">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Rincian Nilai Sesi (Tugas/Kuis)</h3>
        
        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sesi</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai (0-100)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan dari Instruktur</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tabel-rincian-nilai">
                    <?php if (empty($daftar_nilai_rinci)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">
                                Admin belum menambahkan sesi materi.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftar_nilai_rinci as $nilai): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($nilai['judul_materi']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <?php if ($nilai['nilai'] !== null): ?>
                                        <span class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($nilai['nilai']); ?></span>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?php if ($nilai['catatan_instruktur']): ?>
                                        <span class="italic">"<?php echo htmlspecialchars($nilai['catatan_instruktur']); ?>"</span>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div> <?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>