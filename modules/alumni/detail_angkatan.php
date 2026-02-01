<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 

$no_angkatan = isset($_GET['angkatan']) ? $_GET['angkatan'] : ''; 
?>

<div class="container-fluid p-4">
    <div class="mb-3" data-aos="fade-right">
        <a href="index.php" class="text-decoration-none small text-muted font-weight-bold"><i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Angkatan</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <h3 class="fw-bold">Alumni Angkatan <?= $no_angkatan ?></h3>
        <button class="btn btn-dark btn-sm shadow-sm" onclick="window.print()"><i class="fas fa-print me-1"></i> Cetak Daftar</button>
    </div>

    <div class="card shadow-sm border-0" data-aos="fade-up">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Nama Alumni</th>
                            <th>No. WhatsApp</th>
                            <th>Alamat Terakhir</th>
                            <th class="text-center">Status Sosial</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' AND angkatan='$no_angkatan' ORDER BY nama_lengkap ASC");
                        while($data = mysqli_fetch_assoc($query)) {
                            $badge = ($data['status_sosial'] == 'Meninggal') ? 'bg-danger' : 'bg-info';
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary"><?= $data['nama_lengkap'] ?></td>
                            <td>
                                <a href="https://wa.me/<?= $data['no_telp'] ?>" target="_blank" class="text-success text-decoration-none small">
                                    <i class="fab fa-whatsapp me-1"></i> <?= $data['no_telp'] ?? '-' ?>
                                </a>
                            </td>
                            <td class="small text-muted"><?= $data['alamat'] ?? '-' ?></td>
                            <td class="text-center">
                                <span class="badge <?= $badge ?> rounded-pill px-3"><?= $data['status_sosial'] ?? 'Hidup' ?></span>
                            </td>
                            <td class="text-center">
                                <a href="../santri/edit.php?id=<?= $data['id_santri'] ?>" class="btn btn-link text-warning p-0 me-2"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>