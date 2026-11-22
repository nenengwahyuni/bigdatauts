<?php
// file: koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "myperpus";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database myperpus gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
?>