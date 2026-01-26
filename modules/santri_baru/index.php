<?php
include '../../config/database.php';
include '../../layouts/header.php';
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-right">
        <h3 class="fw-bold"><i class="fas fa-users-cog text-info me-2"></i>Pendaftar Baru</h3>
        <a href="tambah.php" class="btn btn-primary shadow-sm">+ Tambah Pendaftar</a>
    </div>

    <div class="card border-0 shadow-sm" data-aos="zoom-in">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Nama Santri</th>
                        <th>Orang Tua</th>
                        <th>Pembayaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM santri WHERE status='baru' ORDER BY id_santri DESC");
                    while ($row = mysqli_fetch_assoc($res)) { ?>
                        <tr>
                            <td>
                                <?php if (!empty($row['foto_pribadi']) && file_exists("../../assets/uploads/santri/" . $row['foto_pribadi'])) : ?>
                                    <img src="../../assets/uploads/santri/<?= $row['foto_pribadi'] ?>" class="rounded" width="45" height="55" style="object-fit: cover;">
                                <?php else : ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 45px; height: 55px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold"><?= $row['nama_lengkap'] ?></span><br>
                                <small class="text-muted"><?= $row['no_telp'] ?></small>
                            </td>
                            <td><small>Ayah: <?= $row['nama_ayah'] ?><br>Ibu: <?= $row['nama_ibu'] ?></small></td>
                            <td>
                                <?php
                                // Menghitung akumulasi pembayaran untuk ditampilkan di tabel
                                $akumulasi_tabel = (int)$row['biaya_pendaftaran'] + (int)$row['biaya_kitab'];
                                ?>
                                <span class="badge bg-success-subtle text-success">
                                    Rp <?= number_format($akumulasi_tabel, 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="konfirmasi.php?id=<?= $row['id_santri'] ?>" class="btn btn-white btn-sm text-success" title="Konfirmasi Aktif"><i class="fas fa-check"></i></a>
                                    <a href="edit.php?id=<?= $row['id_santri'] ?>" class="btn btn-white btn-sm text-warning"><i class="fas fa-edit"></i></a>
                                    <a href="hapus.php?id=<?= $row['id_santri'] ?>" class="btn btn-white btn-sm text-danger"><i class="fas fa-trash"></i></a>
                                    <a href="cetak_kuitansi.php?id=<?= $row['id_santri'] ?>" target="_blank" class="btn btn-white btn-sm text-primary" title="Cetak Kuitansi">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>