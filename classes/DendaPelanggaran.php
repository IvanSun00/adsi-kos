<?php
require_once '../includes/db_connect.php';

class DendaPelanggaran {
    private $conn;
    private $table_name = "Denda_Pelanggaran";

    public $id;
    public $total_denda;
    public $keterangan;
    public $id_admin;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (total_denda, keterangan, id_admin) VALUES (:total_denda, :keterangan, :id_admin)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":total_denda", $this->total_denda);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":id_admin", $this->id_admin);

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
        $query = "UPDATE " . $this->table_name . " SET total_denda = :total_denda, keterangan = :keterangan, id_admin = :id_admin WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":total_denda", $this->total_denda);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":id_admin", $this->id_admin);

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
