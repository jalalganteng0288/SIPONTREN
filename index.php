<?php 
include 'config/database.php';
// Menghitung statistik sederhana
$total_santri = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='aktif'"));
$total_guru = mysqli_num_rows(mysqli_query($conn, "SELECT id_guru FROM guru"));
$total_uang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total FROM keuangan"));

include 'layouts/header.php'; 
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Santri</h6>
                        <h2 class="mb-0"><?= $total_santri ?></h2>
                    </div>
                    <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Guru</h6>
                        <h2 class="mb-0"><?= $total_guru ?></h2>
                    </div>
                    <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Kas Masuk</h6>
                        <h2 class="mb-0">Rp <?= number_format($total_uang['total'] ?? 0, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-wallet fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card p-4">
            <h5>Selamat Datang, Admin!</h5>
            <p class="text-muted">Gunakan menu di samping untuk mengelola data operasional pondok pesantren secara efisien.</p>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>