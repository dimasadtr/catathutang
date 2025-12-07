<?php 
include '../config.php';

// Ambil data pelanggan dari API
$url = $base_url . "/pelanggan.php";
$response = file_get_contents($url);
$data = json_decode($response, true);

$pelanggan = $data["data"] ?? [];

//cek role user
$nama_user = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-hand-holding-dollar"></i> CatatHutang</div>
        <a href="../index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="../pelanggan/pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <a href="../hutang/hutang.php"><i class="fas fa-file-invoice-dollar"></i> Hutang</a>
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
                    <h5>Daftar Pelanggan</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Pelanggan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Id Pelanggan</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Tanggal Terdaftar</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pelanggan)): ?>
                                <?php foreach ($pelanggan as $p): ?>
                                    <tr>
                                        <td><?= $p['id_pelanggan'] ?></td>
                                        <td><?= $p['nama_pelanggan'] ?></td>
                                        <td><?= $p['alamat'] ?></td>
                                        <td><?= $p['no_hp'] ?></td>
                                        <td><?= $p['tanggal_terdaftar'] ?></td>
                                        <td><?= $p['keterangan'] ?></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-warning text-white btnEdit"
                                                data-id="<?= $p['id_pelanggan'] ?>"
                                                data-nama="<?= $p['nama_pelanggan'] ?>"
                                                data-alamat="<?= $p['alamat'] ?>"
                                                data-nohp="<?= $p['no_hp'] ?>"
                                                data-nohp="<?= $p['keterangan'] ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#ModalEdit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <a href="hapus_pelanggan.php?id=<?= $p['id_pelanggan'] ?>" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data ditemukan.</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>  
    
    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="tambah_pelanggan.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea type="text" name="keterangan" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="edit_pelanggan.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id_pelanggan" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" id="edit_nama" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="no_hp" id="edit_nohp" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Isi otomatis modal edit
        document.querySelectorAll('.btnEdit').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_nama').value = this.dataset.nama;
                document.getElementById('edit_alamat').value = this.dataset.alamat;
                document.getElementById('edit_nohp').value = this.dataset.nohp;
            });
        });
    </script>

</body>
</html>
