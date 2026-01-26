<?php 
include '../../config/database.php';

// 1. Pastikan variabel bulan dikonversi menjadi integer agar "01" menjadi 1
// Ini memperbaiki error 'Undefined array key "01"'
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('m'); 
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');

$nama_bulan = [
    1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 
    7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
];

// 2. Query Data Pemasukan
// Mengambil data berdasarkan bulan dan tahun dari kolom tgl_bayar
$q_masuk = mysqli_query($conn, "SELECT k.*, s.nama_lengkap 
                                FROM keuangan k 
                                JOIN santri s ON k.id_santri = s.id_santri 
                                WHERE MONTH(k.tgl_bayar)='$bulan' AND YEAR(k.tgl_bayar)='$tahun'
                                ORDER BY k.tgl_bayar ASC");

// 3. Query Data Pengeluaran
// Perbaikan: Pastikan kolom tgl_pengeluaran sesuai dengan struktur tabel pengeluaran Anda
$q_keluar = mysqli_query($conn, "SELECT * FROM pengeluaran 
                                 WHERE MONTH(tgl_pengeluaran) = '$bulan' 
                                 AND YEAR(tgl_pengeluaran) = '$tahun' 
                                 ORDER BY tgl_pengeluaran ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan <?= $nama_bulan[$bulan] ?> <?= $tahun ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; margin: 40px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        h2, h3 { margin: 2px 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f2f2f2; text-transform: uppercase; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .saldo-box { margin-top: 30px; border: 2px solid #000; padding: 15px; width: fit-content; font-size: 14px; font-weight: bold; background: #fff; }
        .ttd-container { margin-top: 50px; display: flex; justify-content: flex-end; }
        .ttd-box { width: 250px; text-align: center; }
        @media print { 
            .no-print { display: none; }
            body { margin: 20px; }
        }
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
                <th width="12%">Tanggal</th>
                <th>Nama Santri</th>
                <th width="18%">Syahriah</th>
                <th width="18%">Uang Masak</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $t_masuk = 0;
            if(mysqli_num_rows($q_masuk) > 0) {
                while($r = mysqli_fetch_assoc($q_masuk)) { 
                    $t_masuk += $r['jumlah_bayar'];
                ?>
                <tr>
                    <td class="text-center"><?= date('d/m/Y', strtotime($r['tgl_bayar'])) ?></td>
                    <td><?= $r['nama_lengkap'] ?></td>
                    <td class="text-right">Rp <?= number_format($r['bayar_syahriah'], 0, ',', '.') ?></td>
                    <td class="text-right">Rp <?= number_format($r['bayar_masak'], 0, ',', '.') ?></td>
                    <td class="text-right">Rp <?= number_format($r['jumlah_bayar'], 0, ',', '.') ?></td>
                </tr>
                <?php } 
            } else { ?>
                <tr><td colspan="5" class="text-center text-muted">Belum ada data pemasukan bulan ini.</td></tr>
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
                <th width="12%">Tanggal</th>
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
                <td class="text-center"><?= date('d/m/Y', strtotime($rk['tgl_pengeluaran'])) ?></td>
                <td><?= $rk['jenis_pengeluaran'] ?></td>
                <td class="text-right">Rp <?= number_format($rk['jumlah_pengeluaran'], 0, ',', '.') ?></td>
            </tr>
            <?php } 
            } else { ?>
                <tr><td colspan="3" class="text-center text-muted">Tidak ada pengeluaran bulan ini.</td></tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTAL PENGELUARAN</td>
                <td class="text-right">Rp <?= number_format($t_keluar, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <?php $saldo_akhir = $t_masuk - $t_keluar; ?>
    <div class="saldo-box">
        SALDO AKHIR BULAN INI: <span style="color: <?= $saldo_akhir < 0 ? 'red' : 'green' ?>;">Rp <?= number_format($saldo_akhir, 0, ',', '.') ?></span>
    </div>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Garut, <?= date('d F Y') ?></p>
            <p>Bendahara Pondok,</p>
            <br><br><br><br>
            <p><strong>( ________________ )</strong></p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>
</body>
</html>