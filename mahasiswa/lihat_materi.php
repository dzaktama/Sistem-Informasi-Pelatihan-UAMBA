<?php
// Menampilkan error jika ada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$judul_halaman = 'Materi Pembelajaran';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';

// Cek dulu header_mahasiswa.php sebelum memanggilnya
try {
    require_once __DIR__ . '/../templat/header_mahasiswa.php';
} catch (Exception $e) {
    die("Fatal error: Gagal memuat header. Pastikan file /templat/header_mahasiswa.php ada. Error: " . $e->getMessage());
}

$id_pengguna = $_SESSION['id_pengguna'];
$id_materi_saat_ini = $_GET['id'] ?? 0;
$id_pelatihan_default = 1;
$error = '';
$sukses = '';

if ($id_materi_saat_ini == 0) {
    echo "<script>window.location.href='materi.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'selesai') {
    try {
        $stmt_cek = $pdo->prepare("SELECT id_progres FROM progres_materi WHERE id_pengguna = ? AND id_materi = ?");
        $stmt_cek->execute([$id_pengguna, $id_materi_saat_ini]);
        
        if ($stmt_cek->fetch() === false) {
            $stmt_insert = $pdo->prepare("INSERT INTO progres_materi (id_pengguna, id_materi) VALUES (?, ?)");
            $stmt_insert->execute([$id_pengguna, $id_materi_saat_ini]);
            $sukses = 'Materi berhasil ditandai selesai!';
        }
    } catch (PDOException $e) {
        $error = "Gagal menyimpan progres: " . $e->getMessage();
    }
}

