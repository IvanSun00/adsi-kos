<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db_connect.php';
require_once '../classes/TagihanKamar.php';

$database = new Database();
$db = $database->dbConnection();

$tagihanKamar = new TagihanKamar($db);
if(isset($_GET['Request'])){
    $request = $_GET['Request'];

    
    switch($request){
        case 'complete': 
            if(empty($_POST['id'])){
                echo json_encode([
                    'success' => false,
                    'msg' => 'membutuhkan Id'
                ]);
                return;
            }
            $tagihanKamar->id = $_POST['id'];
            $tagihanKamar->tanggal_bayar = date('Y-m-d H:i:s');
            if($tagihanKamar->updatePartial()){
                echo json_encode([
                    'success' => true,
                    'msg' => 'Tagihan berhasil dibayar'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Tagihan gagal dibayar'
                ]);
            }
            break;

        /**
         * Generate tagihan
         * @param id_detail_kamar, bulan, harga_per_bulan
         */
        case 'generateTagihan':
            if(empty($_POST['detail_kamar']) || empty($_POST['bulan']) || empty($_POST['harga_per_bulan'])){
                echo json_encode([
                    'success' => false,
                    'msg' => 'Semua field harus diisi'
                ]);
                return;
            }
            $bulan = $_POST['bulan'];
            $date  = date('Y-m-d', strtotime('+7 days'));
            for($b = 1; $b <= $bulan; $b++){
                $iniTagihanKamar = new TagihanKamar($db);
                $iniTagihanKamar->detail_kamar = $_POST['detail_kamar'];
                $iniTagihanKamar->bulan = $b;
                $iniTagihanKamar->tanggal_maksimal_bayar = $date;
                $iniTagihanKamar->harga_tagihan = $_POST['harga_per_bulan'];
                $iniTagihanKamar->denda_keterlambatan = 0;
                $iniTagihanKamar->tanggal_bayar = null;
                $iniTagihanKamar->create();
                $date = date('Y-m-d', strtotime('+1 month', strtotime($date)));

            }
            echo json_encode([
                'success' => true,
                'msg' => 'Tagihan berhasil dibuat'
            ]);

            break;
        default:
            break;
    };

}else{
    echo "Invalid request";
}
?>