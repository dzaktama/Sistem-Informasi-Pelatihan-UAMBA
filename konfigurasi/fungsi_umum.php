<?php
function format_tanggal_indonesia($tanggal) {
    if (empty($tanggal) || $tanggal === '0000-00-00 00:00:00') {
        return '-';
    }
    
    $timestamp = strtotime($tanggal);
    if ($timestamp === false) {
        return '-';
    }

    $hari_array = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    
    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $hari = $hari_array[date('l', $timestamp)];
    $tanggal_angka = date('d', $timestamp);
    $bulan = $bulan_array[(int)date('m', $timestamp)];
    $tahun = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);

    return "$hari, $tanggal_angka $bulan $tahun - $jam WIB";
}
?>