<?php
require_once '../includes/db_connect.php';
require_once 'TagihanDenda.php';

class DendaPelanggaran {
    private $conn;
    private $table_name = "denda_pelanggaran";

    public $id;
    public $total_denda;
    public $keterangan;
    public $id_admin;
    public $id_penghuni;
    public $id_kategori_pelanggaran;

    public $fillable =[
        "total_denda",
        "keterangan",
        "id_admin",
        "id_penghuni",
        "id_kategori_pelanggaran"
    ];

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (total_denda, keterangan, id_admin, id_penghuni, id_kategori_pelanggaran) VALUES (:total_denda, :keterangan, :id_admin, :id_penghuni, :id_kategori_pelanggaran)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":total_denda", $this->total_denda);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":id_admin", $this->id_admin);
        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":id_kategori_pelanggaran", $this->id_kategori_pelanggaran);

        if ($stmt->execute()) {
            // create tagihan
            $tagihanDenda = new TagihanDenda($this->conn);
            $tagihanDenda->id_denda_pelanggaran = $this->conn->lastInsertId();
            $tagihanDenda->bulan = date("Y-m-d");
            $tagihanDenda->tanggal_maksimal_bayar = date("Y-m-d", strtotime("+1 month"));
            $tagihanDenda->harga_tagihan = $this->total_denda;
            $tagihanDenda->denda_keterlambatan = 0;
            $tagihanDenda->tanggal_bayar = null;
            $tagihanDenda->create();
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
        $query = "UPDATE " . $this->table_name . " SET total_denda = :total_denda, keterangan = :keterangan, id_admin = :id_admin, id_penghuni = :id_penghuni, id_kategori_pelanggaran = :id_kategori_pelanggaran WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":total_denda", $this->total_denda);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":id_admin", $this->id_admin);
        $stmt->bindParam(":id_penghuni", $this->id_penghuni);
        $stmt->bindParam(":id_kategori_pelanggaran", $this->id_kategori_pelanggaran);

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

    public function readWithAdminPenghuni() {
        $query = "SELECT d.*, a.nama_admin, p.nama_penghuni, kd.nama_kategori,kd.tingkat_keparahan FROM `denda_pelanggaran` d
        LEFT JOIN admin a on d.id_admin = d.id_admin
        LEFT JOIN penghuni p on d.id_penghuni = p.id
        LEFT JOIN kategori_denda kd on d.id_kategori_pelanggaran = kd.id";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT d.*, a.nama_admin, p.nama_penghuni, kd.nama_kategori,kd.tingkat_keparahan FROM `denda_pelanggaran` d
        LEFT JOIN admin a on d.id_admin = d.id_admin
        LEFT JOIN penghuni p on d.id_penghuni = p.id
        LEFT JOIN kategori_denda kd on d.id_kategori_pelanggaran = kd.id WHERE d.id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt;
    }

    public function updatePartial(){
        $query = "UPDATE " . $this->table_name . " SET ";
        $set = "";
        foreach($this->fillable as $key){
            if($this->{$key} != null){
                $set .= $key . " = :" . $key . ", ";
            }
        }
        $set = rtrim($set, ", "); //hapus coma di akhir
        $query .= $set . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        foreach($this->fillable as $key){
            if($this->{$key} != null){
                $stmt->bindParam(":" . $key, $this->{$key});
            }
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}
?>
