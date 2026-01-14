<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
} 

include '../config/database.php';

$query = "SELECT * FROM pengaduan ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<html>
    <head>
        <title>Dashboard Admin</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <h2>Welcome <?= $_SESSION['admin_username']; ?></h2>
        <a href="logout.php">Logout</a>

        <hr>

        <h3>Daftar Pengaduan</h3>

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Laporan</th>
                <th>Status</th>
                <th>Pilih Status</th>
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
                    <td>
                        <span class="badge <?= $row['status']; ?>">
                            <?= ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td>
                        <form action="update_status.php" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">

                            <select name="status" >
                                <option value="baru" <?= $row['status'] == 'baru' ? 'selected' : '';?>>Baru</option>
                                <option value="diproses" <?= $row['status'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            </select>

                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td><?= $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <a href="export_excel.php">Export Excel</a>
    </body>
</html>