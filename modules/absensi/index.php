<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

// 1. Tangkap variabel filter dari URL (GET)
$filter_tgl    = isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d');
$filter_kelas  = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// 2. Statistik sederhana (Tetap berdasarkan tanggal yang difilter)
$hadir = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Hadir' AND tanggal='$filter_tgl'"));
$sakit = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Sakit' AND tanggal='$filter_tgl'"));
$izin  = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Izin' AND tanggal='$filter_tgl'"));
$alpa  = mysqli_num_rows(mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE status='Tidak Hadir' AND tanggal='$filter_tgl'"));
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Sistem Absensi</h2>
        <p class="text-muted small">Total pada <?= date('d/m/Y', strtotime($filter_tgl)) ?>: <?php echo ($hadir + $sakit + $izin + $alpa); ?> santri</p>
    </div>
    <div class="d-flex gap-2">
        <a href="tambah.php" class="btn btn-dark"><i class="fas fa-plus me-2"></i>Tambah Absensi</a>
        <a href="laporan.php" class="btn btn-outline-dark"><i class="fas fa-file-alt me-2"></i>Laporan</a>
    </div>
</div>

<div class="row mb-4 text-center">
    <div class="col-md-3">
        <div class="card border-success-subtle bg-success-subtle p-3 rounded-4"><small class="text-success">Hadir</small>
            <h2 class="fw-bold text-success mb-0"><?= $hadir ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning-subtle bg-warning-subtle p-3 rounded-4"><small class="text-warning">Sakit</small>
            <h2 class="fw-bold text-warning mb-0"><?= $sakit ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-primary-subtle bg-primary-subtle p-3 rounded-4"><small class="text-primary">Izin</small>
            <h2 class="fw-bold text-primary mb-0"><?= $izin ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-danger-subtle bg-danger-subtle p-3 rounded-4"><small class="text-danger">Tidak Hadir</small>
            <h2 class="fw-bold text-danger mb-0"><?= $alpa ?></h2>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="" method="GET" id="formFilter" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="small text-muted mb-2">Tanggal</label>
                <input type="date" name="tgl" class="form-control rounded-3" value="<?= $filter_tgl ?>" onchange="this.form.submit()">
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-2">Kelas</label>
                <select name="kelas" class="form-select rounded-3" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    <?php 
                    $list_kelas = ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4'];
                    foreach($list_kelas as $k) {
                        $selected = ($filter_kelas == $k) ? 'selected' : '';
                        echo "<option value='$k' $selected>$k</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-2">Status</label>
                <select name="status" class="form-select rounded-3" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <?php 
                    $list_status = ['Hadir', 'Sakit', 'Izin', 'Tidak Hadir'];
                    foreach($list_status as $s) {
                        $selected = ($filter_status == $s) ? 'selected' : '';
                        echo "<option value='$s' $selected>$s</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <a href="index.php" class="btn btn-light w-100 rounded-3">Reset Filter</a>
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
                    <th>Pelajaran / Kitab</th>
                    <th>Guru</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 3. Bangun query dinamis berdasarkan filter
                $where = "WHERE a.tanggal = '$filter_tgl'";
                if ($filter_kelas != '') {
                    $where .= " AND j.kelas = '$filter_kelas'";
                }
                if ($filter_status != '') {
                    $where .= " AND a.status = '$filter_status'";
                }

                $query_absen = "SELECT a.*, s.nama_lengkap, k.nama_kitab, g.nama_guru, j.kelas
                        FROM absensi a
                        JOIN santri s ON a.id_santri = s.id_santri
                        JOIN jadwal_mengajar j ON a.id_jadwal = j.id_jadwal
                        JOIN master_kitab k ON j.id_kitab = k.id_kitab
                        JOIN guru g ON j.id_guru = g.id_guru
                        $where
                        ORDER BY a.id_absensi DESC";
                
                $res_absen = mysqli_query($conn, $query_absen);

                if (mysqli_num_rows($res_absen) == 0) {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Tidak ada data absensi untuk filter ini.</td></tr>";
                }

                while ($row = mysqli_fetch_assoc($res_absen)) { ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?= $row['nama_lengkap'] ?> <br><small class="text-muted"><?= $row['kelas'] ?></small></td>
                        <td><?= $row['nama_kitab'] ?></td>
                        <td><?= $row['nama_guru'] ?></td>
                        <td>
                            <?php 
                            $badge_class = 'bg-danger';
                            if($row['status'] == 'Hadir') $badge_class = 'bg-success';
                            if($row['status'] == 'Sakit') $badge_class = 'bg-warning';
                            if($row['status'] == 'Izin') $badge_class = 'bg-primary';
                            ?>
                            <span class="badge <?= $badge_class ?>"><?= $row['status'] ?></span>
                        </td>
                        <td><?= $row['keterangan'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>