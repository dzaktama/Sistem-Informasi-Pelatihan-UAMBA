<?php
$judul_halaman = 'Kelola Sertifikat';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

$error = '';
$sukses = '';
$id_pelatihan_default = 1;
$upload_dir = __DIR__ . '/../aset/dokumen_sertifikat/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'atur_status') {
        $id_pendaftaran = $_POST['id_pendaftaran'] ?? 0;
        $status_kelulusan = $_POST['status_kelulusan'] ?? 'terdaftar';

        try {
            $stmt = $pdo->prepare("UPDATE pendaftaran_pelatihan SET status_kelulusan = ? WHERE id_pendaftaran = ?");
            $stmt->execute([$status_kelulusan, $id_pendaftaran]);
            $sukses = 'Status kelulusan berhasil diperbarui.';
        } catch (PDOException $e) {
            $error = 'Gagal memperbarui status: ' . $e->getMessage();
        }

    } elseif (isset($_FILES['file_sertifikat'])) {
        $id_pendaftaran = $_POST['id_pendaftaran'] ?? 0;
        
        $file = $_FILES['file_sertifikat'];
        if ($file['error'] == 0) {
            $file_name = uniqid() . '-' . basename($file['name']);
            $target_file = $upload_dir . $file_name;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if ($file_type == 'pdf') {
                try {
                    $stmt_old = $pdo->prepare("SELECT file_sertifikat FROM pendaftaran_pelatihan WHERE id_pendaftaran = ?");
                    $stmt_old->execute([$id_pendaftaran]);
                    $old_file = $stmt_old->fetchColumn();

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {
                        if ($old_file && file_exists($upload_dir . $old_file)) {
                            unlink($upload_dir . $old_file);
                        }
                        
                        $stmt_update = $pdo->prepare("UPDATE pendaftaran_pelatihan SET file_sertifikat = ? WHERE id_pendaftaran = ?");
                        $stmt_update->execute([$file_name, $id_pendaftaran]);
                        $sukses = 'File sertifikat berhasil diunggah.';
                    } else {
                        $error = 'Gagal memindahkan file.';
                    }
                } catch (PDOException $e) {
                    $error = 'Gagal update database: ' . $e->getMessage();
                }
            } else {
                $error = 'File harus berformat PDF.';
            }
        } else {
            $error = 'Gagal mengunggah file. Error code: ' . $file['error'];
        }
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_file') {
    $id_pendaftaran_hapus = $_GET['id'] ?? 0;
    try {
        $stmt_old = $pdo->prepare("SELECT file_sertifikat FROM pendaftaran_pelatihan WHERE id_pendaftaran = ?");
        $stmt_old->execute([$id_pendaftaran_hapus]);
        $old_file = $stmt_old->fetchColumn();
        
        if ($old_file && file_exists($upload_dir . $old_file)) {
            unlink($upload_dir . $old_file);
        }
        
        $stmt_update = $pdo->prepare("UPDATE pendaftaran_pelatihan SET file_sertifikat = NULL WHERE id_pendaftaran = ?");
        $stmt_update->execute([$id_pendaftaran_hapus]);
        
        echo "<script>window.location.href='kelola_sertifikat.php?sukses=File sertifikat berhasil dihapus.';</script>";
        exit;
    } catch (PDOException $e) {
        $error = 'Gagal menghapus file: ' . $e->getMessage();
    }
}


try {
    $stmt_peserta = $pdo->prepare("
        SELECT 
            p.nama_lengkap, p.nomor_induk, 
            pp.id_pendaftaran, pp.status_kelulusan, pp.file_sertifikat
        FROM pengguna p
        JOIN pendaftaran_pelatihan pp ON p.id_pengguna = pp.id_pengguna
        WHERE pp.id_pelatihan = ? AND p.peran = 'mahasiswa'
        ORDER BY p.nama_lengkap
    ");
    $stmt_peserta->execute([$id_pelatihan_default]);
    $daftar_peserta = $stmt_peserta->fetchAll();
} catch (PDOException $e) {
    $error = 'Gagal mengambil data peserta: ' . $e->getMessage();
    $daftar_peserta = [];
}

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

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Kelola Kelulusan dan Sertifikat Peserta</h2>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & NIM</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kelulusan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Sertifikat (PDF)</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unggah File</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($daftar_peserta as $peserta): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($peserta['nama_lengkap']); ?></div>
                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($peserta['nomor_induk']); ?></div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <form action="kelola_sertifikat.php" method="POST" class="flex items-center space-x-2">
                            <input type="hidden" name="aksi" value="atur_status">
                            <input type="hidden" name="id_pendaftaran" value="<?php echo $peserta['id_pendaftaran']; ?>">
                            <select name="status_kelulusan" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
                                <option value="terdaftar" <?php echo $peserta['status_kelulusan'] == 'terdaftar' ? 'selected' : ''; ?>>Terdaftar</option>
                                <option value="lulus" <?php echo $peserta['status_kelulusan'] == 'lulus' ? 'selected' : ''; ?>>Lulus</option>
                                <option value="tidak_lulus" <?php echo $peserta['status_kelulusan'] == 'tidak_lulus' ? 'selected' : ''; ?>>Tidak Lulus</option>
                            </select>
                            <button type="submit" class="py-1 px-3 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan</button>
                        </form>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 align-top">
                        <?php if ($peserta['file_sertifikat']): ?>
                            <div class="flex items-center space-x-2">
                                <a href="../aset/dokumen_sertifikat/<?php echo htmlspecialchars($peserta['file_sertifikat']); ?>" 
                                   target="_blank" class="text-blue-600 hover:underline truncate max-w-xs">
                                    Lihat Sertifikat
                                </a>
                                <a href="?aksi=hapus_file&id=<?php echo $peserta['id_pendaftaran']; ?>" 
                                   class="text-red-500 hover:text-red-700"
                                   onclick="return confirm('Anda yakin ingin menghapus file ini?');">
                                   (Hapus)
                                </a>
                            </div>
                        <?php else: ?>
                            <span class="text-gray-400 italic">Belum ada file</span>
                        <?php endif; ?>
                    </td>

                    <td class="px-6 py-4 text-sm align-top">
                        <form action="kelola_sertifikat.php" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                            <input type="hidden" name="id_pendaftaran" value="<?php echo $peserta['id_pendaftaran']; ?>">
                            <input type="file" name="file_sertifikat" required accept=".pdf"
                                   class="block w-full text-sm text-gray-500
                                    file:mr-2 file:py-1 file:px-2
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-amba-hijau-tua file:text-white
                                    hover:file:bg-amba-hijau-muda hover:file:text-amba-hijau-tua
                                    transition duration-150">
                            <button type="submit" class="py-1 px-3 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Unggah</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>