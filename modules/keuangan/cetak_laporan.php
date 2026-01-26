<?php 
include '../../config/database.php';

// Pastikan variabel bulan dikonversi menjadi integer agar "01" menjadi 1
$bulan = (int)$_GET['bulan']; 
$tahun = $_GET['tahun'];

$nama_bulan = [
    1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 
    7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
];

// Query Data Pemasukan
$q_masuk = mysqli_query($conn, "SELECT k.*, s.nama_lengkap 
                                FROM keuangan k 
                                JOIN santri s ON k.id_santri = s.id_santri 
                                WHERE MONTH(tgl_bayar)='$bulan' AND YEAR(tgl_bayar)='$tahun'");

// Query Data Pengeluaran
$q_keluar = mysqli_query($conn, "SELECT * FROM pengeluaran 
                                 WHERE MONTH(tgl_pengeluaran)='$bulan' AND YEAR(tgl_pengeluaran)='$tahun'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Keuangan <?= $nama_bulan[$bulan] ?> <?= $tahun ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; margin: 40px; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        h2, h3 { margin: 2px 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f2f2f2; text-transform: uppercase; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .saldo-box { margin-top: 30px; border: 2px solid #000; padding: 10px; width: fit-content; font-size: 14px; font-weight: bold; }
        .ttd-container { margin-top: 50px; display: flex; justify-content: flex-end; }
        .ttd-box { width: 250px; text-align: center; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Laporan Keuangan Bulanan</h2>
        <h3>Pondok Pesantren Attaupiqillah</h3>
        <p>Periode: <strong><?= $nama_bulan[$bulan] ?> <?= $tahun ?></strong></p>
    </div>

    <h4>A. Rincian Pemasukan (Syahriah & Masak)</h4>
    <table>
        <thead>
            <tr>
                <th width="10%">Tgl</th>
                <th>Nama Santri</th>
                <th width="20%">Syahriah</th>
                <th width="20%">Uang Masak</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $t_masuk = 0;
            while($r = mysqli_fetch_assoc($q_masuk)) { 
                $t_masuk += $r['jumlah_bayar'];
            ?>
            <tr>
                <td class="text-center"><?= date('d/m/y', strtotime($r['tgl_bayar'])) ?></td>
                <td><?= $r['nama_lengkap'] ?></td>
                <td class="text-right">Rp <?= number_format($r['bayar_syahriah'], 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($r['bayar_masak'], 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($r['jumlah_bayar'], 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PEMASUKAN</td>
                <td class="text-right">Rp <?= number_format($t_masuk, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <h4 style="margin-top: 30px;">B. Rincian Pengeluaran</h4>
    <table>
        <thead>
            <tr>
                <th width="10%">Tgl</th>
                <th>Jenis Pengeluaran</th>
                <th width="20%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $t_keluar = 0;
            if(mysqli_num_rows($q_keluar) > 0) {
                while($rk = mysqli_fetch_assoc($q_keluar)) { 
                    $t_keluar += $rk['jumlah_pengeluaran'];
            ?>
            <tr>
                <td class="text-center"><?= date('d/m/y', strtotime($rk['tgl_pengeluaran'])) ?></td>
                <td><?= $rk['jenis_pengeluaran'] ?></td>
                <td class="text-right">Rp <?= number_format($rk['jumlah_pengeluaran'], 0, ',', '.') ?></td>
            </tr>
            <?php } 
            } else { ?>
                <tr><td colspan="3" class="text-center">Tidak ada pengeluaran bulan ini.</td></tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTAL PENGELUARAN</td>
                <td class="text-right">Rp <?= number_format($t_keluar, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <div class="saldo-box">
        SALDO AKHIR BULAN INI: Rp <?= number_format($t_masuk - $t_keluar, 0, ',', '.') ?>
    </div>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Garut, <?= date('d F Y') ?></p>
            <p>Bendahara Pondok,</p>
            <br><br><br><br>
            <p><strong>( ________________ )</strong></p>
        </div>
    </div>
</body>
</html>