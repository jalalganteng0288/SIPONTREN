<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="fas fa-users me-2 text-primary"></i>Data Santri Aktif</h3>
    <a href="tambah.php" class="btn btn-primary px-4 shadow-sm"><i class="fas fa-plus me-1"></i>Tambah Santri</a>
</div>

<div class="card border-0 shadow-sm p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Nama Lengkap</th>
                    <th>Tgl Lahir</th>
                    <th>Nama Orang Tua</th>
                    <th>No. Telepon</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil data lengkap santri aktif
                $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='aktif' ORDER BY nama_lengkap ASC");
                while($row = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td class="ps-3">
                        <span class="fw-bold text-dark"><?= $row['nama_lengkap']; ?></span><br>
                        <small class="text-muted"><?= substr($row['alamat'], 0, 30); ?>...</small>
                    </td>
                    <td class="small">
                        <?= $row['tanggal_lahir'] ? date('d-m-Y', strtotime($row['tanggal_lahir'])) : '-'; ?>
                    </td>
                    <td class="small">
                        <i class="fas fa-user-friends me-1 text-secondary"></i> 
                        A: <?= $row['nama_ayah'] ?? '-'; ?><br>
                        I: <?= $row['nama_ibu'] ?? '-'; ?>
                    </td>
                    <td>
                        <a href="https://wa.me/<?= $row['no_telp']; ?>" target="_blank" class="text-success text-decoration-none small">
                            <i class="fab fa-whatsapp me-1"></i> <?= $row['no_telp'] ?? '-'; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success px-3"><?= $row['status']; ?></span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group shadow-sm">
                            <a href="cetak_kts.php?id=<?= $row['id_santri']; ?>" class="btn btn-white btn-sm text-primary" title="Cetak KTS" target="_blank">
                                <i class="fas fa-id-card"></i>
                            </a>
                            <a href="edit.php?id=<?= $row['id_santri']; ?>" class="btn btn-white btn-sm text-warning" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id_santri']; ?>" class="btn btn-white btn-sm text-danger" title="Hapus Data" onclick="return confirm('Hapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../layouts/footer.php'; ?>