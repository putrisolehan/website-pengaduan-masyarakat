<html>
    <head>
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body class="bg-light d-flex align-items-center" style="height:100vh">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-center mb-4">Admin Login</h4>

                        <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-danger">
                                Username atau password salah
                            </div>
                        <?php } ?>

                        <form action="proses_login.php" method="POST">

                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required><br>
                            </div>

                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password"  class="form-control" placeholder="Masukkan password" required><br>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center mt-3 text-muted" style="font-size:13px">
                    Sistem Pengaduan Masyarakat
                </p>

            </div>
        </div>
    </div>
    </body>
</html>