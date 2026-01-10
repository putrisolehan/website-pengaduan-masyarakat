<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
} 
?>

<html>
    <head>
        <title>Dashboard Admin</title>
    </head>
    <body>
        <h2>Welcome <?= $_SESSION['admin_username']; ?></h2>
        <a href="logout.php">Logout</a>
    </body>
</html>