try {
    // 1. Ambil SEMUA materi untuk sidebar
    $stmt_semua = $pdo->prepare("
        SELECT 
            m.id_materi, m.judul_materi,
            (SELECT COUNT(*) FROM progres_materi pm WHERE pm.id_materi = m.id_materi AND pm.id_pengguna = ?) as sudah_selesai
        FROM materi m 
        WHERE m.id_pelatihan = ? 
        ORDER BY m.jadwal_sesi ASC
    ");
    $stmt_semua->execute([$id_pengguna, $id_pelatihan_default]);
    $semua_materi = $stmt_semua->fetchAll();

    // 2. Ambil detail materi SAAT INI
    $stmt_current = $pdo->prepare("SELECT * FROM materi WHERE id_materi = ?");
    $stmt_current->execute([$id_materi_saat_ini]);
    $materi = $stmt_current->fetch();

    if (!$materi) {
        echo "<script>window.location.href='materi.php';</script>";
        exit();
    }

    // 3. Cek status selesai materi SAAT INI
    $stmt_progres = $pdo->prepare("SELECT id_progres FROM progres_materi WHERE id_pengguna = ? AND id_materi = ?");
    $stmt_progres->execute([$id_pengguna, $id_materi_saat_ini]);
    $sudah_selesai = $stmt_progres->fetch();

    // 4. Cari materi Sebelumnya & Berikutnya
    $prev_materi = null;
    $next_materi = null;
    $total_selesai = 0;
    foreach ($semua_materi as $index => $sesi) {
        if ($sesi['sudah_selesai']) {
            $total_selesai++;
        }
        if ($sesi['id_materi'] == $id_materi_saat_ini) {
            if (isset($semua_materi[$index - 1])) {
                $prev_materi = $semua_materi[$index - 1];
            }
            if (isset($semua_materi[$index + 1])) {
                $next_materi = $semua_materi[$index + 1];
            }
            break;
        }
    }
    
    // 5. Hitung progres
    $total_materi_count = count($semua_materi);
    $persen_progres = ($total_materi_count > 0) ? ($total_selesai / $total_materi_count) * 100 : 0;


} catch (PDOException $e) {
    $error = 'Gagal mengambil data materi: ' . $e->getMessage();
    $materi = null;
    $semua_materi = [];
    $sudah_selesai = false;
    $prev_materi = null;
    $next_materi = null;
    $persen_progres = 0;
}

// Set ulang judul halaman di header
if ($materi) {
    $judul_halaman = $materi['judul_materi'];
    echo "<script>document.title = '" . htmlspecialchars($judul_halaman) . " - Pelatihan AMBA';</script>";
    echo "<script>document.getElementById('judul-halaman-header').innerText = '" . htmlspecialchars($judul_halaman) . "';</script>";
}
?>

<?php if ($materi): ?>
<div class="flex flex-col h-full animate-fade-in-up">
    
    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
        <div class="bg-amba-hijau-tua h-2.5 rounded-full transition-all duration-500" style="width: <?php echo $persen_progres; ?>%"></div>
        <p class="text-xs font-medium text-gray-600 text-right mt-1"><?php echo $total_selesai; ?> dari <?php echo $total_materi_count; ?> materi selesai (<?php echo round($persen_progres); ?>%)</p>
    </div>
    
    <div class="flex-1 flex overflow-hidden">
        <aside class="w-1/3 xl:w-1/4 bg-white rounded-lg shadow-md p-4 overflow-y-auto scrollbar-custom">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Sesi Pelatihan</h3>
            <nav class="space-y-2">
                <?php foreach ($semua_materi as $sesi_nav): ?>
                    <?php
                        $is_active = ($sesi_nav['id_materi'] == $id_materi_saat_ini);
                        $active_class = $is_active ? 'bg-amba-hijau-muda/30 border-amba-hijau-tua' : 'border-transparent hover:bg-gray-100';
                    ?>
                    <a href="lihat_materi.php?id=<?php echo $sesi_nav['id_materi']; ?>"
                       class="flex items-center p-3 rounded-lg border-l-4 <?php echo $active_class; ?> transition-colors duration-150">
                        
                        <?php if ($sesi_nav['sudah_selesai']): ?>
                            <span class="w-5 h-5 bg-green-500 rounded-full text-white flex items-center justify-center text-xs mr-3 flex-shrink-0">✓</span>
                        <?php else: ?>
                            <span class="w-5 h-5 bg-gray-300 rounded-full mr-3 flex-shrink-0"></span>
                        <?php endif; ?>
                        
                        <span class="text-sm font-medium <?php echo $is_active ? 'text-amba-hijau-tua' : 'text-gray-700'; ?>">
                            <?php echo htmlspecialchars($sesi_nav['judul_materi']); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="flex-1 px-6 overflow-y-auto scrollbar-custom">
            <div class="bg-white p-6 md:p-8 rounded-lg shadow-md">
                
                <div class="mb-6 border-b pb-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900"><?php echo htmlspecialchars($materi['judul_materi']); ?></h1>
                    <p class="text-gray-500 mt-2">
                        Jadwal Sesi Offline: <?php echo format_tanggal_indonesia($materi['jadwal_sesi']); ?>
                    </p>
                </div>
                
                <?php if ($error): ?>
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if ($sukses): ?>
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo htmlspecialchars($sukses); ?></div>
                <?php endif; ?>

                <div class="prose prose-lg max-w-none prose-h1:text-amba-hijau-tua prose-code:font-mono prose-code:text-sm prose-pre:font-mono prose-pre:text-sm">
                    <?php
                    if (empty($materi['konten_web'])) {
                        echo '<p class="text-gray-500 italic">Konten untuk materi ini belum tersedia. Silakan cek kembali nanti.</p>';
                    } else {
                        // Ini akan merender HTML dan Prism.js akan mewarnainya secara otomatis
                        echo $materi['konten_web'];
                    }
                    ?>
                </div>

                <hr class="my-8">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <?php if ($prev_materi): ?>
                        <a href="lihat_materi.php?id=<?php echo $prev_materi['id_materi']; ?>"
                           class="w-full md:w-auto py-3 px-6 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-200 text-center">
                            &larr; Materi Sebelumnya
                        </a>
                    <?php else: ?>
                        <span class="w-full md:w-auto py-3 px-6 border border-gray-200 rounded-md text-base font-medium text-gray-400 bg-gray-100 cursor-not-allowed text-center">
                            &larr; Materi Sebelumnya
                        </span>
                    <?php endif; ?>

                    <?php if (!$sudah_selesai && !empty($materi['konten_web'])): ?>
                        <form action="lihat_materi.php?id=<?php echo $id_materi_saat_ini; ?>" method="POST" class="w-full md:w-auto">
                            <input type="hidden" name="aksi" value="selesai">
                            <button typeT="submit"
                                    class="w-full py-3 px-6 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-green-600 hover:bg-green-700 transition duration-200">
                                Tandai Selesai & Lanjutkan &rarr;
                            </button>
                        </form>
                    <?php elseif ($next_materi): ?>
                         <a href="lihat_materi.php?id=<?php echo $next_materi['id_materi']; ?>"
                           class="w-full md:w-auto py-3 px-6 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200 text-center">
                            Materi Berikutnya &rarr;
                        </a>
                    <?php else: ?>
                        <span class="w-full md:w-auto py-3 px-6 rounded-md text-lg font-medium text-green-800 bg-green-100 text-center">
                            ✓ Semua Materi Selesai!
                        </span>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php endif; // Akhir dari if ($materi) ?>

<?php
// HAPUS footer_mahasiswa.php dari sini
// require_once __DIR__ . '/../templat/footer_mahasiswa.php';
// Kita tutup tag di file footer utama, bukan di sini.
?>