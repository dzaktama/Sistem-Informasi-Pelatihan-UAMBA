<?php
$judul_halaman = 'Jadwal Sesi';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pelatihan_default = 1;
$id_pengguna = $_SESSION['id_pengguna'];
$error = '';

try {
    $stmt = $pdo->prepare("SELECT m.judul_materi, m.jadwal_sesi, p.status FROM materi m LEFT JOIN presensi p ON m.id_materi = p.id_materi AND p.id_pengguna = ? WHERE m.id_pelatihan = ? ORDER BY m.jadwal_sesi ASC");
    $stmt->execute([$id_pengguna, $id_pelatihan_default]);
    $daftar_jadwal = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Gagal mengambil data jadwal: ' . $e->getMessage();
    $daftar_jadwal = [];
}
?>

<div class="p-6 h-full overflow-y-auto scrollbar-custom">
    <?php if ($error): ?>
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Jadwal Sesi Pelatihan (Offline)</h2>
        <p class="mb-4 text-gray-600">Ini adalah jadwal untuk sesi tatap muka di laboratorium. Kehadiran Anda akan dicatat oleh admin/instruktur saat Anda hadir di kelas.</p>

        <div class="mb-4">
            <input type="text" id="pencarian-jadwal" 
                   placeholder="Cari berdasarkan nama sesi atau tanggal..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua">
        </div>

        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sesi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tabel-jadwal">
                    <?php if (empty($daftar_jadwal)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Jadwal belum dipublikasikan oleh admin.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftar_jadwal as $jadwal): ?>
                            <?php
                                $status_text = 'Belum Dimulai';
                                $status_class = 'bg-gray-100 text-gray-800';
                                if (strtotime($jadwal['jadwal_sesi']) < time()) {
                                    if ($jadwal['status'] == 'hadir') {
                                        $status_text = 'Hadir';
                                        $status_class = 'bg-green-100 text-green-800';
                                    } else {
                                        $status_text = 'Absen';
                                        $status_class = 'bg-red-100 text-red-800';
                                    }
                                }
                            ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($jadwal['judul_materi']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo format_tanggal_indonesia($jadwal['jadwal_sesi']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-jadwal', '#tabel-jadwal tr', 'table-row');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>