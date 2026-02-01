<?php
include '../../config/database.php';
$angkatan = isset($_GET['angkatan']) ? $_GET['angkatan'] : '';

// Header untuk memaksa download sebagai file .doc yang kompetibel dengan Word
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Undangan_Reuni_Angkatan_$angkatan.doc");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <title>Undangan Reuni</title>
    <style>
        /* Pengaturan agar tiap alumni ganti halaman otomatis */
        @page {
            size: 21cm 29.7cm;
            margin: 2cm;
        }
        .break { page-break-after: always; }
        body { font-family: 'Times New Roman', serif; line-height: 1.5; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .isi { text-align: justify; }
        .ttd-container { margin-top: 50px; float: right; width: 250px; text-align: center; }
    </style>
</head>
<body>
<?php
$query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' AND angkatan='$angkatan' ORDER BY nama_lengkap ASC");
while($d = mysqli_fetch_assoc($query)): 
?>
    <div class="break">
        <div class="kop">
            <h2 style="margin:0;">PONDOK PESANTREN ATTAUPIQILLAH</h2>
            <p style="margin:0;"><i>Jl. Raya Leuwigoong No. 12, Karangsari, Leuwigoong, Garut</i></p>
            <p style="margin:0;"><b>JAWA BARAT - INDONESIA</b></p>
        </div>

        <div style="text-align: right; margin-bottom: 20px;">Garut, <?= date('d F Y') ?></div>

        <div class="isi">
            <p>Nomor : 005/REUNI-AKBAR/XI/2025<br>
            Perihal : <b>Undangan Reuni Akbar & Silaturahmi</b></p>

            <p style="margin-top: 25px;">Kepada Yth,<br>
            <b>Ananda <?= $d['nama_lengkap'] ?></b><br>
            Alumni Angkatan <?= $angkatan ?><br>
            di Tempat</p>

            <p><i>Assalamu’alaikum Warahmatullahi Wabarakatuh,</i></p>
            <p>Puji syukur kita panjatkan ke hadirat Allah SWT. Shalawat serta salam semoga senantiasa tercurah kepada Baginda Nabi Muhammad SAW.</p>
            <p>Kami mengharapkan kehadiran rekan-rekan alumni dalam acara <b>Reuni Akbar</b> yang akan dilaksanakan pada:</p>
            
            <table style="margin-left: 30px;">
                <tr><td>Hari/Tanggal</td><td>: Minggu, 21 Desember 2025</td></tr>
                <tr><td>Waktu</td><td>: 08.00 WIB s/d Selesai</td></tr>
                <tr><td>Tempat</td><td>: Kompleks Ponpes Attaupiqillah</td></tr>
            </table>

            <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadirannya, kami ucapkan terima kasih.</p>
            <p><i>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</i></p>
        </div>

        <div class="ttd-container">
            <p>Hormat Kami,<br>Ketua Panitia Reuni,</p>
            <br><br><br>
            <p><b>( .................................... )</b></p>
        </div>
        <div style="clear:both;"></div>
    </div>
<?php endwhile; ?>
</body>
</html>