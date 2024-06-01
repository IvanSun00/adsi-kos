<?php
require_once './includes/db_connect.php';

class DetailKamar {
    private $conn;
    private $table_name = "Detail_Kamar";

    public $id_penghuni;
    public $nomor_kamar;
    public $tanggal_bulan;
    public $nama_penghuni;
    public $durasi_kamar;
    public $tanggal_mulai_sewa;
    public $tanggal_selesai_sewa;
    public $total_harga;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (id_penghuni, nomor_kamar, tanggal_bulan, nama_penghuni, durasi_kamar, tanggal_mulai_sewa, tanggal_selesai_sewa, total_harga) VALUES (:id_penghuni, :nomor_kamar, :tanggal_bulan, :nama_penghuni, :durasi_kamar, :tanggal_mulai_sewa, :tanggal_selesai_sewa, :total_harga)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":tanggal_bulan", $this->tanggal_bulan);
        $stmt->bindParam(":nama_penghuni", $this->nama_penghuni);
        $stmt->bindParam(":durasi_kamar", $this->durasi_kamar);
        $stmt->bindParam(":tanggal_mulai_sewa", $this->tanggal_mulai_sewa);
        $stmt->bindParam(":tanggal_selesai_sewa", $this->tanggal_selesai_sewa);
        $stmt->bindParam(":total_harga", $this->total_harga);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_penghuni = :nama_penghuni, durasi_kamar = :durasi_kamar, tanggal_mulai_sewa = :tanggal_mulai_sewa, tanggal_selesai_sewa = :tanggal_selesai_sewa, total_harga = :total_harga WHERE id_penghuni = :id_penghuni AND nomor_kamar = :nomor_kamar AND tanggal_bulan = :tanggal_bulan";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":tanggal_bulan", $this->tanggal_bulan);
        $stmt->bindParam(":nama_penghuni", $this->nama_penghuni);
        $stmt->bindParam(":durasi_kamar", $this->durasi_kamar);
        $stmt->bindParam(":tanggal_mulai_sewa", $this->tanggal_mulai_sewa);
        $stmt->bindParam(":tanggal_selesai_sewa", $this->tanggal_selesai_sewa);
        $stmt->bindParam(":total_harga", $this->total_harga);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_penghuni = :id_penghuni AND nomor_kamar = :nomor_kamar AND tanggal_bulan = :tanggal_bulan";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":tanggal_bulan", $this->tanggal_bulan);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
