<?php
session_start();

if(!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

include "../config/database.php";

$id = $_POST['id'];
$status = $_POST['status'];

$query = "UPDATE pengaduan SET status = '$status' WHERE id='$id'";
mysqli_query($conn, $query);

header("Location: dashboard.php");
exit;