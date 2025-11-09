<?php
$judul_halaman = 'Kelola Evaluasi';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

// ... (KODE PHP LENGKAP ANDA DARI SEBELUMNYA) ...
$error = '';
$sukses = '';
$id_pelatihan_default = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nilai = $_POST['nilai'] ?? [];
    
    try {
        $pdo->beginTransaction();
        $stmt_update = $pdo->prepare("UPDATE evaluasi SET nilai_pretest = ?, nilai_posttest = ? WHERE id_evaluasi = ?");
        $stmt_insert = $pdo->prepare("INSERT INTO evaluasi (id_pendaftaran, nilai_pretest, nilai_posttest) VALUES (?, ?, ?)");
        
        foreach ($nilai as $id_pendaftaran => $data) {
            $pretest = !empty($data['pretest']) ? $data['pretest'] : null;
            $posttest = !empty($data['posttest']) ? $data['posttest'] : null;
            $id_evaluasi = $data['id_evaluasi'] ?? null;
            
            if ($id_evaluasi) {
                $stmt_update->execute([$pretest, $posttest, $id_evaluasi]);
            } else {
                $stmt_insert->execute([$id_pendaftaran, $pretest, $posttest]);
            }
        }
        
        $pdo->commit();
        $sukses = 'Nilai evaluasi berhasil diperbarui.';
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = 'Gagal memperbarui nilai: ' . $e->getMessage();
    }
}

try {
    $stmt_peserta = $pdo->prepare("SELECT p.nama_lengkap, p.nomor_induk, pp.id_pendaftaran, e.id_evaluasi, e.nilai_pretest, e.nilai_posttest FROM pengguna p JOIN pendaftaran_pelatihan pp ON p.id_pengguna = pp.id_pengguna LEFT JOIN evaluasi e ON pp.id_pendaftaran = e.id_pendaftaran WHERE pp.id_pelatihan = ? AND p.peran = 'mahasiswa' ORDER BY p.nama_lengkap");
    $stmt_peserta->execute([$id_pelatihan_default]);
    $daftar_peserta = $stmt_peserta->fetchAll();
    
} catch (PDOException $e) {
    $error = 'Gagal mengambil data peserta: ' . $e->getMessage();
    $daftar_peserta = [];
}
?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if ($sukses): ?>
    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo htmlspecialchars($sukses); ?></div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Input Nilai Evaluasi Peserta</h2>

    <div class="mb-4">
        <input type="text" id="pencarian-evaluasi" 
               placeholder="Cari berdasarkan nama atau NIM..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua">
    </div>

    <form action="kelola_evaluasi.php" method="POST">
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Pre-Test</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Post-Test</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tabel-evaluasi">
                    <?php foreach ($daftar_peserta as $peserta): ?>
                        <input type="hidden" name="nilai[<?php echo $peserta['id_pendaftaran']; ?>][id_evaluasi]" value="<?php echo $peserta['id_evaluasi']; ?>">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($peserta['nama_lengkap']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($peserta['nomor_induk']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <input type="number" step="0.01" min="0" max="100" name="nilai[<?php echo $peserta['id_pendaftaran']; ?>][pretest]" value="<?php echo htmlspecialchars($peserta['nilai_pretest'] ?? ''); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua text-center">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <input type="number" step="0.01" min="0" max="100" name="nilai[<?php echo $peserta['id_pendaftaran']; ?>][posttest]" value="<?php echo htmlspecialchars($peserta['nilai_posttest'] ?? ''); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua text-center">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="flex justify-end mt-6">
            <button type="submit" class="py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-200">Simpan Semua Perubahan Nilai</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-evaluasi', '#tabel-evaluasi tr', 'table-row');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>