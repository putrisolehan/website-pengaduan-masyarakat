<html>
    <head>
        <title>Submit Complaint</title>
    </head>
    <body>
        <h2>Form Pengaduan</h2>
        <form action="proses_pengaduan.php" method="POST">
            <input type="text" name="nik" placeholder="NIK" required><br>
            <input type="text" name="nama" placeholder="Nama" required><br>
            <textarea name="laporan" placeholder="Isi Laporan" required></textarea><br>
            <button type="submit">Kirim</button>
        </form>
    </body>
</html>