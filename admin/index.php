<?php
$judul_halaman = 'Dashboard';
require_once __DIR__ . '/../konfigurasi/koneksi_db.php';
require_once __DIR__ . '/../templat/header_admin.php';

try {
    $stmt_mhs = $pdo->query("SELECT COUNT(id_pengguna) FROM pengguna WHERE peran = 'mahasiswa'");
    $jumlah_mahasiswa = $stmt_mhs->fetchColumn();

    $stmt_sesi = $pdo->query("SELECT COUNT(id_materi) FROM materi");
    $jumlah_sesi = $stmt_sesi->fetchColumn();
    
    $stmt_lulus = $pdo->query("SELECT COUNT(id_pendaftaran) FROM pendaftaran_pelatihan WHERE status_kelulusan = 'lulus'");
    $jumlah_lulus = $stmt_lulus->fetchColumn();

} catch (PDOException $e) {
    $jumlah_mahasiswa = 0;
    $jumlah_sesi = 0;
    $jumlah_lulus = 0;
}
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Mahasiswa</h3>
                <span class="text-4xl font-bold text-gray-900 mt-2 block"><?php echo $jumlah_mahasiswa; ?></span>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <svg style="width: 1.75rem; height: 1.75rem;" class="text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Sesi Pelatihan</h3>
                <span class="text-4xl font-bold text-gray-900 mt-2 block"><?php echo $jumlah_sesi; ?></span>
            </div>
            <div class="p-3 bg-amba-hijau-muda/20 rounded-full">
                <svg style="width: 1.75rem; height: 1.75rem;" class="text-amba-hijau-tua" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in-up" style="animation-delay: 0.3s;">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Mahasiswa Lulus</h3>
                <span class="text-4xl font-bold text-gray-900 mt-2 block"><?php echo $jumlah_lulus; ?></span>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg style="width: 1.75rem; height: 1.75rem;" class="text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.75V14z"></path><path d="M12 14V21.75c-2.313-.98-4.287-2.587-5.545-4.581L12 14z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="animate-fade-in-up" style="animation-delay: 0.4s;">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Akses Cepat (Tugas Harian)</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <a href="kelola_pengguna.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.37M13 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a6 6 0 00-6 6v2h12v-2a6 6 0 00-6-6z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Kelola Pengguna</h4>
                    <p class="text-sm text-gray-500">Tambah/edit akun mahasiswa.</p>
                </div>
            </div>
        </a>

        <a href="kelola_sesi.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-amba-hijau-muda/20 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-amba-hijau-tua" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Kelola Sesi & Konten</h4>
                    <p class="text-sm text-gray-500">Atur jadwal dan isi materi online.</p>
                </div>
            </div>
        </a>

        <a href="kelola_presensi.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-green-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Input Presensi</h4>
                    <p class="text-sm text-gray-500">Catat kehadiran sesi offline.</p>
                </div>
            </div>
        </a>

        <a href="kelola_nilai_sesi.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Input Nilai Sesi</h4>
                    <p class="text-sm text-gray-500">Beri nilai untuk tugas/kuis.</p>
                </div>
            </div>
        </a>

    </div>
</div>

<div class="mt-8 animate-fade-in-up" style="animation-delay: 0.5s;">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Administrasi & Pelaporan</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <a href="kelola_evaluasi.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-indigo-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17H5M13 7v0a4 4 0 00-4-4H5a4 4 0 00-4 4v0" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17H5M9 7v0a4 4 0 00-4-4H5a4 4 0 00-4 4v0" /><circle cx="17" cy="5" r="2" /><path d="M17 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><path d="M17 17H5" /><path d="M17 7v0a4 4 0 00-4-4H5a4 4 0 00-4 4v0" /></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Nilai Pre/Post Test</h4>
                    <p class="text-sm text-gray-500">Input nilai ujian awal & akhir.</p>
                </div>
            </div>
        </a>

        <a href="kelola_sertifikat.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-red-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Kelola Sertifikat</h4>
                    <p class="text-sm text-gray-500">Unggah & atur kelulusan.</p>
                </div>
            </div>
        </a>

        <a href="laporan_progres.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-purple-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Laporan Progres</h4>
                    <p class="text-sm text-gray-500">Lihat progres online mhs.</p>
                </div>
            </div>
        </a>

        <a href="laporan_akhir.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-gray-200 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm7-16V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 16h6"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Laporan Akhir (Cetak)</h4>
                    <p class="text-sm text-gray-500">Lihat rekapitulasi akhir.</p>
                </div>
            </div>
        </a>
        
        <a href="kelola_materi.php" class="block bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 p-3 bg-pink-100 rounded-full">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Kelola Modul (File)</h4>
                    <p class="text-sm text-gray-500">Unggah file PDF/ZIP materi.</p>
                </div>
            </div>
        </a>

    </div>
</div>

<?php
require_once __DIR__ . '/../templat/footer_admin.php';
?>