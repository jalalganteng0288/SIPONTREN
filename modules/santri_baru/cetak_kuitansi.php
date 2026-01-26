<?php
include '../../config/database.php';
$id = $_GET['id'];

// Mengambil data santri dari database
$query = mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'");
$s = mysqli_fetch_assoc($query);

// Konversi nilai ke integer untuk memastikan perhitungan matematika berjalan lancar
$biaya_daftar = (int)($s['biaya_pendaftaran'] ?? 0);
$biaya_kitab  = (int)($s['biaya_kitab'] ?? 0);

// AKUMULASI: Menjumlahkan biaya pendaftaran dan biaya kitab
$total_akumulasi = $biaya_daftar + $biaya_kitab;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kuitansi - <?= $s['nama_lengkap'] ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; padding: 20px; color: #333; }
        .kuitansi { 
            width: 200mm; height: 100mm; background: white; padding: 30px; 
            margin: auto; border: 2px solid #333; position: relative;
        }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .content { line-height: 2; font-size: 14px; }
        .content b { display: inline-block; width: 180px; }
        .total-box { 
            margin-top: 25px; font-size: 22px; font-weight: bold; 
            background: #eee; padding: 15px; display: inline-block; border: 2px dashed #333;
        }
        .ttd { float: right; text-align: center; margin-top: 10px; width: 250px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="kuitansi">
        <div class="header">
            <h2>Kuitansi Pembayaran Santri Baru</h2>
            <span>PONDOK PESANTREN ATTAUPIQILLAH</span>
        </div>
        
        <div class="content">
            <b>Telah terima dari</b>: <?= $s['nama_ayah'] ?> / <?= $s['nama_ibu'] ?><br>
            <b>Nama Santri</b>: <?= $s['nama_lengkap'] ?><br>
            <b>Rincian Pembayaran</b>: <br>
            &nbsp; - Pendaftaran : Rp <?= number_format($biaya_daftar, 0, ',', '.') ?><br>
            &nbsp; - Biaya Kitab : Rp <?= number_format($biaya_kitab, 0, ',', '.') ?>
        </div>

        <div class="total-box">
            TOTAL : Rp <?= number_format($total_akumulasi, 0, ',', '.') ?>
        </div>

        <div class="ttd">
            Garut, <?= date('d F Y') ?><br>
            Bendahara Pesantren,<br><br><br><br>
            ( ________________________ )
        </div>
    </div>
</body>
</html>