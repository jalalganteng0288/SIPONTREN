<?php 
include '../../config/database.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT keuangan.*, santri.nama_lengkap, santri.nis 
                               FROM keuangan JOIN santri ON keuangan.id_santri = santri.id_santri 
                               WHERE id_bayar='$id'");
$d = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kuitansi Pembayaran</title>
    <style>body { font-family: sans-serif; }</style>
</head>
<body onload="window.print()">
    <h2>BUKTI PEMBAYARAN PONDOK</h2>
    <hr>
    <p>NIS: <?= $d['nis'] ?></p>
    <p>Nama: <?= $d['nama_lengkap'] ?></p>
    <p>Tanggal: <?= $d['tgl_bayar'] ?></p>
    <p>Jumlah: Rp <?= number_format($d['jumlah_bayar']) ?></p>
    <p>Keterangan: <?= $d['keterangan'] ?></p>
</body>
</html>