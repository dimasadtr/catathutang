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
        <div class="brand"><i class="fas fa-layer-group"></i> CatatHutang</div>
        <a href="../index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="../pelanggan/pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <a href="../hutang/hutang.php"><i class="fas fa-file-invoice-dollar"></i> Hutang</a>
        <a href="pembayaran.php" class="active"><i class="fas fa-wallet"></i> Pembayaran</a>
        <a href="../user/user.php"><i class="fas fa-user"></i> User</a>
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
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5>Daftar Transaksi Pembayaran</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Pembayaran
                    </button>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control w-25" placeholder="Cari nama...">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Id Pembayaran</th>
                                <th>Id Transaksi</th>
                                <th>tanggal Bayar</th>
                                <th>Jumlah</th>
                                <th>Uang Tunai</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Budi Santoso</td>
                                <td>10-10-2010</td>
                                <td>100.000</td>
                                <td>Minyak dll</td>
                                <td>Belum Lunas</td>
                                <td>1</td>
                                <td>
                                    <button class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="number" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>