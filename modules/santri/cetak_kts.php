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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-kts {
            width: 85mm; 
            height: 55mm; 
            background: white; 
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15); 
            padding: 15px; 
            position: relative;
            border: 1px solid #ddd;
            overflow: hidden;
            background-image: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
        }
        /* Variasi Background Kartu */
        .card-kts::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(0, 123, 255, 0.05);
            border-radius: 50%;
        }
        .header { 
            text-align: center; 
            border-bottom: 2px solid #2c3e50; 
            margin-bottom: 12px; 
            padding-bottom: 5px;
        }
        .header h4 { margin: 0; font-size: 14px; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 2px 0 0; font-size: 10px; color: #007bff; font-weight: bold; }
        
        /* Area Foto */
        .photo { 
            width: 24mm; 
            height: 32mm; 
            background: #f0f0f0; 
            border: 1px solid #ccc; 
            float: left; 
            margin-right: 15px; 
            overflow: hidden;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Menjaga agar foto tidak penyet */
        }

        .data { font-size: 11px; line-height: 1.5; color: #333; }
        .data b { color: #555; width: 70px; display: inline-block; }
        
        .footer { 
            position: absolute; 
            bottom: 8px; 
            right: 15px; 
            font-size: 8px; 
            color: #999; 
            font-style: italic;
        }

        /* Tombol Cetak Manual (Hilang saat diprint) */
        @media print {
            .no-print { display: none; }
            body { background: none; padding: 0; }
            .card-kts { box-shadow: none; border: 1px solid #000; }
        }
    </style>
</head>
<body onload="setTimeout(function(){ window.print(); }, 1500)">

    <div class="card-kts" data-aos="flip-up" data-aos-duration="1000">
        <div class="header">
            <h4>KARTU TANDA SANTRI</h4>
            <p>PONPES ATTAUPIQILLAH</p>
        </div>
        
        <div class="photo">
            <?php if(!empty($s['foto_pribadi'])): ?>
                <img src="../../assets/uploads/santri/<?= $s['foto_pribadi'] ?>" alt="Foto Santri">
            <?php else: ?>
                <div style="text-align:center; padding-top:40%; font-size:8px; color:#ccc;">Tanpa Foto</div>
            <?php endif; ?>
        </div>

        <div class="data">
            <b>Nama</b>: <?= $s['nama_lengkap'] ?><br>
            <b>TTL</b>: <?= $s['tempat_lahir'] ?>, <?= date('d-m-Y', strtotime($s['tanggal_lahir'])) ?><br>
            <b>ID Santri</b>: ATQ-<?= str_pad($s['id_santri'], 4, '0', STR_PAD_LEFT) ?><br>
            <b>Thn Masuk</b>: <?= $s['tahun_masuk'] ?><br>
            <b>Alamat</b>: <?= (strlen($s['alamat']) > 45) ? substr($s['alamat'], 0, 45) . '...' : $s['alamat']; ?>
        </div>
        
        <div class="footer">Sistem SiPontren - <?= date('d/m/Y H:i') ?></div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>