<?php
require_once '../includes/db_connect.php';
require_once '../classes/Kamar.php';
require_once '../classes/DetailKamar.php';

$database = new Database();
$db = $database->dbConnection();

$kamar = new Kamar($db);
$stmt = $kamar->read();

$id_penghuni = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_penghuni'])) {
        $id_penghuni = $_POST['id_penghuni'];
    } else {
        $detailKamar = new DetailKamar($db);

        $detailKamar->id_penghuni = $_POST['id_penghuni'];
        $detailKamar->nomor_kamar = $_POST['nomor_kamar'];
        $detailKamar->durasi_kamar = $_POST['durasi'];
        $detailKamar->tanggal_mulai_sewa = $_POST['tanggal_mulai_sewa'];
        $detailKamar->tanggal_selesai_sewa = date("Y-m-d", strtotime("+{$_POST['durasi']} months", strtotime($_POST['tanggal_mulai_sewa'])));
        $detailKamar->total_harga = $_POST['harga_kamar'] * $_POST['durasi'];

        $kamar->nomor_kamar = $_POST['nomor_kamar'];
        $stmt_kamar = $kamar->read();
        $is_available = true;

        while ($row = $stmt_kamar->fetch(PDO::FETCH_ASSOC)) {
            if ($row['status'] == 'filled' || $row['status'] == 'under repair') {
                $is_available = false;
                break;
            }
        }

        if ($is_available) {
            if ($detailKamar->create()) {
                $kamar->status = 'filled';
                $kamar->update();

                echo "Penyewaan kamar berhasil.";
            } else {
                echo "Penyewaan kamar gagal.";
            }
        } else {
            echo "Kamar terisi atau dalam perbaikan, pilih kamar lainnya.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pilih Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function calculateEndDate() {
            const startDate = document.getElementById('tanggal_mulai_sewa').value;
            const duration = document.getElementById('durasi').value;
            if (startDate && duration) {
                const endDate = new Date(startDate);
                endDate.setMonth(endDate.getMonth() + parseInt(duration));
                document.getElementById('tanggal_selesai_sewa').value = endDate.toISOString().split('T')[0];
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Sistem</span> Kos</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>Pilih Kamar</h1>

        <?php if ($id_penghuni === null) { ?>
            <form method="post">
                <label for="id_penghuni">ID Penghuni:</label>
                <input type="number" name="id_penghuni" id="id_penghuni" required>
                <input type="submit" value="Lanjutkan">
            </form>
        <?php } else { ?>
            <form method="post">
                <input type="hidden" name="id_penghuni" value="<?php echo $id_penghuni; ?>">

                <label for="nomor_kamar">Nomor Kamar:</label>
                <select name="nomor_kamar" id="nomor_kamar">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <?php if ($row['status'] == 'available') { ?>
                            <option value="<?php echo $row['nomor_kamar']; ?>"><?php echo $row['nomor_kamar']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select><br>

                <label for="durasi">Durasi (bulan):</label>
                <input type="number" name="durasi" id="durasi" min="1" required oninput="calculateEndDate()"><br>

                <label for="tanggal_mulai_sewa">Tanggal Mulai Sewa:</label>
                <input type="date" name="tanggal_mulai_sewa" id="tanggal_mulai_sewa" required onchange="calculateEndDate()"><br>

                <label for="harga_kamar">Harga Kamar per Bulan:</label>
                <input type="number" name="harga_kamar" id="harga_kamar" value="1000000" readonly><br>

                <label for="tanggal_selesai_sewa">Tanggal Selesai Sewa:</label>
                <input type="date" id="tanggal_selesai_sewa" readonly><br>

                <input type="submit" value="Submit">
            </form>
        <?php } ?>
    </div>
</body>
</html>
