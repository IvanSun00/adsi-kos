<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db_connect.php';
require_once '../classes/DendaPelanggaran.php';

$database = new Database();
$db = $database->dbConnection();

$denda = new DendaPelanggaran($db);
if(isset($_GET['Request'])){
    $request = $_GET['Request'];

    
    switch($request){
        case 'add':
            if(empty($_POST['total_denda']) || empty($_POST['keterangan']) || empty($_POST['id_penghuni'])){
                echo json_encode([
                    "success" => false,
                    "msg" => "Data tidak boleh kosong"
                ]);
                return;
            }
            if(!is_numeric($_POST['total_denda'])){
                echo json_encode([
                    "success" => false,
                    "msg" => "Total denda harus berupa angka"
                ]);
                return;
            }
            $denda->total_denda = $_POST['total_denda'];
            $denda->keterangan = $_POST['keterangan'];
            $denda->id_admin = $_SESSION['id'] ;
            $denda->id_penghuni = $_POST['id_penghuni'];
            if($denda->create()){
                echo json_encode([
                    "success" => true,
                    "msg" => "Denda berhasil ditambahkan"
                
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "msg" => "Denda gagal ditambahkan"
                ]);
            }
            break;
        case 'read':
            $data = $denda->readWithAdminPenghuni()->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                "success" => true,
                "data" => $data
            ]);
            break;
        case 'getById':
            if(empty($_POST['id'])){
                echo json_encode([
                    "success" => false,
                    "msg" => "ID tidak boleh kosong"
                ]);
                return;
            }
            $data = $denda->getById($_POST['id'])->fetch(PDO::FETCH_ASSOC);
            echo json_encode([
                "success" => true,
                "data" => $data
            ]);
            break;
        case 'update':
            if(empty($_POST['id']) || empty($_POST['total_denda']) || empty($_POST['keterangan'])){
                echo json_encode([
                    "success" => false,
                    "msg" => "Data tidak boleh kosong"
                ]);
                return;
            }
            if(!is_numeric($_POST['total_denda'])){
                echo json_encode([
                    "success" => false,
                    "msg" => "Total denda harus berupa angka"
                ]);
                return;
            }
            $denda->id = $_POST['id'];
            $denda->total_denda = $_POST['total_denda'];
            $denda->keterangan = $_POST['keterangan'];
            $denda->id_admin = $_SESSION['id'] ;
            $denda->id_penghuni = $_POST['id_penghuni'];
            if($denda->update()){
                echo json_encode([
                    "success" => true,
                    "msg" => "Denda berhasil diupdate"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "msg" => "Denda gagal diupdate"
                ]);
            }
            break;
        case 'delete':
            if(empty($_POST['id'])){
                echo json_encode([
                    "success" => false,
                    "msg" => "ID tidak boleh kosong"
                ]);
                return;
            }
            $denda->id = $_POST['id'];
            if($denda->delete()){
                echo json_encode([
                    "success" => true,
                    "msg" => "Denda berhasil dihapus"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "msg" => "Denda gagal dihapus"
                ]);
            }
            break;
        default:
            break;
    };

}else{
    echo "Invalid request";
}
?>