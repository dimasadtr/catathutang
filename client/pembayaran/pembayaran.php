<?php
include '../config.php';

// Ambil data pembayaran
$url = $base_url . "/pembayaran.php";
$response = file_get_contents($url);
$data = json_decode($response, true);
$pembayaran = $data["data"] ?? [];

// Ambil list pelanggan
$url_pelanggan = $base_url . "/pelanggan.php";
$response_pelanggan = file_get_contents($url_pelanggan);
$data_pelanggan = json_decode($response_pelanggan, true);
$pelanggan = $data_pelanggan["data"] ?? [];

// Ambil list hutang
$url_hutang = $base_url . "/hutang.php";
$response_hutang = file_get_contents($url_hutang);
$data_hutang = json_decode($response_hutang, true);
$hutang = $data_hutang["data"] ?? [];

//cek role user
$nama_user = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-hand-holding-dollar"></i> CatatHutang</div>
        <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="../pelanggan/pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <a href="../hutang/hutang.php"><i class="fas fa-file-invoice-dollar"></i> Hutang</a>
        <a href="../pembayaran/pembayaran.php" class="active"><i class="fas fa-wallet"></i> Pembayaran</a>

        <?php if ($role === "admin"): ?>
            <a href="../user/user.php"><i class="fas fa-user"></i> User</a>
        <?php endif; ?>

        <a href="user/login/userlogout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
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
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5>Daftar Pembayaran Hutang</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Pembayaran
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>ID Transaksi Hutang</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pembayaran)): ?>
                                <?php foreach ($pembayaran as $p): ?>
                                    <tr>
                                        <td><?= $p['id_pembayaran'] ?></td>
                                        <td><?= $p['id_transaksi'] ?></td>
                                        <td><?= $p['tanggal_bayar'] ?></td>
                                        <td><?= number_format($p['jumlah_bayar'], 0, ',', '.') ?></td>
                                        <td><?= $p['metode_pembayaran'] ?></td>
                                        <td><?= $p['keterangan'] ?></td>

                                        <td>
                                            <button class="btn btn-sm btn-warning text-white btnEdit"
                                                data-id="<?= $p['id_pembayaran'] ?>" 
                                                data-transaksi="<?= $p['id_transaksi'] ?>"
                                                data-tanggal="<?= $p['tanggal_bayar'] ?>" 
                                                data-jumlah="<?= $p['jumlah_bayar'] ?>"
                                                data-metode="<?= $p['metode_pembayaran'] ?>"
                                                data-keterangan="<?= $p['keterangan'] ?>" 
                                                
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <a href="hapus_pembayaran.php?id=<?= $p['id_pembayaran'] ?>"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pembayaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="tambah_pembayaran.php" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Transaksi Hutang</label>
                            <select name="id_transaksi" class="form-control" required>
                                <option value="">Pilih Transaksi</option>
                                <?php foreach ($hutang as $h): ?>
                                    <option value="<?= $h['id_transaksi'] ?>">
                                        <?= $h['id_transaksi'] . " - " . $h['nama_pelanggan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- <div class="mb-3">
                            <label>Tanggal Pembayaran</label>
                            <input type="date" name="tanggal_bayar" class="form-control" required>
                        </div> -->

                        <div class="mb-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah_bayar" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-control">
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="edit_pembayaran.php" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="id_pembayaran" id="edit_id">

                        <div class="mb-3">
                            <label>Transaksi Hutang</label>
                            <select name="id_transaksi" id="edit_transaksi" class="form-control" required>
                                <?php foreach ($hutang as $h): ?>
                                    <option value="<?= $h['id_transaksi'] ?>">
                                        <?= $h['id_transaksi'] . " - " . $h['nama_pelanggan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal_bayar" id="edit_tanggal" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah_bayar" id="edit_jumlah" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Metode</label>
                            <select name="metode_pembayaran" id="edit_metode" class="form-control">
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-control"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btnEdit').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_transaksi').value = this.dataset.transaksi;
                document.getElementById('edit_tanggal').value = this.dataset.tanggal;
                document.getElementById('edit_jumlah').value = this.dataset.jumlah;
                document.getElementById('edit_metode').value = this.dataset.metode;
                document.getElementById('edit_keterangan').value = this.dataset.keterangan;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>