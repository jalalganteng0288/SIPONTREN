<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

// Filter Bulan & Tahun dari form
$bulan_filter = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun_filter = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// KEMBALIKAN: Query Hitung Saldo Terpisah Berdasarkan Bulan
$q_syahriah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(bayar_syahriah) as total FROM keuangan WHERE MONTH(tgl_bayar)='$bulan_filter' AND YEAR(tgl_bayar)='$tahun_filter'"));
$q_masak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(bayar_masak) as total FROM keuangan WHERE MONTH(tgl_bayar)='$bulan_filter' AND YEAR(tgl_bayar)='$tahun_filter'"));
?>

<div class="card shadow-sm border-0 mb-4 text-center py-4">
    <h4 class="fw-bold text-primary mb-1">PEMBAYARAN BULANAN SANTRI</h4>
    <h5 class="fw-bold text-secondary">PONDOK PESANTREN ATTAUPIQILLAH</h5>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-4">
                <small class="text-uppercase fw-bold opacity-75">SYAHRIAH (Bulan ini)</small>
                <h2 class="fw-bold mb-0">Rp <?= number_format($q_syahriah['total'] ?? 0, 0, ',', '.') ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body p-4">
                <small class="text-uppercase fw-bold opacity-75">UANG MASAK (Bulan ini)</small>
                <h2 class="fw-bold mb-0">Rp <?= number_format($q_masak['total'] ?? 0, 0, ',', '.') ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex gap-2">
        <select name="bulan" class="form-select form-select-sm">
            <?php
            $bulan_list = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
            foreach($bulan_list as $n => $nama) {
                $s = ($n == $bulan_filter) ? 'selected' : '';
                echo "<option value='$n' $s>$nama</option>";
            }
            ?>
        </select>
        <input type="number" name="tahun" class="form-control form-control-sm" value="<?= $tahun_filter ?>" style="width: 80px;">
        <button type="submit" class="btn btn-sm btn-dark">Cari</button>
    </form>
    <a href="bayar.php" class="btn btn-primary btn-sm px-3">+ Tambah Pembayaran</a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Santri</th>
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
                while($row = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td class="fw-bold"><?= $row['nama_lengkap'] ?></td>
                    <td class="text-success fw-bold">Rp <?= number_format($row['bayar_syahriah'], 0, ',', '.') ?></td>
                    <td class="text-info fw-bold">Rp <?= number_format($row['bayar_masak'], 0, ',', '.') ?></td>
                    <td class="text-center">
                        <?= $row['beras_5kg'] == 'Sudah' ? '<span class="badge bg-success">✅</span>' : '<span class="badge bg-light">❌</span>' ?>
                    </td>
                    <td><span class="badge <?= $row['status_pembayaran'] == 'Lunas' ? 'bg-success' : 'bg-danger' ?>"><?= $row['status_pembayaran'] ?></span></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="edit_bayar.php?id=<?= $row['id_bayar'] ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $row['id_bayar'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                            <a href="cetak.php?id=<?= $row['id_bayar'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../layouts/footer.php'; ?>