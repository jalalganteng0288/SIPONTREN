<?php
include '../../config/database.php';
$id = $_GET['id'];
$s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'"));

$biaya_daftar = (int)($s['biaya_pendaftaran'] ?? 0);
$biaya_kitab  = (int)($s['biaya_kitab'] ?? 0);
$total_bayar  = $biaya_daftar + $biaya_kitab;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kuitansi - <?= $s['nama_lengkap'] ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            padding: 20px;
            color: #333;
        }

        .kuitansi {
            width: 200mm;
            height: 105mm;
            background: white;
            padding: 35px;
            margin: auto;
            border: 3px double #333;
            position: relative;
            background-image: linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.92)), url('../../assets/img/bg-pesantren.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Header Setup */
        .header {
            position: relative;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
            min-height: 60px;
        }

        .logo-kuitansi {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
        }

        .header-text {
            text-align: center;
            /* Teks di tengah */
            width: 100%;
        }

        .header h2 {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 20px;
        }

        /* Konten Rata Kiri */
        .content {
            line-height: 2.2;
            font-size: 15px;
            text-align: left;
        }

        .content b {
            display: inline-block;
            width: 190px;
        }

        .total-box {
            margin-top: 25px;
            font-size: 22px;
            font-weight: bold;
            background: rgba(238, 238, 238, 0.85);
            padding: 12px 25px;
            display: inline-block;
            border: 2px dashed #333;
        }

        .ttd {
            position: absolute;
            bottom: 40px;
            right: 60px;
            text-align: center;
        }

        @media print {
            body {
                background: none;
            }

            .kuitansi {
                border: 2px solid #000;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="kuitansi">
        <div class="header">
            <img src="../../assets/img/logo-attaupiqillah.png" class="logo-kuitansi">
            <div class="header-text">
                <h2>KUITANSI PEMBAYARAN</h2>
                <b style="font-size: 16px; font-family: Arial;">PONDOK PESANTREN ATTAUPIQILLAH</b><br>
                <small>kp. Cimencek Rt. 02 Ds. Cinta asih Kec. Samarang Kab. Garut Jawa Barat 44161</small>
            </div>
        </div>

        <div class="content">
            <b>Telah terima dari</b> : <?= $s['nama_ayah'] ?> / <?= $s['nama_ibu'] ?><br>
            <b>Nama Santri</b> : <?= $s['nama_lengkap'] ?><br>
            <b>Untuk Pembayaran</b> : PSB & Pembelian Kitab<br>
            <b>Rincian</b> : Daftar (Rp <?= number_format($biaya_daftar, 0, ',', '.') ?>) + Kitab (Rp <?= number_format($biaya_kitab, 0, ',', '.') ?>)
        </div>

        <div class="total-box">
            TOTAL BAYAR: Rp <?= number_format($total_bayar, 0, ',', '.') ?>
        </div>

        <div class="ttd">
            Garut, <?= date('d F Y') ?><br>
            Bendahara Pesantren,<br><br><br><br>
            ( ________________________ )
        </div>
    </div>
</body>

</html>