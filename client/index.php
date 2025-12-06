<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-hand-holding-dollar"></i> CatatHutang</div>
        <a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="pelanggan/pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <a href="hutang/hutang.php"><i class="fas fa-file-invoice-dollar"></i> Hutang</a>
        <a href="pembayaran/pembayaran.php"><i class="fas fa-wallet"></i> Pembayaran</a>
        <a href="user/user.php"><i class="fas fa-user"></i> User</a>
    </div>

    <div class="main-content">
        <div class="top-header">
            <div class="user-text" style="font-size: 30px; font-weight: bolder;">
                Selamat Datang
            </div>
            <div class="user-profile">
                <i class="fas fa-user-circle fa-lg"></i> Admin
            </div>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">TOTAL PELANGGAN</small>
                                <h3>20</h3>
                            </div>
                            <div class="stat-icon bg-danger"><i class="fas fa-user"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">TRANSAKSI HUTANG TERAKHIR</small>
                                <h3>500.000</h3>
                            </div>
                            <div class="stat-icon bg-warning"><i class="fa-solid fa-clock-rotate-left"></i></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">TRANSAKSI BAYAR TERAKHIR</small>
                                <h3>500.000</h3>
                            </div>
                            <div class="stat-icon bg-warning"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        </div>
                    </div>
                </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Rekapan Hutang Pelanggan</h5>
                            <button class="btn btn-primary btn-sm">See all</button>
                        </div>
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>nama Pelanggan</th>
                                    <th>Total Hutang</th>
                                    <th>Total Bayar</th>
                                    <th>Sisa Hutang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>dimas</td>
                                    <td>50.000</td>
                                    <td>40.000</td>
                                    <td class="text-danger"></i> 10.000</td>
                                </tr>
                                <tr>
                                    <td>rapi</td>
                                    <td>30.000</td>
                                    <td>17.000</td>
                                    <td class="text-danger"></i> 13.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>