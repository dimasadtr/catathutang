<?php
class database
{
    private $host = "localhost";
    private $dbname = "catathutang";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Koneksi gagal: " . $e->getMessage()]);
            exit;
        }
    }

    //===========REKAP HUTANG
    public function get_rekap_hutang()
    {
        $query = $this->conn->prepare("SELECT * FROM v_rekap_hutang");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function total_pelanggan()
    {
        $query = $this->conn->query("SELECT COUNT(*) AS jml FROM pelanggan");
        return $query->fetch(PDO::FETCH_ASSOC)['jml'];
    }

    public function last_hutang()
    {
        $q = $this->conn->query("SELECT jumlah FROM transaksi_hutang ORDER BY id_transaksi DESC LIMIT 1");
        $r = $q->fetch(PDO::FETCH_ASSOC);
        return $r ? $r['jumlah'] : 0;
    }

    public function last_bayar()
    {
        $q = $this->conn->query("SELECT jumlah_bayar FROM pembayaran ORDER BY id_pembayaran DESC LIMIT 1");
        $r = $q->fetch(PDO::FETCH_ASSOC);
        return $r ? $r['jumlah_bayar'] : 0;
    }
    /* ================================

    /* 
     PELANGGAN
    ================================*/
    public function tampil_pelanggan()
    {
        $q = $this->conn->query("SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambah_pelanggan($data)
    {
        $sql = "INSERT INTO pelanggan (nama_pelanggan, alamat, no_hp, keterangan) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            $data['nama_pelanggan'] ?? '',
            $data['alamat'] ?? '',
            $data['no_hp'] ?? '',
            $data['keterangan'] ?? ''
        ]);

        return ["status" => $ok ? "success" : "error"];
    }

    public function edit_pelanggan($data)
    {
        $sql = "UPDATE pelanggan SET nama_pelanggan=?, alamat=?, no_hp=?, keterangan=? WHERE id_pelanggan=?";
        $stmt = $this->conn->prepare($sql);

        $ok = $stmt->execute([
            $data['nama_pelanggan'] ?? '',
            $data['alamat'] ?? '',
            $data['no_hp'] ?? '',
            $data['keterangan'] ?? '',
            $data['id_pelanggan'] ?? 0
        ]);

        return ["status" => $ok ? "success" : "error"];
    }

    public function hapus_pelanggan($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM pelanggan WHERE id_pelanggan=?");
        $ok = $stmt->execute([$id]);
        return ["status" => $ok ? "success" : "error"];
    }


    /* ===============================
     HUTANG
    ================================*/
    public function tampil_hutang()
    {
        $sql = "SELECT 
                    h.id_transaksi, 
                    p.nama_pelanggan, 
                    h.tanggal_hutang, 
                    h.jumlah, 
                    h.keterangan, 
                    h.status
                FROM transaksi_hutang h
                JOIN pelanggan p ON h.id_pelanggan = p.id_pelanggan
                ORDER BY h.id_transaksi DESC";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambah_hutang($data)
    {
        $sql = "INSERT INTO transaksi_hutang (id_pelanggan, tanggal_hutang, jumlah, keterangan, status)
                VALUES (?, ?, ?, ?, ?)";

        $status = $data['status'] ?? "Belum Lunas";

        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            $data['id_pelanggan'] ?? 0,
            $data['tanggal_hutang'] ?? date('Y-m-d'),
            $data['jumlah'] ?? 0,
            $data['keterangan'] ?? '',
            $status
        ]);

        return ["status" => $ok ? "success" : "error"];
    }

    public function edit_hutang($data)
    {
        $sql = "UPDATE transaksi_hutang 
                SET id_pelanggan=?, tanggal_hutang=?, jumlah=?, keterangan=?, status=?
                WHERE id_transaksi=?";

        $status = $data['status'] ?? "Belum Lunas";

        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            $data['id_pelanggan'],
            $data['tanggal_hutang'] ?? date('Y-m-d'),
            $data['jumlah'],
            $data['keterangan'],
            $status,
            $data['id_transaksi']
        ]);

        return ["status" => $ok ? "success" : "error"];
    }

    public function hapus_hutang($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM transaksi_hutang WHERE id_transaksi=?");
        $ok = $stmt->execute([$id]);
        return ["status" => $ok ? "success" : "error"];
    }


    /* ===============================
    PEMBAYARAN
    ================================*/
    public function tampil_pembayaran()
    {
        $sql = "SELECT 
                id_pembayaran,
                id_transaksi,
                tanggal_bayar,
                jumlah_bayar,
                metode_pembayaran,
                keterangan
            FROM pembayaran";

        $hasil = $this->conn->query($sql);
        return $hasil->fetchAll(PDO::FETCH_ASSOC);
    }
    public function tambah_pembayaran($data)
    {
        $sql = "INSERT INTO pembayaran (id_transaksi, jumlah_bayar, metode_pembayaran, keterangan)
            VALUES (:id_transaksi, :jumlah_bayar, :metode_pembayaran, :keterangan)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_transaksi' => $data['id_transaksi'],
            // ':tanggal_bayar' => $data['tanggal_bayar'],
            ':jumlah_bayar' => $data['jumlah_bayar'],
            ':metode_pembayaran' => $data['metode_pembayaran'],
            ':keterangan' => $data['keterangan']
        ]);
    }


    public function edit_pembayaran($data)
    {
        $sql = "UPDATE pembayaran SET
                id_transaksi = :id_transaksi,
                tanggal_bayar = :tanggal_bayar,
                jumlah_bayar = :jumlah_bayar,
                metode_pembayaran = :metode_pembayaran,
                keterangan = :keterangan
            WHERE id_pembayaran = :id_pembayaran";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_pembayaran' => $data['id_pembayaran'],
            ':id_transaksi' => $data['id_transaksi'],
            ':tanggal_bayar' => $data['tanggal_bayar'],
            ':jumlah_bayar' => $data['jumlah_bayar'],
            ':metode_pembayaran' => $data['metode_pembayaran'],
            ':keterangan' => $data['keterangan']
        ]);
    }


    public function hapus_pembayaran($id)
    {
        $sql = "DELETE FROM pembayaran WHERE id_pembayaran = :id_pembayaran";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_pembayaran' => $id]);
    }


    /* ===============================
    USER 
    ================================*/
    public function tampil_user()
    {
        $q = $this->conn->query("SELECT * FROM user ORDER BY id_user DESC");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambah_user($data)
    {
        $sql = "INSERT INTO user (nama, username, password, email, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            $data['nama'] ?? '',
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['email'] ?? '',
            $data['role'] ?? ''
        ]);

        return ["status" => $ok ? "success" : "error"];
    }

    public function edit_user($data)
    {
        $sql = "UPDATE user SET nama=?, username=?, password=?, email=?, role=? WHERE id_user=?";
        $stmt = $this->conn->prepare($sql);

        $ok = $stmt->execute([
            $data['nama'] ?? '',
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['email'] ?? '',
            $data['role'] ?? '',
            $data['id_user'] ?? 0
        ]);

        return ["status" => $ok ? "success" : "error"];
    }

    public function hapus_user($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM user WHERE id_user=?");
        $ok = $stmt->execute([$id]);
        return ["status" => $ok ? "success" : "error"];
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ["status" => "error", "message" => "Username tidak ditemukan"];
        }

        // Password TIDAK di-hash → langsung cocokkan biasa
        if ($password !== $user["password"]) {
            return ["status" => "error", "message" => "Password salah"];
        }

        return [
            "status" => "success",
            "user" => [
                "id_user" => $user["id_user"],
                "nama" => $user["nama"],
                "username" => $user["username"],
                "email" => $user["email"],
                "role" => $user["role"]
            ]
        ];
    }


}
?>