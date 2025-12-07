<?php
include 'config.php';

// --- Ambil data statistik
$url_stat = $base_url . "/rekap.php";
$resp_stat = file_get_contents($url_stat);
$stat = json_decode($resp_stat, true);

// variabel card
$total_pelanggan = $stat['total_pelanggan'] ?? 0;
$last_hutang = $stat['last_hutang'] ?? 0;
$last_bayar = $stat['last_bayar'] ?? 0;

// --- Ambil data view rekap hutang
$url_rekap = $base_url . "/rekap.php";
$response_rekap = file_get_contents($url_rekap);
$rekap = json_decode($response_rekap, true);
$data_rekap = $rekap['data'] ?? [];

$nama_user = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>

?>


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

        <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="pelanggan/pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <a href="hutang/hutang.php"><i class="fas fa-file-invoice-dollar"></i> Hutang</a>
        <a href="pembayaran/pembayaran.php"><i class="fas fa-wallet"></i> Pembayaran</a>

        <?php if ($role === "admin"): ?>
            <a href="user/user.php"><i class="fas fa-user"></i> User</a>
        <?php endif; ?>

        <a href="user/login/userlogout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i>
            Logout</a>
    </div>

    <div class="main-content">
        <div class="top-header">
            <div class="user-text" style="font-size: 30px; font-weight: bolder;">
                Selamat Datang
            </div>
            <div class="user-profile">
                <i class="fas fa-user-circle fa-lg"></i>
                <?php echo ucfirst($nama_user) . " (" . $role . ")"; ?>
            </div>
        </div>

        <div class="page-content">
            <!-- Card statistik tetap seperti punya kamu -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">TOTAL PELANGGAN</small>
                                <h3><?= $total_pelanggan ?></h3>
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
                                <h3><?= number_format($last_hutang, 0, ',', '.') ?></h3>
                            </div>
                            <div class="stat-icon bg-warning"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">TRANSAKSI BAYAR TERAKHIR</small>
                                <h3><?= number_format($last_bayar, 0, ',', '.') ?></h3>
                            </div>
                            <div class="stat-icon bg-info"><i class="fa-solid fa-wallet"></i></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tabel tetap -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Rekapan Hutang Pelanggan</h5>
                            <!-- <button class="btn btn-primary btn-sm">See all</button> -->
                        </div>
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Hutang</th>
                                    <th>Total Bayar</th>
                                    <th>Sisa Hutang</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                <?php foreach ($data_rekap as $r): ?>
                                    <tr>
                                        <td><?= $r['nama_pelanggan'] ?></td>
                                        <td><?= number_format($r['total_hutang'], 0, ',', '.') ?></td>
                                        <td><?= number_format($r['total_bayar'], 0, ',', '.') ?></td>
                                        <td class="<?= $r['sisa_hutang'] > 0 ? 'text-danger' : 'text-success' ?>">
                                            <?= number_format($r['sisa_hutang'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>