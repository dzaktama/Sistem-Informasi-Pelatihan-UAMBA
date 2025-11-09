<?php
$judul_halaman = 'Laporan Akhir';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_admin.php';

// ... (KODE PHP LENGKAP ANDA DARI SEBELUMNYA) ...
$id_pelatihan_default = 1;
$error = '';

try {
    $stmt_pelatihan = $pdo->prepare("SELECT * FROM pelatihan WHERE id_pelatihan = ?");
    $stmt_pelatihan->execute([$id_pelatihan_default]);
    $pelatihan = $stmt_pelatihan->fetch();

    $stmt_total_sesi = $pdo->prepare("SELECT COUNT(id_materi) FROM materi WHERE id_pelatihan = ?");
    $stmt_total_sesi->execute([$id_pelatihan_default]);
    $total_sesi = $stmt_total_sesi->fetchColumn();

    $stmt_peserta = $pdo->prepare("SELECT p.nama_lengkap, p.nomor_induk, pp.id_pendaftaran, pp.status_kelulusan, e.nilai_pretest, e.nilai_posttest, (SELECT COUNT(pr.id_presensi) FROM presensi pr WHERE pr.id_pengguna = p.id_pengguna AND pr.status = 'hadir') as total_hadir FROM pengguna p JOIN pendaftaran_pelatihan pp ON p.id_pengguna = pp.id_pengguna LEFT JOIN evaluasi e ON pp.id_pendaftaran = e.id_pendaftaran WHERE pp.id_pelatihan = ? AND p.peran = 'mahasiswa' ORDER BY p.nama_lengkap");
    $stmt_peserta->execute([$id_pelatihan_default]);
    $daftar_peserta = $stmt_peserta->fetchAll();

    $total_peserta = count($daftar_peserta);
    $total_lulus = 0;
    foreach ($daftar_peserta as $peserta) {
        if ($peserta['status_kelulusan'] == 'lulus') {
            $total_lulus++;
        }
    }
    
    $persentase_kelulusan = ($total_peserta > 0) ? ($total_lulus / $total_peserta) * 100 : 0;

} catch (PDOException $e) {
    $error = 'Gagal mengambil data laporan: ' . $e->getMessage();
    $pelatihan = null;
    $daftar_peserta = [];
    $total_sesi = 0;
    $total_peserta = 0;
    $total_lulus = 0;
    $persentase_kelulusan = 0;
}
?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-start mb-6 no-print">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Laporan Akhir Kegiatan</h2>
            <p class="text-xl text-amba-hijau-tua font-semibold"><?php echo htmlspecialchars($pelatihan['nama_pelatihan'] ?? 'Nama Pelatihan'); ?></p>
            <p class="text-gray-600">Tanggal Pelaksanaan: <?php echo format_tanggal_indonesia($pelatihan['tanggal_mulai']); ?> - <?php echo format_tanggal_indonesia($pelatihan['tanggal_selesai']); ?></p>
        </div>
        <button onclick="window.print()" class="py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">Cetak Laporan</button>
    </div>

    <style>@media print { .no-print { display: none; } main { padding: 0; } .print-container { box-shadow: none; border: 1px solid #e2e8f0; } }</style>

    <div class="print-container">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 px-6 pt-6">Ringkasan Pelatihan</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-6 pb-6">
            <div class="bg-gray-50 p-4 rounded-lg shadow-inner"><h4 class="text-sm font-medium text-gray-500 uppercase">Total Peserta</h4><p class="text-3xl font-bold text-gray-900"><?php echo $total_peserta; ?></p></div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-inner"><h4 class="text-sm font-medium text-gray-500 uppercase">Total Sesi</h4><p class="text-3xl font-bold text-gray-900"><?php echo $total_sesi; ?></p></div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-inner"><h4 class="text-sm font-medium text-gray-500 uppercase">Peserta Lulus</h4><p class="text-3xl font-bold text-gray-900"><?php echo $total_lulus; ?></p></div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-inner"><h4 class="text-sm font-medium text-gray-500 uppercase">Persentase Kelulusan</h4><p class="text-3xl font-bold text-gray-900"><?php echo round($persentase_kelulusan, 1); ?>%</p></div>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-4 px-6">Detail Capaian Peserta</h3>
        
        <div class="mb-4 px-6 no-print">
            <input type="text" id="pencarian-laporan" 
                   placeholder="Cari berdasarkan nama atau NIM..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pre-Test</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Post-Test</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tabel-laporan">
                    <?php $no = 1; ?>
                    <?php foreach ($daftar_peserta as $peserta): ?>
                        <?php 
                            $persen_hadir = ($total_sesi > 0) ? ($peserta['total_hadir'] / $total_sesi) * 100 : 0;
                            $status_class = 'bg-gray-100 text-gray-800';
                            if ($peserta['status_kelulusan'] == 'lulus') $status_class = 'bg-green-100 text-green-800';
                            elseif ($peserta['status_kelulusan'] == 'tidak_lulus') $status_class = 'bg-red-100 text-red-800';
                        ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $no++; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($peserta['nama_lengkap']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($peserta['nomor_induk']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo $peserta['total_hadir']; ?> / <?php echo $total_sesi; ?> (<?php echo round($persen_hadir, 0); ?>%)</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo htmlspecialchars($peserta['nilai_pretest'] ?? '-'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo htmlspecialchars($peserta['nilai_posttest'] ?? '-'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $status_class; ?>"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $peserta['status_kelulusan']))); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-laporan', '#tabel-laporan tr', 'table-row');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>