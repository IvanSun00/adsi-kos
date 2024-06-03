<?php
require_once '../includes/db_connect.php';

class KategoriDenda {
    private $conn;
    private $table_name = "kategori_denda";

    public $id;
    public $nama_kategori;
    public $tingkat_keparahan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama_kategori, tingkat_keparahan) VALUES (:nama_kategori, :tingkat_keparahan)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama_kategori", $this->nama_kategori);
        $stmt->bindParam(":tingkat_keparahan", $this->tingkat_keparahan);

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
        $query = "UPDATE " . $this->table_name . " SET nama_kategori = :nama_kategori, tingkat_keparahan = :tingkat_keparahan WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nama_kategori", $this->nama_kategori);
        $stmt->bindParam(":tingkat_keparahan", $this->tingkat_keparahan);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
