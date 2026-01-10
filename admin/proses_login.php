<?php
session_start();
include '../config/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $admin = mysqli_fetch_assoc($result);

    if ($password === $admin['password']) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: dashboard.php");
        exit;
    }
}

header("Location: login.php");
exit;