<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

// Filter Bulan & Tahun dari form
$bulan_filter = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun_filter = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query Hitung Saldo Terpisah Berdasarkan Bulan
$q_syahriah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(bayar_syahriah) as total FROM keuangan WHERE MONTH(tgl_bayar)='$bulan_filter' AND YEAR(tgl_bayar)='$tahun_filter'"));
$q_masak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(bayar_masak) as total FROM keuangan WHERE MONTH(tgl_bayar)='$bulan_filter' AND YEAR(tgl_bayar)='$tahun_filter'"));
?>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

<style>
    .stat-card { transition: transform 0.3s; border: none; }
    .stat-card:hover { transform: translateY(-5px); }
</style>

<div class="card shadow-sm border-0 mb-4 text-center py-4" data-aos="fade-down">
    <h4 class="fw-bold text-primary mb-1">PEMBAYARAN BULANAN SANTRI</h4>
    <h5 class="fw-bold text-secondary small">PONDOK PESANTREN ATTAUPIQILLAH</h5>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3" data-aos="fade-right" data-aos-delay="100">
        <div class="card stat-card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase fw-bold opacity-75">SYAHRIAH (Bulan ini)</small>
                        <h2 class="fw-bold mb-0">Rp <?= number_format($q_syahriah['total'] ?? 0, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-hand-holding-usd fa-2x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3" data-aos="fade-left" data-aos-delay="200">
        <div class="card stat-card border-0 shadow-sm bg-info text-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase fw-bold opacity-75">UANG MASAK (Bulan ini)</small>
                        <h2 class="fw-bold mb-0">Rp <?= number_format($q_masak['total'] ?? 0, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-utensils fa-2x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3" data-aos="fade-up">
    <form method="GET" class="d-flex gap-2">
        <select name="bulan" class="form-select form-select-sm rounded-3">
            <?php
            $bulan_list = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
            foreach($bulan_list as $n => $nama) {
                $s = ($n == $bulan_filter) ? 'selected' : '';
                echo "<option value='$n' $s>$nama</option>";
            }
            ?>
        </select>
        <input type="number" name="tahun" class="form-control form-control-sm rounded-3" value="<?= $tahun_filter ?>" style="width: 100px;">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Cari</button>
    </form>
    <div class="d-flex gap-2">
        <a href="cetak_laporan.php?bulan=<?= $bulan_filter ?>&tahun=<?= $tahun_filter ?>" target="_blank" class="btn btn-outline-danger btn-sm px-3 rounded-3">
            <i class="fas fa-file-pdf me-1"></i> Cetak Laporan
        </a>
        <a href="bayar.php" class="btn btn-primary btn-sm px-3 rounded-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Pembayaran
        </a>
    </div>
</div>

<div class="card shadow-sm border-0" data-aos="zoom-in" data-aos-delay="300">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nama Santri</th>
                    <th>Syahriah</th>
                    <th>Uang Masak</th>
                    <th class="text-center">Beras 5kg</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT keuangan.*, santri.nama_lengkap FROM keuangan JOIN santri ON keuangan.id_santri = santri.id_santri WHERE MONTH(tgl_bayar)='$bulan_filter' AND YEAR(tgl_bayar)='$tahun_filter' ORDER BY tgl_bayar DESC");
                if (mysqli_num_rows($res) == 0) {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted small'>Belum ada riwayat pembayaran di bulan ini.</td></tr>";
                }
                while($row = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td class="ps-4 fw-bold text-dark"><?= $row['nama_lengkap'] ?></td>
                    <td class="text-success fw-bold">Rp <?= number_format($row['bayar_syahriah'], 0, ',', '.') ?></td>
                    <td class="text-info fw-bold">Rp <?= number_format($row['bayar_masak'], 0, ',', '.') ?></td>
                    <td class="text-center">
                        <?= $row['beras_5kg'] == 'Sudah' ? '<span class="badge bg-success-subtle text-success">Lengkap</span>' : '<span class="badge bg-light text-muted">Belum</span>' ?>
                    </td>
                    <td>
                        <span class="badge <?= $row['status_pembayaran'] == 'Lunas' ? 'bg-success' : 'bg-danger' ?> px-3">
                            <?= $row['status_pembayaran'] ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group shadow-sm">
                            <a href="edit_bayar.php?id=<?= $row['id_bayar'] ?>" class="btn btn-white btn-sm text-warning" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $row['id_bayar'] ?>" class="btn btn-white btn-sm text-danger" title="Hapus" onclick="return confirm('Hapus riwayat ini?')"><i class="fas fa-trash"></i></a>
                            <a href="cetak.php?id=<?= $row['id_bayar'] ?>" class="btn btn-white btn-sm text-secondary" title="Struk" target="_blank"><i class="fas fa-print"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

<?php include '../../layouts/footer.php'; ?>