<?php
require_once './includes/db_connect.php';

class Kamar {
    private $conn;
    private $table_name = "Kamar";

    public $nomor_kamar;
    public $harga_kamar;
    public $jenis_kamar;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nomor_kamar, harga_kamar, jenis_kamar, status) VALUES (:nomor_kamar, :harga_kamar, :jenis_kamar, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":harga_kamar", $this->harga_kamar);
        $stmt->bindParam(":jenis_kamar", $this->jenis_kamar);
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
        $query = "UPDATE " . $this->table_name . " SET harga_kamar = :harga_kamar, jenis_kamar = :jenis_kamar, status = :status WHERE nomor_kamar = :nomor_kamar";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":harga_kamar", $this->harga_kamar);
        $stmt->bindParam(":jenis_kamar", $this->jenis_kamar);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE nomor_kamar = :nomor_kamar";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
