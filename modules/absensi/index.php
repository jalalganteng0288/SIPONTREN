<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

// Statistik sederhana
$tgl_hari_ini = date('Y-m-d');
$hadir = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Hadir' AND tanggal='$tgl_hari_ini'"));
$sakit = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Sakit' AND tanggal='$tgl_hari_ini'"));
$izin = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Izin' AND tanggal='$tgl_hari_ini'"));
$alpa = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Tidak Hadir' AND tanggal='$tgl_hari_ini'"));
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Sistem Absensi</h2>
        <p class="text-muted small">Total hari ini: <?php echo ($hadir+$sakit+$izin+$alpa); ?> santri</p>
    </div>
    <div class="d-flex gap-2">
        <a href="tambah.php" class="btn btn-dark"><i class="fas fa-plus me-2"></i>Tambah Absensi</a>
        <a href="laporan.php" class="btn btn-outline-dark"><i class="fas fa-file-alt me-2"></i>Laporan</a>
    </div>
</div>

<div class="row mb-4 text-center">
    <div class="col-md-3"><div class="card border-success-subtle bg-success-subtle p-3 rounded-4"><small class="text-success">Hadir</small><h2 class="fw-bold text-success mb-0"><?= $hadir ?></h2></div></div>
    <div class="col-md-3"><div class="card border-warning-subtle bg-warning-subtle p-3 rounded-4"><small class="text-warning">Sakit</small><h2 class="fw-bold text-warning mb-0"><?= $sakit ?></h2></div></div>
    <div class="col-md-3"><div class="card border-primary-subtle bg-primary-subtle p-3 rounded-4"><small class="text-primary">Izin</small><h2 class="fw-bold text-primary mb-0"><?= $izin ?></h2></div></div>
    <div class="col-md-3"><div class="card border-danger-subtle bg-danger-subtle p-3 rounded-4"><small class="text-danger">Tidak Hadir</small><h2 class="fw-bold text-danger mb-0"><?= $alpa ?></h2></div></div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="small text-muted mb-2">Tanggal</label>
                <input type="date" class="form-control rounded-3" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-2">Kelas</label>
                <select class="form-select rounded-3">
                    <option value="">Semua Kelas</option>
                    <option value="Kelas 1">Kelas 1</option>
                    <option value="Kelas 2">Kelas 2</option>
                    <option value="Kelas 3">Kelas 3</option>
                    <option value="Kelas 4">Kelas 4</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-2">Status</label>
                <select class="form-select rounded-3">
                    <option value="">Semua Status</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Tidak Hadir">Tidak Hadir</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3">Nama Santri</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6" class="text-center py-5 text-muted">Silakan pilih filter untuk menampilkan data</td></tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>