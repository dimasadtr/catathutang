<?php 
include '../config.php';

// Ambil data dari API hutang
$url = $base_url . "/hutang.php";
$response = file_get_contents($url);
$data = json_decode($response, true);

// data array
$hutang = $data["data"] ?? [];

// Ambil list pelanggan
$url_pelanggan = $base_url . "/pelanggan.php";
$response_pelanggan = file_get_contents($url_pelanggan);
$data_pelanggan = json_decode($response_pelanggan, true);
$pelanggan = $data_pelanggan["data"] ?? [];

//cek role user
$nama_user = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hutang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-hand-holding-dollar"></i> CatatHutang</div>
        <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="../pelanggan/pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <a href="../hutang/hutang.php" class="active"><i class="fas fa-file-invoice-dollar"></i> Hutang</a>
        <a href="../pembayaran/pembayaran.php"><i class="fas fa-wallet"></i> Pembayaran</a>
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
                    <h5>Daftar Transaksi Hutang</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Transaksi Huatng
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($hutang)): ?>
                            <?php foreach ($hutang as $h): ?>
                                <tr>
                                    <td><?= $h['id_transaksi'] ?></td>
                                    <td><?= $h['nama_pelanggan'] ?></td>
                                    <td><?= $h['tanggal_hutang'] ?></td>
                                    <td><?= number_format($h['jumlah'], 0, ',', '.') ?></td>
                                   <td><?= $h['status'] ?></td>
                                    <td><?= $h['keterangan'] ?></td>
                                    
                                    <td>
                                        <button class="btn btn-sm btn-warning text-white btnEdit"
                                            data-id="<?= $h['id_transaksi'] ?>"
                                            data-tanggal="<?= $h['tanggal_hutang'] ?>"
                                            data-jumlah="<?= $h['jumlah'] ?>"
                                            data-status="<?= $h['status'] ?>"
                                            data-ket="<?= $h['keterangan'] ?>"
                                            
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <a href="hapus_hutang.php?id=<?= $h['id_transaksi'] ?>" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data hutang.</td>
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
                <form action="tambah_hutang.php" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Transaksi Hutang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Pelanggan</label>
                            <select name="id_pelanggan" class="form-control" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama_pelanggan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal_hutang" class="form-control" required>
                        </div> -->

                        <div class="mb-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="Belum Lunas">Belum Lunas</option>
                                <option value="Lunas">Lunas</option>
                            </select>
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
                <form action="edit_hutang.php" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Transaksi Hutang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="id_transaksi" id="edit_id">

                        <div class="mb-3">
                            <label>Pelanggan</label>
                            <select name="id_pelanggan" id="edit_pelanggan" class="form-control" required>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama_pelanggan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal_hutang" id="edit_tanggal" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" id="edit_jumlah" class="form-control" required>
                        </div>
                         <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="Belum Lunas">Belum Lunas</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" id="edit_ket" class="form-control"></textarea>
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
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_pelanggan').value = this.dataset.pelanggan;
            document.getElementById('edit_tanggal').value = this.dataset.tanggal;
            document.getElementById('edit_jumlah').value = this.dataset.jumlah;
            document.getElementById('edit_ket').value = this.dataset.ket;
            document.getElementById('edit_status').value = this.dataset.status;
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
