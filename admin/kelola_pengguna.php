<?php
$judul_halaman = 'Kelola Pengguna';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

// ... (KODE PHP LENGKAP ANDA DARI SEBELUMNYA) ...
// ... (Pastikan semua kode PHP (if POST, if GET 'aksi', dll) ada di sini) ...
$error = '';
$sukses = '';
$aksi = $_GET['aksi'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi_post = $_POST['aksi'] ?? '';
    
    if ($aksi_post == 'tambah') {
        $nama_lengkap = $_POST['nama_lengkap'] ?? '';
        $email = $_POST['email'] ?? '';
        $peran = $_POST['peran'] ?? '';
        $password = $_POST['password'] ?? '';
        $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
        $nomor_induk = $_POST['nomor_induk'] ?? null;

        if ($password !== $konfirmasi_password) {
            $error = 'Kata sandi dan konfirmasi kata sandi tidak cocok.';
        } else {
            // KODE LOGIN KITA TIDAK PAKAI HASH
            $stmt = $pdo->prepare("INSERT INTO pengguna (nama_lengkap, email, kata_sandi, peran, nomor_induk) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama_lengkap, $email, $password, $peran, $nomor_induk]);
            $sukses = 'Pengguna baru berhasil ditambahkan.';
        }

    } elseif ($aksi_post == 'edit') {
        $id_pengguna = $_POST['id_pengguna'] ?? 0;
        $nama_lengkap = $_POST['nama_lengkap'] ?? '';
        $email = $_POST['email'] ?? '';
        $peran = $_POST['peran'] ?? '';
        $nomor_induk = $_POST['nomor_induk'] ?? null;
        $password = $_POST['password'] ?? '';

        try {
            if (!empty($password)) {
                $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
                if ($password !== $konfirmasi_password) {
                    $error = 'Kata sandi dan konfirmasi kata sandi tidak cocok.';
                } else {
                    // KODE LOGIN KITA TIDAK PAKAI HASH
                    $stmt = $pdo->prepare("UPDATE pengguna SET nama_lengkap = ?, email = ?, peran = ?, nomor_induk = ?, kata_sandi = ? WHERE id_pengguna = ?");
                    $stmt->execute([$nama_lengkap, $email, $peran, $nomor_induk, $password, $id_pengguna]);
                    $sukses = 'Data pengguna berhasil diperbarui.';
                }
            } else {
                $stmt = $pdo->prepare("UPDATE pengguna SET nama_lengkap = ?, email = ?, peran = ?, nomor_induk = ? WHERE id_pengguna = ?");
                $stmt->execute([$nama_lengkap, $email, $peran, $nomor_induk, $id_pengguna]);
                $sukses = 'Data pengguna berhasil diperbarui.';
            }
        } catch (PDOException $e) {
             $error = 'Gagal memperbarui pengguna: ' . $e->getMessage();
        }
    }
}

if ($aksi == 'hapus') {
    $id_pengguna_hapus = $_GET['id'] ?? 0;
    if ($id_pengguna_hapus == $_SESSION['id_pengguna']) {
        $error = 'Anda tidak dapat menghapus akun Anda sendiri.';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM pengguna WHERE id_pengguna = ?");
            $stmt->execute([$id_pengguna_hapus]);
            $sukses = 'Pengguna berhasil dihapus.';
            echo "<script>window.location.href='kelola_pengguna.php?sukses=Pengguna berhasil dihapus.';</script>";
            exit;
        } catch (PDOException $e) {
            $error = 'Gagal menghapus pengguna: ' . $e->getMessage();
        }
    }
}

$pengguna_edit = null;
if ($aksi == 'edit') {
    $id_pengguna_edit = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
    $stmt->execute([$id_pengguna_edit]);
    $pengguna_edit = $stmt->fetch();
}

// Ambil semua pengguna
$stmt = $pdo->query("SELECT * FROM pengguna ORDER BY peran, nama_lengkap");
$daftar_pengguna = $stmt->fetchAll();

$sukses_get = $_GET['sukses'] ?? '';
if ($sukses_get) {
    $sukses = $sukses_get;
}

?>

<?php if ($error): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if ($sukses): ?>
    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo htmlspecialchars($sukses); ?></div>
<?php endif; ?>

<?php if ($aksi == 'tambah' || $aksi == 'edit'): ?>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6"><?php echo $aksi == 'tambah' ? 'Tambah Pengguna Baru' : 'Edit Pengguna'; ?></h2>
        <form action="kelola_pengguna.php" method="POST">
            <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
            <?php if ($aksi == 'edit'): ?><input type="hidden" name="id_pengguna" value="<?php echo htmlspecialchars($pengguna_edit['id_pengguna'] ?? ''); ?>"><?php endif; ?>
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($pengguna_edit['nama_lengkap'] ?? ''); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pengguna_edit['email'] ?? ''); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua" required>
            </div>
            <div class="mb-4">
                <label for="nomor_induk" class="block text-sm font-medium text-gray-700">Nomor Induk (NIM/NIDN)</label>
                <input type="text" id="nomor_induk" name="nomor_induk" value="<?php echo htmlspecialchars($pengguna_edit['nomor_induk'] ?? ''); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
            </div>
            <div class="mb-4">
                <label for="peran" class="block text-sm font-medium text-gray-700">Peran</label>
                <select id="peran" name="peran" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua" required>
                    <option value="mahasiswa" <?php echo ($pengguna_edit['peran'] ?? '') == 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                    <option value="admin" <?php echo ($pengguna_edit['peran'] ?? '') == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi <?php echo $aksi == 'edit' ? '(Kosongkan jika tidak ingin diubah)' : ''; ?></label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
            </div>
            <div class="mb-6">
                <label for="konfirmasi_password" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua">
            </div>
            <div class="flex items-center justify-end space-x-4">
                <a href="kelola_pengguna.php" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">Simpan Perubahan</button>
            </div>
        </form>
    </div>

<?php else: ?>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Pengguna Sistem</h2>
            <p class="text-gray-600">Total: <?php echo count($daftar_pengguna); ?> pengguna terdaftar.</p>
        </div>
        <a href="?aksi=tambah" class="mt-4 md:mt-0 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">+ Tambah Pengguna</a>
    </div>

    <div class="mb-4">
        <input type="text" id="pencarian-pengguna" 
               placeholder="Cari berdasarkan Nama, Email, atau NIM..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua">
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Induk</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-pengguna" class="bg-white divide-y divide-gray-200">
                <?php foreach ($daftar_pengguna as $pengguna): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($pengguna['nama_lengkap']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($pengguna['email']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($pengguna['nomor_induk'] ?? '-'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $pengguna['peran'] == 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>"><?php echo htmlspecialchars($pengguna['peran']); ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="?aksi=edit&id=<?php echo $pengguna['id_pengguna']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <?php if ($pengguna['id_pengguna'] != $_SESSION['id_pengguna']): ?>
                        <a href="?aksi=hapus&id=<?php echo $pengguna['id_pengguna']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-pengguna', '#tabel-pengguna tr', 'table-row');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>