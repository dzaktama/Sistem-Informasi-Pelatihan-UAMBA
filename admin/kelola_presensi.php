<?php
$judul_halaman = 'Kelola Presensi';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

$error = '';
$sukses = '';
$id_pelatihan_default = 1;

$sesi_terpilih = $_GET['id_sesi'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_materi = $_POST['id_materi'] ?? 0;
    $presensi_data = $_POST['presensi'] ?? []; 
    
    try {
        $pdo->beginTransaction();
        
        $stmt_delete = $pdo->prepare("DELETE FROM presensi WHERE id_materi = ?");
        $stmt_delete->execute([$id_materi]);
        
        $stmt_insert = $pdo->prepare("INSERT INTO presensi (id_materi, id_pengguna, status) VALUES (?, ?, ?)");
        
        $stmt_mahasiswa = $pdo->prepare("SELECT id_pengguna FROM pendaftaran_pelatihan WHERE id_pelatihan = ?");
        $stmt_mahasiswa->execute([$id_pelatihan_default]);
        $daftar_mahasiswa = $stmt_mahasiswa->fetchAll(PDO::FETCH_COLUMN);

        foreach ($daftar_mahasiswa as $id_mahasiswa) {
            $status = (in_array($id_mahasiswa, $presensi_data)) ? 'hadir' : 'absen';
            $stmt_insert->execute([$id_materi, $id_mahasiswa, $status]);
        }
        
        $pdo->commit();
        $sukses = 'Presensi untuk sesi tersebut berhasil diperbarui.';
        $sesi_terpilih = $id_materi; 
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = 'Gagal menyimpan presensi: ' . $e->getMessage();
    }
}

try {
    $stmt_sesi = $pdo->prepare("SELECT id_materi, judul_materi FROM materi WHERE id_pelatihan = ? ORDER BY jadwal_sesi");
    $stmt_sesi->execute([$id_pelatihan_default]);
    $daftar_sesi = $stmt_sesi->fetchAll();

    $daftar_peserta = [];
    $presensi_tersimpan = [];
    
    if ($sesi_terpilih > 0) {
        $stmt_peserta = $pdo->prepare("
            SELECT p.id_pengguna, p.nama_lengkap, p.nomor_induk
            FROM pengguna p
            JOIN pendaftaran_pelatihan pp ON p.id_pengguna = pp.id_pengguna
            WHERE pp.id_pelatihan = ? AND p.peran = 'mahasiswa'
            ORDER BY p.nama_lengkap
        ");
        $stmt_peserta->execute([$id_pelatihan_default]);
        $daftar_peserta = $stmt_peserta->fetchAll();

        $stmt_presensi = $pdo->prepare("SELECT id_pengguna FROM presensi WHERE id_materi = ? AND status = 'hadir'");
        $stmt_presensi->execute([$sesi_terpilih]);
        $presensi_tersimpan = $stmt_presensi->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (PDOException $e) {
    $error = 'Gagal mengambil data: ' . $e->getMessage();
    $daftar_sesi = [];
    $daftar_peserta = [];
}
?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($sukses): ?>
    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <?php echo htmlspecialchars($sukses); ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Pilih Sesi untuk Mengelola Presensi</h2>
    
    <form action="kelola_presensi.php" method="GET" class="mb-6">
        <label for="id_sesi" class="block text-sm font-medium text-gray-700">Pilih Sesi</label>
        <div class="flex items-center space-x-2">
            <select id="id_sesi" name="id_sesi"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
                <option value="0" disabled <?php echo $sesi_terpilih == 0 ? 'selected' : ''; ?>>-- Pilih Sesi Pelatihan --</option>
                <?php foreach ($daftar_sesi as $sesi): ?>
                    <option value="<?php echo $sesi['id_materi']; ?>" <?php echo $sesi_terpilih == $sesi['id_materi'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($sesi['judul_materi']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
                Tampilkan
            </button>
        </div>
    </form>
    
    <?php if ($sesi_terpilih > 0 && !empty($daftar_peserta)): ?>
        <hr class="my-6">
        
        <form action="kelola_presensi.php?id_sesi=<?php echo $sesi_terpilih; ?>" method="POST">
            <input type="hidden" name="id_materi" value="<?php echo $sesi_terpilih; ?>">
            
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Peserta</h3>
            
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($daftar_peserta as $peserta): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($peserta['nama_lengkap']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($peserta['nomor_induk']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                                <input type="checkbox" name="presensi[]" value="<?php echo $peserta['id_pengguna']; ?>"
                                       class="h-5 w-5 text-amba-hijau-tua rounded border-gray-300 focus:ring-amba-hijau-tua"
                                       <?php echo in_array($peserta['id_pengguna'], $presensi_tersimpan) ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                    Simpan Presensi
                </button>
            </div>
        </form>
        
    <?php elseif ($sesi_terpilih > 0): ?>
        <p class="text-gray-500 italic mt-4">Belum ada peserta yang terdaftar pada pelatihan ini.</p>
    <?php endif; ?>
    
</div>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>