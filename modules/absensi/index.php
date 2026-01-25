<?php
include '../../config/database.php';
include '../../layouts/header.php';

$tgl_hari_ini = date('Y-m-d');

// Perbaikan Query Statistik agar tidak fatal error
$q_hadir = mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Hadir' AND tanggal='$tgl_hari_ini'");
$hadir = ($q_hadir) ? mysqli_num_rows($q_hadir) : 0;

$q_sakit = mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Sakit' AND tanggal='$tgl_hari_ini'");
$sakit = ($q_sakit) ? mysqli_num_rows($q_sakit) : 0;

$q_izin = mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Izin' AND tanggal='$tgl_hari_ini'");
$izin = ($q_izin) ? mysqli_num_rows($q_izin) : 0;

$q_alpa = mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Tidak Hadir' AND tanggal='$tgl_hari_ini'");
$alpa = ($q_alpa) ? mysqli_num_rows($q_alpa) : 0;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Sistem Absensi</h2>
    <a href="tambah.php" class="btn btn-dark shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Absensi</a>
</div>

<div class="row mb-4 text-center">
    <div class="col-md-3">
        <div class="card bg-success-subtle p-3 border-0 rounded-4 text-success small fw-bold">Hadir<br><span class="fs-2"><?= $hadir ?></span></div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning-subtle p-3 border-0 rounded-4 text-warning small fw-bold">Sakit<br><span class="fs-2"><?= $sakit ?></span></div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary-subtle p-3 border-0 rounded-4 text-primary small fw-bold">Izin<br><span class="fs-2"><?= $izin ?></span></div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger-subtle p-3 border-0 rounded-4 text-danger small fw-bold">Alpa<br><span class="fs-2"><?= $alpa ?></span></div>
    </div>
</div>