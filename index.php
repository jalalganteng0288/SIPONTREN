<?php
include 'config/database.php';

// 1. Statistik Dasar
$total_santri = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='aktif'"));
$total_guru = mysqli_num_rows(mysqli_query($conn, "SELECT id_guru FROM guru"));
$total_alumni = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='alumni'"));

// 2. Statistik Keuangan
$q_uang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total FROM keuangan"));
$total_uang = $q_uang['total'] ?? 0;
$q_keluar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_pengeluaran) as total FROM pengeluaran"));
$total_pengeluaran = $q_keluar['total'] ?? 0;
$saldo_akhir = $total_uang - $total_pengeluaran;

// 3. Logika Hari Indonesia
$hari_indo = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
$hari_sekarang = $hari_indo[date('l')];
$total_santri_baru = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='baru'"));

include 'layouts/header.php';
?>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .stat-card {
        transition: transform 0.3s;
        border: none;
    }

    .stat-card:hover {
        transform: translateY(-10px);
    }

    .card-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        bottom: 20px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row g-4 mb-4">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card stat-card bg-primary text-white p-3 shadow">
                <h6 class="text-uppercase small fw-bold">Santri Aktif</h6>
                <h2 class="fw-bold mb-0"><?= $total_santri ?></h2>
                <i class="fas fa-user-graduate card-icon"></i>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card stat-card bg-success text-white p-3 shadow">
                <h6 class="text-uppercase small fw-bold">Total Guru</h6>
                <h2 class="fw-bold mb-0"><?= $total_guru ?></h2>
                <i class="fas fa-chalkboard-teacher card-icon"></i>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card stat-card bg-warning text-dark p-3 shadow">
                <h6 class="text-uppercase small fw-bold">Kas Masuk</h6>
                <h2 class="fw-bold mb-0">Rp <?= number_format($total_uang, 0, ',', '.') ?></h2>
                <i class="fas fa-wallet card-icon"></i>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card stat-card bg-danger text-white p-3 shadow">
                <h6 class="text-uppercase small fw-bold">Pengeluaran</h6>
                <h2 class="fw-bold mb-0">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></h2>
                <i class="fas fa-shopping-cart card-icon"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" data-aos="zoom-in">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Grafik Arus Kas</h6>
                </div>
                <div class="card-body">
                    <canvas id="keuanganChart" height="100"></canvas>
                </div>
            </div>

            <div class="card border-0 shadow-sm" data-aos="fade-right">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-primary mb-0"><i class="fas fa-calendar-day me-2"></i>Jadwal Hari Ini (<?= $hari_sekarang ?>)</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Jam</th>
                                <th>Kitab</th>
                                <th>Guru</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q_j = "SELECT j.*, g.nama_guru, k.nama_kitab FROM jadwal_mengajar j 
                                    JOIN guru g ON j.id_guru = g.id_guru 
                                    JOIN master_kitab k ON j.id_kitab = k.id_kitab 
                                    WHERE j.hari = '$hari_sekarang' ORDER BY j.jam_mulai ASC";
                            $res_j = mysqli_query($conn, $q_j);
                            while ($rj = mysqli_fetch_assoc($res_j)) { ?>
                                <tr>
                                    <td class="ps-4"><?= substr($rj['jam_mulai'], 0, 5) ?></td>
                                    <td class="fw-bold"><?= $rj['nama_kitab'] ?></td>
                                    <td><?= $rj['nama_guru'] ?></td>
                                    <td><span class="badge bg-info-subtle text-info"><?= $rj['kelas'] ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 bg-dark text-white shadow mb-4" data-aos="flip-left">
                <div class="card-body text-center py-4">
                    <small class="text-uppercase opacity-75">Saldo Bersih Saat Ini</small>
                    <h2 class="fw-bold mt-2 text-warning">Rp <?= number_format($saldo_akhir, 0, ',', '.') ?></h2>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4" data-aos="fade-left">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-danger mb-0"><i class="fas fa-bell me-2"></i>Belum Bayar Syahriah</h6>
                </div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        <?php
                        $bln = date('m');
                        $thn = date('Y');
                        $q_t = "SELECT id_santri, nama_lengkap FROM santri WHERE status = 'aktif' AND id_santri NOT IN 
                                (SELECT id_santri FROM keuangan WHERE MONTH(tgl_bayar) = '$bln' AND YEAR(tgl_bayar) = '$thn') LIMIT 5";
                        $res_t = mysqli_query($conn, $q_t);
                        while ($rt = mysqli_fetch_assoc($res_t)) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="small fw-bold"><?= $rt['nama_lengkap'] ?></span>
                                <a href="modules/keuangan/bayar.php?id=<?= $rt['id_santri'] ?>" class="btn btn-sm btn-outline-danger py-0">Bayar</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm" data-aos="fade-left" data-aos-delay="200">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="fas fa-history me-2"></i>Log Keuangan</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php
                        $q_l = "SELECT k.*, s.nama_lengkap FROM keuangan k JOIN santri s ON k.id_santri = s.id_santri ORDER BY id_bayar DESC LIMIT 3";
                        $res_l = mysqli_query($conn, $q_l);
                        while ($rl = mysqli_fetch_assoc($res_l)) { ?>
                            <li class="list-group-item border-0 pb-3">
                                <small class="text-muted d-block"><?= date('d M Y', strtotime($rl['tgl_bayar'])) ?></small>
                                <span class="small"><?= $rl['nama_lengkap'] ?> membayar Rp <?= number_format($rl['jumlah_bayar'], 0, ',', '.') ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });

    // Script Grafik Keuangan
    const ctx = document.getElementById('keuanganChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Kas Masuk', 'Pengeluaran', 'Saldo Akhir'],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [<?= $total_uang ?>, <?= $total_pengeluaran ?>, <?= $saldo_akhir ?>],
                backgroundColor: ['#198754', '#dc3545', '#ffc107'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include 'layouts/footer.php'; ?>