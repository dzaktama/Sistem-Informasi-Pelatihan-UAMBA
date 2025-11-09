<?php
$judul_halaman = 'Sertifikat';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pelatihan_default = 1;
$id_pengguna = $_SESSION['id_pengguna'];
$error = '';

try {
    $stmt = $pdo->prepare("SELECT status_kelulusan, file_sertifikat FROM pendaftaran_pelatihan WHERE id_pengguna = ? AND id_pelatihan = ?");
    $stmt->execute([$id_pengguna, $id_pelatihan_default]);
    $pendaftaran = $stmt->fetch();
} catch (PDOException $e) {
    $error = 'Gagal mengambil data sertifikat: ' . $e->getMessage();
    $pendaftaran = null;
}
?>

<div class="p-6 h-full overflow-y-auto scrollbar-custom">

    <?php if ($error): ?>
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-md text-center animate-fade-in-up">
        
        <?php if ($pendaftaran && $pendaftaran['status_kelulusan'] == 'lulus'): ?>
            
            <h2 class="text-3xl font-bold text-green-600 mb-4">Selamat, Anda Lulus!</h2>
            <p class="text-gray-600 text-lg mb-8">
                Anda telah berhasil menyelesaikan Pelatihan Dasar Pemrograman. Silakan unduh sertifikat Anda.
            </p>
            
            <?php if ($pendaftaran['file_sertifikat']): ?>
                <a href="../aset/dokumen_sertifikat/<?php echo htmlspecialchars($pendaftaran['file_sertifikat']); ?>" 
                   target="_blank"
                   class="inline-block py-3 px-8 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
                    Unduh Sertifikat (PDF)
                </a>
            <?php else: ?>
                <p class="text-lg text-yellow-600 font-medium bg-yellow-100 p-4 rounded-md">
                    Sertifikat Anda sedang diproses oleh admin dan akan segera tersedia.
                </p>
            <?php endif; ?>

        <?php elseif ($pendaftaran && $pendaftaran['status_kelulusan'] == 'tidak_lulus'): ?>
            
            <h2 class="text-3xl font-bold text-red-600 mb-4">Mohon Maaf</h2>
            <p class="text-gray-600 text-lg mb-8">
                Berdasarkan hasil evaluasi, Anda dinyatakan **tidak lulus** pada pelatihan kali ini. <br>
                Tetap semangat dan jangan ragu untuk mencoba lagi di kesempatan berikutnya.
            </p>

        <?php else: ?>
            
            <h2 class="text-3xl font-bold text-blue-600 mb-4">Harap Menunggu</h2>
            <p class="text-gray-600 text-lg mb-8">
                Status kelulusan Anda masih dalam proses peninjauan oleh admin. <br>
                Silakan periksa kembali halaman ini nanti.
            </p>

        <?php endif; ?>

    </div>

</div>

<?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>