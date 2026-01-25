<?php
include 'config/database.php'; // Hubungkan database

// Menghitung statistik
$total_santri = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='aktif'"));
$total_guru = mysqli_num_rows(mysqli_query($conn, "SELECT id_guru FROM guru"));
$total_uang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total FROM keuangan"));

// TAMBAHAN: Menghitung total alumni
$total_alumni = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='alumni'"));
$q_keluar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_pengeluaran) as total FROM pengeluaran"));
$total_pengeluaran = $q_keluar['total'] ?? 0;
include 'layouts/header.php'; // Sertakan header modern
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-danger text-white shadow h-100 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase small">Total Pengeluaran</h6>
                    <h2 class="fw-bold">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></h2>
                </div>
                <i class="fas fa-arrow-up fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white shadow h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Santri Aktif</h6>
                    <h2 class="mb-0 fw-bold"><?= $total_santri ?></h2>
                </div>
                <i class="fas fa-user-graduate fa-2x opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white shadow h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Total Alumni</h6>
                    <h2 class="mb-0 fw-bold"><?= $total_alumni ?></h2>
                </div>
                <i class="fas fa-graduation-cap fa-2x opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white shadow h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Total Guru</h6>
                    <h2 class="mb-0 fw-bold"><?= $total_guru ?></h2>
                </div>
                <i class="fas fa-chalkboard-teacher fa-2x opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white shadow h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Kas Masuk</h6>
                    <h2 class="mb-0 fw-bold">Rp <?= number_format($total_uang['total'] ?? 0, 0, ',', '.') ?></h2>
                </div>
                <i class="fas fa-wallet fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 p-4">
            <h5 class="fw-bold">Selamat Datang, Admin!</h5>
            <p class="text-muted mb-0">Sistem Informasi Pondok Pesantren (SiPontren) siap membantu pengelolaan data operasional Anda.</p>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>