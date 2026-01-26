<?php
include '../../config/database.php';
$id = $_GET['id'];
$s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>KTS - <?= $s['nama_lengkap'] ?></title>
    <style>
        body { display: flex; justify-content: center; padding-top: 50px; background: #eee; }
        .card-kts {
            width: 85mm; height: 55mm; background: white; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 15px; position: relative;
            font-family: sans-serif; border: 1px solid #ddd;
        }
        .header { text-align: center; border-bottom: 2px solid #2c3e50; margin-bottom: 10px; }
        .header h4 { margin: 0; font-size: 14px; }
        .header p { margin: 0 0 5px; font-size: 10px; color: blue; font-weight: bold; }
        .photo { width: 22mm; height: 30mm; background: #f0f0f0; border: 1px solid #ccc; float: left; margin-right: 15px; }
        .data { font-size: 10.5px; line-height: 1.4; }
        .footer { position: absolute; bottom: 8px; right: 15px; font-size: 8px; color: gray; }
    </style>
</head>
<body onload="window.print()">
    <div class="card-kts">
        <div class="header">
            <h4>KARTU TANDA SANTRI</h4>
            <p>PONPES ATTAUPIQILLAH</p>
        </div>
        <div class="photo"></div>
        <div class="data">
            <b>Nama:</b> <?= $s['nama_lengkap'] ?><br>
            <b>TTL:</b> <?= $s['tempat_lahir'] ?>, <?= date('d-m-Y', strtotime($s['tanggal_lahir'])) ?><br>
            <b>ID Santri:</b> ATQ-<?= str_pad($s['id_santri'], 4, '0', STR_PAD_LEFT) ?><br>
            <b>Thn Masuk:</b> <?= $s['tahun_masuk'] ?><br>
            <b>Alamat:</b> <?= substr($s['alamat'], 0, 30) ?>...
        </div>
        <div class="footer">Dicetak otomatis oleh SiPontren - <?= date('Y') ?></div>
    </div>
</body>
</html>