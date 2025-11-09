<?php
require_once __DIR__ . '/../konfigurasi/fungsi_autentikasi.php';
cek_peran('mahasiswa');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Pelatihan AMBA</title>
    
    <link href="../aset/css/output.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    
    <link rel="icon" href="../aset/img/favicon.ico" type="image/x-icon">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen bg-gray-100">
        
        <div class="fixed inset-y-0 left-0 w-64 bg-amba-hijau-tua text-white p-6 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-30">
            <a href="index.php" class="flex items-center space-x-3 mb-10">
                <img src="../aset/img/logo_amba.png" alt="Logo AMBA" class="w-10 h-auto bg-white rounded-full p-1">
                <span class="text-xl font-bold">Mahasiswa AMBA</span>
            </a>

            <nav>
                <a href="index.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-amba-hijau-muda hover:text-amba-hijau-tua">Dashboard</a>
                <a href="materi.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-amba-hijau-muda hover:text-amba-hijau-tua">Materi Pelatihan</a>
                <a href="jadwal.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-amba-hijau-muda hover:text-amba-hijau-tua">Jadwal Sesi</a>
                <a href="progres_belajar.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-amba-hijau-muda hover:text-amba-hijau-tua">Progres Belajar</a>
                <a href="sertifikat.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-amba-hijau-muda hover:text-amba-hijau-tua">Sertifikat</a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col md:ml-64">
            
            <header class="bg-white shadow-md p-4 flex justify-between items-center z-10">
                <h1 id="judul-halaman-header" class="text-2xl font-semibold text-gray-800"><?php echo $judul_halaman ?? 'Dashboard'; ?></h1>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        Halo, 
                        <span class="font-medium"><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></span>
                    </span>
                    <a href="../keluar.php" class="py-2 px-4 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200 text-sm font-medium">
                        Keluar
                    </a>
                </div>
            </header>

            <main class="flex-1 bg-gray-100 h-full overflow-hidden">