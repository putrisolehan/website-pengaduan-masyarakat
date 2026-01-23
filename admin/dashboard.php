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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/style.css">

        <script>
        let timer;
        function delaySearch() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                document.getElementById("searchForm").submit();
            }, 800);
        }
        </script>
    </head>

    <body class="bg-light">
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Dashboard Admin</h4>
            <div>
                <span class="me-2">Hi, <b><?= $_SESSION['admin_username']; ?></b></span>
                <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
            </div>
        </div>

        <hr>


        <form method="GET" id="searchForm" class="row g-2 mb-3">
            <div class="col-md-4">
                <input 
                    type="text" 
                    name="keyword" 
                    placeholder="Cari nama atau NIK"
                    value="<?= $_GET['keyword'] ?? '' ?>"
                    onkeyup="delaySearch()"
                >
            </div>
            
            <div class="col-md-3">
                <select name="status" onchange="this.form.submit()">
                    <option value="">Filter Status</option>
                    <option value="baru" <?= ($_GET['status'] ?? '') == 'baru' ? 'selected' : '' ?>>Baru</option>
                    <option value="diproses" <?= ($_GET['status'] ?? '') == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="selesai" <?= ($_GET['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>

            <div class="col-md-5 text-end">
                <a href="export_excel.php" class="btn btn-success btn-sm">Export Excel</a>
            </div>
        </form>
        
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Laporan</th>
                        <th>Status</th>
                        <th>Pilih Status</th>
                        <th>Tanggal</th>
                    </tr>
                    </thead>

                    <tbody>
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
                                <form action="update_status.php" method="POST" class="d-flex gap-1">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">

                                    <select name="status" class="form-select form-select-sm">
                                        <option value="baru" <?= $row['status'] == 'baru' ? 'selected' : '';?>>Baru</option>
                                        <option value="diproses" <?= $row['status'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                        <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>

                                    <button class="btn btn-primary btn-sm" >Update</button>
                                </form>
                            </td>
                            <td><?= $row['created_at']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

    </div>
    </body>
</html>