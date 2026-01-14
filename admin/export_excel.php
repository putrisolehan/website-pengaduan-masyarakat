<?php
session_start();

// proteksi admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

include "../config/database.php";

/*
  Header ini ngasih tau browser:
  - ini file Excel
  - nama filenya apa
*/
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=pengaduan.xls");

// ambil data pengaduan
$query = "SELECT * FROM pengaduan ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIK</th>
        <th>Laporan</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>

    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['nik']; ?></td>
        <td><?= $row['laporan']; ?></td>
        <td><?= $row['status']; ?></td>
        <td><?= $row['created_at']; ?></td>
    </tr>
    <?php } ?>
</table>