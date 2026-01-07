<?php
include 'config/database.php';

$nama = $_POST['nama'];
$nik = $_POST['nik'];
$laporan = $_POST['laporan'];

$query = "INSERT INTO pengaduan (nama, nik, laporan)
          VALUES ('$nama', '$nik', '$laporan')";

mysqli_query($conn, $query);

header("Location: index.php");