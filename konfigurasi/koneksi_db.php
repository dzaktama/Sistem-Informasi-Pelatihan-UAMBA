<?php
$host_db = 'localhost';
$nama_db = 'db_pelatihan_amba';
$user_db = 'root';
$pass_db = '';

try {
    $pdo = new PDO(
        "mysql:host=$host_db;dbname=$nama_db;charset=utf8mb4", 
        $user_db, 
        $pass_db
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>