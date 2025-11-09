<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function cek_login() {
    if (!isset($_SESSION['id_pengguna'])) {
        header("Location: ../masuk.php");
        exit();
    }
}

function cek_peran($peran_diizinkan) {
    cek_login();
    if (!is_array($peran_diizinkan)) {
        $peran_diizinkan = [$peran_diizinkan];
    }
    
    if (!in_array($_SESSION['peran'], $peran_diizinkan)) {
        header("Location: ../masuk.php"); 
        exit();
    }
}

function sudah_login() {
    if (isset($_SESSION['id_pengguna'])) {
        if ($_SESSION['peran'] == 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: mahasiswa/index.php");
        }
        exit();
    }
}
?>