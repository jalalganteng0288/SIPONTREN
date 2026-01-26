<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-file-alt me-2 text-primary"></i>Laporan Absensi Bulanan</h5>
    
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="bulan" class="form-select">
                <?php
                $nama_bulan = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                foreach($nama_bulan as $m => $nama) {
                    $s = ($m == $bulan) ? 'selected' : '';
                    echo "<option value='$m' $s>$nama</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Santri</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Izin</th>
                    <th class="text-center">Alpa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT s.nama_lengkap, 
                    SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN a.status = 'Sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN a.status = 'Izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN a.status = 'Tidak Hadir' THEN 1 ELSE 0 END) as alpa
                    FROM santri s
                    LEFT JOIN absensi a ON s.id_santri = a.id_santri 
                    AND MONTH(a.tanggal) = '$bulan' AND YEAR(a.tanggal) = '$tahun'
                    WHERE s.status = 'aktif'
                    GROUP BY s.id_santri");
                
                while($row = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td><?= $row['nama_lengkap'] ?></td>
                    <td class="text-center"><?= $row['hadir'] ?></td>
                    <td class="text-center text-warning"><?= $row['sakit'] ?></td>
                    <td class="text-center text-primary"><?= $row['izin'] ?></td>
                    <td class="text-center text-danger"><?= $row['alpa'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>