<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
} 

include '../config/database.php';

$status = isset($_GET['status']) ? $_GET['status'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$query = "SELECT * FROM pengaduan";

$conditions = [];

if ($status != '') {
    $conditions[] = "status = '$status'";
}

if ($keyword != '') {
    $conditions[] = "(nama LIKE '%$keyword%' OR nik LIKE '%$keyword%')";
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<html>
    <head>
        <title>Dashboard Admin</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <script>
            function submitSearch() {
                document.getElementById("searchForm").submit();
            }
        </script>
    </head>
    <body>
        <h2>Welcome <?= $_SESSION['admin_username']; ?></h2>
        <a href="logout.php">Logout</a>

        <hr>

        <h3>Daftar Pengaduan</h3>

        <form method="GET" id="searchForm">
            <input 
                type="text" 
                name="keyword" 
                placeholder="Cari nama atau NIK"
                value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"
                onkeyup="submitSearch()"
            >
        </form>

        <form method="GET">
            <select name="status" onchange="this.form.submit()">
                <option value="">Filter Status</option>
                <option value="baru" <?= (isset($_GET['status']) && $_GET['status'] == 'baru') ? 'selected' : '' ?>>Baru</option>
                <option value="diproses" <?= (isset($_GET['status']) && $_GET['status'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                <option value="selesai" <?= (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
            </select>
        </form>
        

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