<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$tgl_hari_ini = date('Y-m-d');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-check-double me-2"></i> Presensi Santri</h3>
    <a href="input_absen.php" class="btn btn-primary"><i class="fas fa-edit me-1"></i> Isi Absen Hari Ini</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Absensi (Terbaru)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Santri</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT absensi.*, santri.nama_lengkap 
                            FROM absensi 
                            JOIN santri ON absensi.id_santri = santri.id_santri 
                            ORDER BY tgl_absen DESC, id_absen DESC LIMIT 20";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                        $badge = '';
                        switch($row['status_absen']) {
                            case 'hadir': $badge = 'bg-success'; break;
                            case 'sakit': $badge = 'bg-warning text-dark'; break;
                            case 'izin': $badge = 'bg-info text-dark'; break;
                            case 'alpha': $badge = 'bg-danger'; break;
                        }
                        echo "<tr>
                            <td>".date('d/m/Y', strtotime($row['tgl_absen']))."</td>
                            <td>{$row['nama_lengkap']}</td>
                            <td><span class='badge {$badge}'>".strtoupper($row['status_absen'])."</span></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>