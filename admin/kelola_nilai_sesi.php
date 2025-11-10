<?php
$judul_halaman = 'Kelola Nilai Sesi';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

$error = '';
$sukses = '';
$id_pelatihan_default = 1;

$sesi_terpilih = $_GET['id_sesi'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_materi = $_POST['id_materi'] ?? 0;
    $nilai_data = $_POST['nilai'] ?? [];
    $catatan_data = $_POST['catatan'] ?? [];
    
    try {
        $pdo->beginTransaction();
        
        $stmt_upsert = $pdo->prepare("
            INSERT INTO nilai_sesi (id_materi, id_pengguna, nilai, catatan_instruktur)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE nilai = VALUES(nilai), catatan_instruktur = VALUES(catatan_instruktur)
        ");
        
        foreach ($nilai_data as $id_pengguna => $nilai) {
            $catatan = $catatan_data[$id_pengguna] ?? null;
            $nilai_final = !empty($nilai) ? $nilai : null;
            
            $stmt_upsert->execute([$id_materi, $id_pengguna, $nilai_final, $catatan]);
        }
        
        $pdo->commit();
        $sukses = 'Nilai untuk sesi tersebut berhasil diperbarui.';
        $sesi_terpilih = $id_materi; 
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = 'Gagal menyimpan nilai: ' . $e->getMessage();
    }
}

try {
    $stmt_sesi = $pdo->prepare("SELECT id_materi, judul_materi FROM materi WHERE id_pelatihan = ? ORDER BY jadwal_sesi");
    $stmt_sesi->execute([$id_pelatihan_default]);
    $daftar_sesi = $stmt_sesi->fetchAll();

    $daftar_peserta_nilai = [];
    
    if ($sesi_terpilih > 0) {
        $stmt_peserta = $pdo->prepare("
            SELECT p.id_pengguna, p.nama_lengkap, p.nomor_induk, ns.nilai, ns.catatan_instruktur
            FROM pengguna p
            JOIN pendaftaran_pelatihan pp ON p.id_pengguna = pp.id_pengguna
            LEFT JOIN nilai_sesi ns ON p.id_pengguna = ns.id_pengguna AND ns.id_materi = ?
            WHERE pp.id_pelatihan = ? AND p.peran = 'mahasiswa'
            ORDER BY p.nama_lengkap
        ");
        $stmt_peserta->execute([$sesi_terpilih, $id_pelatihan_default]);
        $daftar_peserta_nilai = $stmt_peserta->fetchAll();
    }
} catch (PDOException $e) {
    $error = 'Gagal mengambil data: ' . $e->getMessage();
    $daftar_sesi = [];
    $daftar_peserta_nilai = [];
}
?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if ($sukses): ?>
    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo htmlspecialchars($sukses); ?></div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Pilih Sesi untuk Mengelola Nilai Tugas/Kuis</h2>
    
    <form action="kelola_nilai_sesi.php" method="GET" class="mb-6">
        <label for="id_sesi" class="block text-sm font-medium text-gray-700">Pilih Sesi</label>
        <div class="flex items-center space-x-2">
            <select id="id_sesi" name="id_sesi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
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
    
    <?php if ($sesi_terpilih > 0 && !empty($daftar_peserta_nilai)): ?>
        <hr class="my-6">
        
        <form action="kelola_nilai_sesi.php?id_sesi=<?php echo $sesi_terpilih; ?>" method="POST">
            <input type="hidden" name="id_materi" value="<?php echo $sesi_terpilih; ?>">
            
            <div class="flex justify-between items-center mb-4">
                 <h3 class="text-xl font-semibold text-gray-800">Daftar Nilai Peserta</h3>
                 <div class="w-1/3">
                    <input type="text" id="pencarian-nilai" 
                           placeholder="Cari nama atau NIM..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua">
                </div>
            </div>
            
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">Nilai (0-100)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Instruktur</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tabel-nilai">
                        <?php foreach ($daftar_peserta_nilai as $peserta): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($peserta['nama_lengkap']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($peserta['nomor_induk']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <input type="number" step="0.01" min="0" max="100" 
                                       name="nilai[<?php echo $peserta['id_pengguna']; ?>]" 
                                       value="<?php echo htmlspecialchars($peserta['nilai'] ?? ''); ?>"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua text-center">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <input type="text" 
                                       name="catatan[<?php echo $peserta['id_pengguna']; ?>]" 
                                       value="<?php echo htmlspecialchars($peserta['catatan_instruktur'] ?? ''); ?>"
                                       placeholder="Misal: Tugas bagus!"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                    Simpan Semua Nilai
                </button>
            </div>
        </form>
        
    <?php elseif ($sesi_terpilih > 0): ?>
        <p class="text-gray-500 italic mt-4">Belum ada peserta yang terdaftar pada pelatihan ini.</p>
    <?php endif; ?>
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-nilai', '#tabel-nilai tr', 'table-row');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>