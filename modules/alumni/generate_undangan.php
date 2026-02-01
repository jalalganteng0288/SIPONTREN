<?php
include '../../config/database.php';

$angkatan = $_GET['angkatan'];
$query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' AND angkatan='$angkatan' ORDER BY nama_lengkap ASC");

// HEADER UNTUK DOWNLOAD KE WORD
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; fw-bold; filename=Undangan_Reuni_Angkatan_$angkatan.doc");
?>

<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">
<head>
    <style>
        @page { size: 21cm 29.7cm; margin: 2cm; }
        body { font-family: 'Times New Roman', serif; }
        .page-break { page-break-after: always; } /* Ini kunci agar tiap nama beda halaman */
        .header-kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; }
        .isi-surat { margin-top: 30px; text-align: justify; line-height: 1.5; }
        .ttd-box { margin-top: 50px; float: right; width: 250px; text-align: center; }
    </style>
</head>
<body>

<?php while($d = mysqli_fetch_assoc($query)): ?>
    <div class="page-break">
        <div class="header-kop">
            <h2 style="margin:0;">PONDOK PESANTREN ATTAUPIQILLAH</h2>
            <p style="margin:0;"><i>Jl. Raya Leuwigoong, Karangsari, Kec. Leuwigoong, Kab. Garut</i></p>
            <p style="margin:0;"><b>GARUT - JAWA BARAT</b></p>
        </div>

        <div style="text-align: right; margin-top: 20px;">Garut, <?= date('d F Y') ?></div>

        <div class="isi-surat">
            <p>Nomor : 021/REUNI/ATQ/<?= date('Y') ?><br>
            Lampiran : -<br>
            Perihal : <b>UNDANGAN REUNI AKBAR</b></p>

            <p style="margin-top: 20px;">Kepada Yth,<br>
            <b>Ananda <?= $data['nama_lengkap'] ?></b><br>
            Di Tempat</p>

            <p style="margin-top: 20px;"><i>Assalamu'alaikum Wr. Wb.</i></p>
            
            <p>Sehubungan dengan akan dilaksanakannya acara Silaturahmi dan Reuni Akbar Alumni Pondok Pesantren Attaupiqillah Angkatan <?= $angkatan ?>, kami mengharapkan kehadiran Ananda pada:</p>

            <table style="margin-left: 50px; margin-top: 10px;">
                <tr><td>Hari/Tanggal</td><td>: <b>Minggu, 21 Desember 2025</b></td></tr>
                <tr><td>Waktu</td><td>: 08.00 WIB s/d Selesai</td></tr>
                <tr><td>Tempat</td><td>: Aula Ponpes Attaupiqillah</td></tr>
                <tr><td>Agenda</td><td>: Temu Kangen & Doa Bersama</td></tr>
            </table>

            <p style="margin-top: 20px;">Demikian undangan ini kami sampaikan. Mengingat pentingnya acara ini, kehadiran Ananda sangat kami harapkan. Atas perhatiannya kami ucapkan terima kasih.</p>
            
            <p><i>Wassalamu'alaikum Wr. Wb.</i></p>
        </div>

        <div class="ttd-box">
            Mengetahui,<br>
            Pimpinan Pondok Pesantren<br><br><br><br>
            <b>KH. DAHLAN FAUZI</b>
        </div>
        <div style="clear:both;"></div>
    </div>
<?php endwhile; ?>

</body>
</html>