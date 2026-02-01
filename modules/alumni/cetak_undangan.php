<?php
include '../../config/database.php';
$angkatan = $_GET['angkatan'];
$query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' AND angkatan='$angkatan' ORDER BY nama_lengkap ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Undangan Reuni Angkatan <?= $angkatan ?></title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.6; padding: 40px; color: #000; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 30px; position: relative; }
        .logo-kop { position: absolute; left: 0; top: 0; width: 80px; }
        .kop-surat h2 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .kop-surat p { margin: 5px 0 0; font-size: 14px; font-style: italic; }
        
        .isi-surat { text-align: justify; margin-bottom: 20px; }
        .tabel-alumni { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .tabel-alumni th, .tabel-alumni td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 14px; }
        .tabel-alumni th { background-color: #f2f2f2; }
        
        .ttd { float: right; width: 250px; text-align: center; margin-top: 50px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="kop-surat">
        <img src="../../assets/img/logo-attaupiqillah.png" class="logo-kop">
        <h2>PONDOK PESANTREN ATTAUPIQILLAH</h2>
        <p>Jl. Raya Leuwigoong, Karangsari, Kec. Leuwigoong, Kabupaten Garut, Jawa Barat</p>
        <p>Email: info@attaupiqillah.ac.id | Telp: (0262) 123456</p>
    </div>

    <div style="text-align: right; margin-bottom: 20px;">Garut, <?= date('d F Y') ?></div>

    <div class="isi-surat">
        <p>Nomor : 021/REUNI/ATQ/<?= date('Y') ?></p>
        <p>Perihal : <b>Undangan Silaturahmi & Reuni Akbar (Angkatan <?= $angkatan ?>)</b></p>
        <br>
        <p>Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p>Puji syukur kehadirat Allah SWT. Sholawat serta salam semoga senantiasa tercurah kepada Baginda Nabi Muhammad SAW. Dengan ini kami mengundang Bapak/Ibu/Saudara/i Alumni Angkatan <?= $angkatan ?> untuk menghadiri acara Reuni Akbar yang akan diselenggarakan pada:</p>
        
        <div style="margin-left: 30px;">
            <table>
                <tr><td>Hari/Tanggal</td><td>: Minggu, 21 Desember 2025</td></tr>
                <tr><td>Waktu</td><td>: 08.00 WIB s.d Selesai</td></tr>
                <tr><td>Tempat</td><td>: Lapangan Utama Ponpes Attaupiqillah</td></tr>
            </table>
        </div>

        <p>Berikut adalah daftar nama undangan untuk Angkatan <?= $angkatan ?>:</p>
        
        <table class="tabel-alumni">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat Terakhir</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($d = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td align="center"><?= $no++ ?></td>
                    <td><?= $d['nama_lengkap'] ?></td>
                    <td><?= $d['alamat'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <p>Demikian undangan ini kami sampaikan, atas kehadiran dan perhatiannya kami ucapkan terima kasih.</p>
        <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
    </div>

    <div class="ttd">
        Hormat Kami,<br>
        Ketua Panitia Reuni,<br><br><br><br><br>
        ( <b>..........................</b> )
    </div>
</body>
</html>