<?php
$judul_halaman = 'Materi Pelatihan';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../konfigurasi/fungsi_umum.php';
require_once __DIR__ . '/../templat/header_mahasiswa.php';

$id_pelatihan_default = 1;
$id_pengguna = $_SESSION['id_pengguna'];
$error = '';

try {
    $stmt = $pdo->prepare("
        SELECT 
            m.id_materi, m.judul_materi, m.deskripsi_sesi, m.jadwal_sesi,
            (SELECT COUNT(*) FROM progres_materi pm WHERE pm.id_materi = m.id_materi AND pm.id_pengguna = ?) as sudah_selesai
        FROM materi m 
        WHERE m.id_pelatihan = ? 
        ORDER BY m.jadwal_sesi ASC
    ");
    $stmt->execute([$id_pengguna, $id_pelatihan_default]);
    $daftar_materi = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Gagal mengambil data materi: ' . $e->getMessage();
    $daftar_materi = [];
}
?>

<div class="p-6 h-full overflow-y-auto scrollbar-custom">

    <?php if ($error): ?>
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg animate-fade-in-up" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-center animate-fade-in-up">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Materi Pelatihan</h2>
            <p class="mt-1 text-gray-600">Selesaikan semua <?php echo count($daftar_materi); ?> materi untuk mendapatkan sertifikat.</p>
        </div>
        
        <div class="relative mt-4 md:mt-0 w-full md:w-1/3">
            <input type="text" id="pencarian-materi" 
                   placeholder="Cari materi (misal: Sesi 5, OOP, Git)..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amba-hijau-tua"
                   style="padding-left: 2.5rem;"> 
            
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>
    
    <div id="grid-materi" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        
        <?php if (empty($daftar_materi)): ?>
            <p class="text-gray-500 italic">Materi pelatihan belum tersedia.</p>
        <?php else: ?>
            <?php foreach ($daftar_materi as $index => $materi): ?>
                
                <a href="lihat_materi.php?id=<?php echo $materi['id_materi']; ?>" 
                   class="kartu-materi bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-1 animate-fade-in-up"
                   style="animation-delay: <?php echo $index * 0.05; ?>s">
                    
                    <div class="p-6 flex-1">
                        <span class="text-xs font-bold uppercase tracking-wider <?php echo $materi['sudah_selesai'] ? 'text-green-600' : 'text-amba-hijau-tua'; ?>">
                            Sesi <?php echo $index + 1; ?>
                        </span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2 mb-2"><?php echo htmlspecialchars($materi['judul_materi']); ?></h3>
                        <p class="text-gray-600 text-sm h-10">
                            <?php echo htmlspecialchars($materi['deskripsi_sesi']); ?>
                        </p>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center text-sm font-medium text-gray-500">
                            <svg class="w-5 h-5 mr-2 text-amba-hijau-tua" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Sesi Offline: <?php echo date('d F Y', strtotime($materi['jadwal_sesi'])); ?>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 border-t border-gray-100 flex justify-between items-center">
                        <?php if ($materi['sudah_selesai']): ?>
                            <span class="flex items-center text-sm font-medium text-green-600">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Selesai
                            </span>
                            <span class="py-2 px-4 rounded-md text-sm font-medium bg-white text-gray-700 border border-gray-300 hover:bg-gray-100">
                                Lihat Lagi
                            </span>
                        <?php else: ?>
                            <span class="text-sm font-medium text-gray-500">
                                Belum Mulai
                            </span>
                            <span class="py-2 px-4 rounded-md text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua transition duration-200">
                                Mulai Belajar
                            </span>
                        <?php endif; ?>
                    </div>
                </a>
                
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        siapkanPencarian('pencarian-materi', '#grid-materi .kartu-materi', 'flex');
    });
</script>

<?php
require_once __DIR__ . '/../templat/footer_mahasiswa.php';
?>