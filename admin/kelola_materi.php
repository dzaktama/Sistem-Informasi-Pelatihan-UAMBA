<?php
$judul_halaman = 'Kelola Materi';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

$error = '';
$sukses = '';
$id_pelatihan_default = 1;
$upload_dir = __DIR__ . '/../aset/dokumen_modul/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_materi = $_POST['id_materi'] ?? 0;
    
    if (isset($_FILES['file_modul']) && $_FILES['file_modul']['error'] == 0) {
        $file = $_FILES['file_modul'];
        $file_name = uniqid() . '-' . basename($file['name']);
        $target_file = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ['pdf', 'zip', 'doc', 'docx', 'ppt', 'pptx'];
        if (in_array($file_type, $allowed_types)) {
            
            try {
                $stmt_old_file = $pdo->prepare("SELECT file_modul FROM materi WHERE id_materi = ?");
                $stmt_old_file->execute([$id_materi]);
                $old_file = $stmt_old_file->fetchColumn();

                if (move_uploaded_file($file['tmp_name'], $target_file)) {
                    
                    if ($old_file && file_exists($upload_dir . $old_file)) {
                        unlink($upload_dir . $old_file);
                    }
                    
                    $stmt_update = $pdo->prepare("UPDATE materi SET file_modul = ? WHERE id_materi = ?");
                    $stmt_update->execute([$file_name, $id_materi]);
                    $sukses = 'File modul berhasil diunggah.';
                } else {
                    $error = 'Gagal memindahkan file yang diunggah.';
                }
            } catch (PDOException $e) {
                $error = 'Gagal memperbarui database: ' . $e->getMessage();
            }
        } else {
            $error = 'Tipe file tidak diizinkan. Hanya (PDF, ZIP, DOC, PPT).';
        }
    } else {
        $error = 'Terjadi kesalahan saat mengunggah atau tidak ada file yang dipilih.';
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_file') {
    $id_materi_hapus = $_GET['id'] ?? 0;
    try {
        $stmt_old_file = $pdo->prepare("SELECT file_modul FROM materi WHERE id_materi = ?");
        $stmt_old_file->execute([$id_materi_hapus]);
        $old_file = $stmt_old_file->fetchColumn();
        
        if ($old_file && file_exists($upload_dir . $old_file)) {
            unlink($upload_dir . $old_file);
        }
        
        $stmt_update = $pdo->prepare("UPDATE materi SET file_modul = NULL WHERE id_materi = ?");
        $stmt_update->execute([$id_materi_hapus]);
        
        echo "<script>window.location.href='kelola_materi.php?sukses=File modul berhasil dihapus.';</script>";
        exit;
    } catch (PDOException $e) {
        $error = 'Gagal menghapus file: ' . $e->getMessage();
    }
}

$stmt = $pdo->prepare("SELECT id_materi, judul_materi, file_modul FROM materi WHERE id_pelatihan = ? ORDER BY jadwal_sesi");
$stmt->execute([$id_pelatihan_default]);
$daftar_materi = $stmt->fetchAll();

$sukses_get = $_GET['sukses'] ?? '';
if ($sukses_get) {
    $sukses = $sukses_get;
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

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <h2 class="text-2xl font-semibold text-gray-800 p-6">Unggah Modul Materi per Sesi</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Sesi</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Modul Saat Ini</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unggah / Ganti File</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($daftar_materi as $materi): ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-top">
                    <?php echo htmlspecialchars($materi['judul_materi']); ?>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 align-top">
                    <?php if ($materi['file_modul']): ?>
                        <div class="flex items-center space-x-2">
                            <a href="../aset/dokumen_modul/<?php echo htmlspecialchars($materi['file_modul']); ?>" 
                               target="_blank" class="text-blue-600 hover:underline truncate max-w-xs">
                                <?php echo htmlspecialchars($materi['file_modul']); ?>
                            </a>
                            <a href="?aksi=hapus_file&id=<?php echo $materi['id_materi']; ?>" 
                               class="text-red-500 hover:text-red-700"
                               onclick="return confirm('Anda yakin ingin menghapus file ini?');">
                                (Hapus)
                            </a>
                        </div>
                    <?php else: ?>
                        <span class="text-gray-400 italic">Belum ada file</span>
                    <?php endif; ?>
                </td>
                
                <td class="px-6 py-4 text-sm">
                    <form action="kelola_materi.php" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                        <input type="hidden" name="id_materi" value="<?php echo $materi['id_materi']; ?>">
                        
                        <input type="file" name="file_modul" required
                               class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-amba-hijau-tua file:text-white
                                hover:file:bg-amba-hijau-muda hover:file:text-amba-hijau-tua
                                transition duration-150">
                                
                        <button type="submit" class="py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Unggah
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>