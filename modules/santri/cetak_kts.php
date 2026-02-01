<?php
include '../../config/database.php';
$id = $_GET['id'];
$s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'"));
?>
<!DOCTYPE html>
<html>

<head>
    <title>KTS - <?= $s['nama_lengkap'] ?></title>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            padding-top: 50px;
            background: #eee;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .card-kts {
            width: 85mm;
            height: 55mm;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 15px;
            position: relative;
            border: 1px solid #ddd;
            overflow: hidden;
            background-image: linear-gradient(rgba(255, 255, 255, 0.88), rgba(255, 255, 255, 0.88)), url('../../assets/img/bg-pesantren.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Header Setup */
        .header {
            position: relative;
            border-bottom: 2px solid #2c3e50;
            margin-bottom: 12px;
            padding-bottom: 8px;
            min-height: 45px;
        }

        .logo-atp {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
        }

        .header-text {
            text-align: center;
            /* Teks di tengah */
            width: 100%;
        }

        .header h4 {
            margin: 0;
            font-size: 13px;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 0;
            font-size: 9px;
            color: #007bff;
            font-weight: bold;
        }

        /* Foto & Data Identitas */
        .photo {
            width: 22mm;
            height: 29mm;
            border: 2px solid #2c3e50;
            float: left;
            margin-right: 15px;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .data {
            font-size: 10.5px;
            line-height: 1.6;
            color: #333;
            text-align: left;
        }

        .data b {
            display: inline-block;
            width: 65px;
            color: #555;
        }

        .footer {
            position: absolute;
            bottom: 8px;
            right: 15px;
            font-size: 8px;
            color: #777;
            font-style: italic;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .card-kts {
                box-shadow: none;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body onload="setTimeout(function(){ window.print(); }, 1200)">
    <div class="card-kts" data-aos="zoom-in">
        <div class="header">
            <img src="../../assets/img/logo-attaupiqillah.png" class="logo-atp">
            <div class="header-text">
                <h4>KARTU TANDA SANTRI</h4>
                <p>PONPES ATTAUPIQILLAH GARUT</p>
            </div>
        </div>
        <div class="photo">
            <img src="../../assets/uploads/santri/<?= $s['foto_pribadi'] ?>" alt="Foto">
        </div>
        <div class="data">
            <span style="font-size: 11px; font-weight: bold; color: #000; display: block; margin-bottom: 3px;">
                <?= $s['nama_lengkap'] ?></span>
            <b>ID Santri</b>: ATQ-<?= str_pad($s['id_santri'], 4, '0', STR_PAD_LEFT) ?><br>
            <b>TTL</b>: <?= $s['tempat_lahir'] ?>, <?= date('d-m-Y', strtotime($s['tanggal_lahir'])) ?><br>
            <b>Alamat</b>: <?= (strlen($s['alamat']) > 45) ? substr($s['alamat'], 0, 42) . '...' : $s['alamat']; ?>
        </div>
        <div class="footer">Dicetak otomatis oleh SiPontren - <?= date('Y') ?></div>
    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>