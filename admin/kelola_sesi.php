<?php
$judul_halaman = 'Kelola Sesi & Konten';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

// ... (SEMUA KODE PHP LENGKAP ANDA DARI SEBELUMNYA) ...
$error = '';
$sukses = '';
$aksi = $_GET['aksi'] ?? '';
$id_pelatihan_default = 1; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi_post = $_POST['aksi'] ?? '';
    
    $judul_materi = $_POST['judul_materi'] ?? '';
    $deskripsi_sesi = $_POST['deskripsi_sesi'] ?? '';
    $konten_web = $_POST['konten_web'] ?? '';
    $jadwal_sesi = $_POST['jadwal_sesi'] ?? '';
    
    if ($aksi_post == 'tambah') {
        try {
            $stmt = $pdo->prepare("INSERT INTO materi (id_pelatihan, judul_materi, deskripsi_sesi, konten_web, jadwal_sesi) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id_pelatihan_default, $judul_materi, $deskripsi_sesi, $konten_web, $jadwal_sesi]);
            $sukses = 'Sesi baru berhasil ditambahkan.';
        } catch (PDOException $e) {
            $error = 'Gagal menambahkan sesi: ' . $e->getMessage();
        }

    } elseif ($aksi_post == 'edit') {
        $id_materi = $_POST['id_materi'] ?? 0;
        try {
            $stmt = $pdo->prepare("UPDATE materi SET judul_materi = ?, deskripsi_sesi = ?, konten_web = ?, jadwal_sesi = ? WHERE id_materi = ?");
            $stmt->execute([$judul_materi, $deskripsi_sesi, $konten_web, $jadwal_sesi, $id_materi]);
            $sukses = 'Data sesi berhasil diperbarui.';
        } catch (PDOException $e) {
            $error = 'Gagal memperbarui sesi: ' . $e->getMessage();
        }
    }
}

if ($aksi == 'hapus') {
    $id_materi_hapus = $_GET['id'] ?? 0;
    try {
        $stmt = $pdo->prepare("DELETE FROM materi WHERE id_materi = ?");
        $stmt->execute([$id_materi_hapus]);
        echo "<script>window.location.href='kelola_sesi.php?sukses=Sesi berhasil dihapus.';</script>";
        exit;
    } catch (PDOException $e) {
        $error = 'Gagal menghapus sesi: ' . $e->getMessage();
    }
}

$sesi_edit = null;
if ($aksi == 'edit') {
    $id_materi_edit = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM materi WHERE id_materi = ?");
    $stmt->execute([$id_materi_edit]);
    $sesi_edit = $stmt->fetch();
}

$stmt = $pdo->prepare("SELECT * FROM materi WHERE id_pelatihan = ? ORDER BY jadwal_sesi");
$stmt->execute([$id_pelatihan_default]);
$daftar_sesi = $stmt->fetchAll();

$sukses_get = $_GET['sukses'] ?? '';
if ($sukses_get) {
    $sukses = $sukses_get;
}
?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if ($sukses): ?>
    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg animate-fade-in-up" role="alert"><?php echo htmlspecialchars($sukses); ?></div>
<?php endif; ?>

<?php if ($aksi == 'tambah' || $aksi == 'edit'): ?>
    
    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6"><?php echo $aksi == 'tambah' ? 'Tambah Sesi Baru' : 'Edit Sesi'; ?></h2>
        <form action="kelola_sesi.php" method="POST">
            <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
            <?php if ($aksi == 'edit'): ?><input type="hidden" name="id_materi" value="<?php echo htmlspecialchars($sesi_edit['id_materi'] ?? ''); ?>"><?php endif; ?>
            <div class="mb-4">
                <label for="judul_materi" class="block text-sm font-medium text-gray-700">Judul Sesi</label>
                <input type="text" id="judul_materi" name="judul_materi" value="<?php echo htmlspecialchars($sesi_edit['judul_materi'] ?? ''); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua" required>
            </div>
            <div class="mb-4">
                <label for="jadwal_sesi" class="block text-sm font-medium text-gray-700">Jadwal Sesi</label>
                <input type="datetime-local" id="jadwal_sesi" name="jadwal_sesi" value="<?php echo !empty($sesi_edit['jadwal_sesi']) ? date('Y-m-d\TH:i', strtotime($sesi_edit['jadwal_sesi'])) : ''; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua" required>
            </div>
            <div class="mb-4">
                <label for="deskripsi_sesi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat (Tampil di daftar materi)</label>
                <textarea id="deskripsi_sesi" name="deskripsi_sesi" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua"><?php echo htmlspecialchars($sesi_edit['deskripsi_sesi'] ?? ''); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="konten_web" class="block text-sm font-medium text-gray-700">Konten Materi (Bisa diisi HTML)</label>
                <textarea id="konten_web" name="konten_web" rows="15" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua font-mono"><?php echo htmlspecialchars($sesi_edit['konten_web'] ?? ''); ?></textarea>
                <p class="mt-2 text-xs text-gray-500">Anda bisa menggunakan tag HTML di sini, contoh: &lt;h1&gt;Judul&lt;/h1&gt;, &lt;p&gt;Paragraf.&lt;/p&gt;, &lt;pre&gt;&lt;code class="language-python"&gt;...&lt;/code&gt;&lt;/pre&gt; untuk kode.</p>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <a href="kelola_sesi.php" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">Simpan Sesi</button>
            </div>
        </form>
    </div>

<?php else: ?>

    <div class="flex justify-between items-center mb-6 animate-fade-in-up">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Sesi Pelatihan</h2>
        <a href="?aksi=tambah" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">+ Tambah Sesi</a>
    </div>
    
    <div class="mb-4">
        <input type="text" id="pencarian-sesi" 
               placeholder="Cari berdasarkan judul sesi atau tanggal..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua">
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto animate-fade-in-up">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Sesi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konten Web</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="tabel-sesi">
                <?php foreach ($daftar_sesi as $sesi): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($sesi['judul_materi']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars(date('d M Y, H:i', strtotime($sesi['jadwal_sesi']))); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <?php if (!empty($sesi['konten_web'])): ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sudah Terisi</span>
                        <?php else: ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Kosong</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="?aksi=edit&id=<?php echo $sesi['id_materi']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <a href="?aksi=hapus&id=<?php echo $sesi['id_materi']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus sesi ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-sesi', '#tabel-sesi tr', 'table-row');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>