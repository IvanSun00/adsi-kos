<?php
require_once '../includes/db_connect.php';

class LahanParkir {
    private $conn;
    private $table_name = "Lahan_Parkir";

    public $nomor_lahan_parkir;
    public $harga_lahan_parkir;
    public $jenis_lahan_parkir;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nomor_lahan_parkir, harga_lahan_parkir, jenis_lahan_parkir, status) VALUES (:nomor_lahan_parkir, :harga_lahan_parkir, :jenis_lahan_parkir, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nomor_lahan_parkir", $this->nomor_lahan_parkir);
        $stmt->bindParam(":harga_lahan_parkir", $this->harga_lahan_parkir);
        $stmt->bindParam(":jenis_lahan_parkir", $this->jenis_lahan_parkir);
        $stmt->bindParam(":status", $this->status);

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
        $query = "UPDATE " . $this->table_name . " SET harga_lahan_parkir = :harga_lahan_parkir, jenis_lahan_parkir = :jenis_lahan_parkir, status = :status WHERE nomor_lahan_parkir = :nomor_lahan_parkir";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nomor_lahan_parkir", $this->nomor_lahan_parkir);
        $stmt->bindParam(":harga_lahan_parkir", $this->harga_lahan_parkir);
        $stmt->bindParam(":jenis_lahan_parkir", $this->jenis_lahan_parkir);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE nomor_lahan_parkir = :nomor_lahan_parkir";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nomor_lahan_parkir", $this->nomor_lahan_parkir);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
