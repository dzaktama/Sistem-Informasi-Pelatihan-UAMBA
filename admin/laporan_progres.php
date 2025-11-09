<?php
$judul_halaman = 'Laporan Progres Belajar Online';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

$error = '';
$id_pelatihan_default = 1;

try {
    $stmt_mahasiswa = $pdo->prepare("
        SELECT p.id_pengguna, p.nama_lengkap 
        FROM pengguna p
        JOIN pendaftaran_pelatihan pp ON p.id_pengguna = pp.id_pengguna
        WHERE pp.id_pelatihan = ? AND p.peran = 'mahasiswa'
        ORDER BY p.nama_lengkap
    ");
    $stmt_mahasiswa->execute([$id_pelatihan_default]);
    $daftar_mahasiswa = $stmt_mahasiswa->fetchAll();

    $stmt_materi = $pdo->prepare("
        SELECT id_materi, judul_materi 
        FROM materi 
        WHERE id_pelatihan = ? 
        ORDER BY jadwal_sesi ASC
    ");
    $stmt_materi->execute([$id_pelatihan_default]);
    $daftar_materi = $stmt_materi->fetchAll();

    $stmt_progres = $pdo->query("SELECT id_pengguna, id_materi FROM progres_materi");
    $semua_progres = $stmt_progres->fetchAll();

    $progres_map = [];
    foreach ($semua_progres as $progres) {
        $progres_map[$progres['id_pengguna']][$progres['id_materi']] = true;
    }

} catch (PDOException $e) {
    $error = 'Gagal mengambil data progres: ' . $e->getMessage();
    $daftar_mahasiswa = [];
    $daftar_materi = [];
    $progres_map = [];
}
?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Laporan Progres Belajar Online Mahasiswa</h2>
    
    <p class="mb-4 text-gray-600">
        Tabel ini menunjukkan materi online mana yang telah ditandai "Selesai" oleh setiap mahasiswa.
        Ini terpisah dari presensi (kehadiran offline) di laboratorium.
    </p>

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                        Nama Mahasiswa
                    </th>
                    <?php foreach ($daftar_materi as $materi): ?>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 100px;">
                            <?php echo htmlspecialchars($materi['judul_materi']); ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($daftar_mahasiswa as $mahasiswa): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white shadow-sm">
                        <?php echo htmlspecialchars($mahasiswa['nama_lengkap']); ?>
                    </td>
                    
                    <?php foreach ($daftar_materi as $materi): ?>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <?php 
                                $id_mhs = $mahasiswa['id_pengguna'];
                                $id_materi = $materi['id_materi'];
                                if (isset($progres_map[$id_mhs][$id_materi])): 
                            ?>
                                <span class="text-2xl text-green-500" title="Selesai">✓</span>
                            <?php else: ?>
                                <span class="text-2xl text-gray-300" title="Belum Selesai">-</span>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>