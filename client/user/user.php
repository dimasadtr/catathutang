<?php
include '../config.php';

// Ambil data user dari API
$url = $base_url . "/user.php";
$response = @file_get_contents($url);
$data = json_decode($response, true);

// Jika API gagal
$user = $data["data"] ?? [];

// tampilkan alert jika ada response di session
$alert_html = '';
if (!empty($_SESSION['api_response'])) {
    $raw = $_SESSION['api_response'];
    $decoded = json_decode($raw, true);
    if (is_array($decoded) && isset($decoded['status'])) {
        $cls = $decoded['status'] === 'success' ? 'alert-success' : 'alert-danger';
        $msg = $decoded['message'] ?? json_encode($decoded['data'] ?? $decoded);
    } else {
        $cls = 'alert-info';
        $msg = is_string($raw) ? $raw : json_encode($raw);
    }
    $alert_html = "<div class=\"alert $cls alert-dismissible\" role=\"alert\">" . htmlspecialchars($msg) . "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>";
    unset($_SESSION['api_response']);
}

//cek role user
$nama_user = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
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
        <a href="../pembayaran/pembayaran.php"><i class="fas fa-wallet"></i> Pembayaran</a>
        <?php if ($role === "admin"): ?>
            <a href="user.php"><i class="fas fa-user"></i> User</a>
        <?php endif; ?>
        <a href="login/userlogout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
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

        <div class="page-content container-fluid">
            <?php if ($alert_html): ?>
                <?= $alert_html ?>
            <?php endif; ?>

            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5>Daftar User</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID User</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($user)): ?>
                                <?php foreach ($user as $u): ?>
                                    <tr>
                                        <?php
                                            // Normalisasi label role untuk tampilan dan modal
                                            $rawRole = $u['role'];
                                            $role_label = '';
                                            if (is_numeric($rawRole)) {
                                                $role_label = ((int)$rawRole === 1) ? 'Admin' : 'Pegawai';
                                            } else {
                                                $rr = strtolower(trim($rawRole));
                                                if ($rr === 'admin' || $rr === 'administrator' || $rr === '1') {
                                                    $role_label = 'Admin';
                                                } elseif ($rr === 'user' || $rr === 'pegawai' || $rr === '0' || $rr === '') {
                                                    $role_label = 'Pegawai';
                                                } else {
                                                    // fallback: ucfirst string
                                                    $role_label = ucfirst($rawRole);
                                                }
                                            }
                                        ?>
                                        <td><?= htmlspecialchars($u['id_user']) ?></td>
                                        <td><?= htmlspecialchars($u['nama']) ?></td>
                                        <td><?= htmlspecialchars($u['username']) ?></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td><?= htmlspecialchars($role_label) ?></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-warning text-white btnEdit"
                                                
                                                data-nama="<?= htmlspecialchars($u['nama']) ?>"
                                                data-username="<?= htmlspecialchars($u['username']) ?>"
                                                data-email="<?= htmlspecialchars($u['email']) ?>"
                                                data-role="<?= htmlspecialchars($role_label) ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#ModalEdit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <a href="hapus_user.php?id=<?= urlencode($u['id_user']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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

                <form action="tambah_user.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- <div class="mb-3">
                            <label class="form-label">ID User </label>
                            <input type="text" name="id_user" class="form-control" placeholder="Biarkan kosong untuk auto-increment">
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="Pegawai">Pegawai</option>
                            </select>
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

                <form action="edit_user.php" method="POST">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div> -->

                    <div class="modal-body">
                        <input type="hidden" name="id_user" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" id="edit_role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="Pegawai">Pegawai</option>
                            </select>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Isi otomatis modal edit
        document.querySelectorAll('.btnEdit').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_nama').value = this.dataset.nama;
                document.getElementById('edit_username').value = this.dataset.username;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_role').value = this.dataset.role;
            });
        });
    </script>
</body>
</html>