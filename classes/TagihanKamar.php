<?php
require_once './includes/db_connect.php';

class TagihanKamar {
    private $conn;
    private $table_name = "Tagihan_Kamar";

    public $id_penghuni;
    public $tanggal_bulan;
    public $durasi;
    public $tanggal_maksimal_bayar;
    public $harga_tagihan;
    public $denda;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (id_penghuni, tanggal_bulan, durasi, tanggal_maksimal_bayar, harga_tagihan, denda) VALUES (:id_penghuni, :tanggal_bulan, :durasi, :tanggal_maksimal_bayar, :harga_tagihan, :denda)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":tanggal_bulan", $this->tanggal_bulan);
        $stmt->bindParam(":durasi", $this->durasi);
        $stmt->bindParam(":tanggal_maksimal_bayar", $this->tanggal_maksimal_bayar);
        $stmt->bindParam(":harga_tagihan", $this->harga_tagihan);
        $stmt->bindParam(":denda", $this->denda);

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
        $query = "UPDATE " . $this->table_name . " SET durasi = :durasi, tanggal_maksimal_bayar = :tanggal_maksimal_bayar, harga_tagihan = :harga_tagihan, denda = :denda WHERE id_penghuni = :id_penghuni AND tanggal_bulan = :tanggal_bulan";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":tanggal_bulan", $this->tanggal_bulan);
        $stmt->bindParam
        (":durasi", $this->durasi);
        $stmt->bindParam(":tanggal_maksimal_bayar", $this->tanggal_maksimal_bayar);
        $stmt->bindParam(":harga_tagihan", $this->harga_tagihan);
        $stmt->bindParam(":denda", $this->denda);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_penghuni = :id_penghuni AND tanggal_bulan = :tanggal_bulan";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":tanggal_bulan", $this->tanggal_bulan);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
