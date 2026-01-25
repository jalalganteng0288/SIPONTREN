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
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil data santri aktif
                $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='aktif' ORDER BY nama_lengkap ASC");
                while($row = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td class="fw-bold"><?= $row['nama_lengkap']; ?></td>
                    <td class="small text-muted"><?= $row['alamat']; ?></td>
                    <td class="text-center"><span class="badge bg-success-subtle text-success px-3"><?= $row['status']; ?></span></td>
                    <td class="text-center">
                        <div class="btn-group shadow-sm">
                            <a href="edit.php?id=<?= $row['id_santri']; ?>" class="btn btn-white btn-sm text-warning"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $row['id_santri']; ?>" class="btn btn-white btn-sm text-danger" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../layouts/footer.php'; ?>