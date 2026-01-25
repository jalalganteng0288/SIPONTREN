<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

// Ambil total uang masuk
$total_query = mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total FROM keuangan");
$total_data = mysqli_fetch_assoc($total_query);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-money-bill-wave me-2"></i> Pengelolaan Keuangan</h3>
    <a href="bayar.php" class="btn btn-success"><i class="fas fa-plus-circle me-1"></i> Input Pembayaran</a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-start border-success border-4 shadow-sm">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Total Saldo Masuk</div>
                <h3 class="fw-bold text-success">Rp <?= number_format($total_data['total'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi Terbaru</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Santri</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT keuangan.*, santri.nama_lengkap 
                            FROM keuangan 
                            JOIN santri ON keuangan.id_santri = santri.id_santri 
                            ORDER BY tgl_bayar DESC LIMIT 10";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>".date('d/m/Y H:i', strtotime($row['tgl_bayar']))."</td>
                            <td>{$row['nama_lengkap']}</td>
                            <td class='text-success fw-bold'>Rp ".number_format($row['jumlah_bayar'], 0, ',', '.')."</td>
                            <td>{$row['keterangan']}</td>
                            <td>
                                <a href='cetak.php?id={$row['id_bayar']}' class='btn btn-outline-secondary btn-sm'><i class='fas fa-print'></i></a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>