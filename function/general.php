<?php

function base_url($path = null)
{
    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $path;
}

function tanggal($tanggal)
{
    $bulan = array(
        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    );

    return date('d', strtotime($tanggal)) . ' ' . $bulan[(int)date('m', strtotime($tanggal))] . ' ' . date('Y', strtotime($tanggal));
}

function rupiah($angka)
{
    return "Rp. " . number_format($angka, 2, ',', '.');
}

function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
