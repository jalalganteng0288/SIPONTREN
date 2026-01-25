<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Manajemen Data Guru</h2>
        <p class="text-muted small">Total: <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id_guru FROM guru")); ?> guru</p>
    </div>
    <a href="tambah.php" class="btn btn-dark shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Guru</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari nama guru atau bidang mengajar...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Semua Bidang</option>
                    </select>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Email</th>
                        <th>Bidang Mengajar (Kitab)</th>
                        <th>No. Telepon</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama_guru ASC");
                    while($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td class="ps-4 fw-bold text-dark"><?= $row['nama_guru'] ?></td>
                        <td class="text-muted small"><?= $row['email'] ?? '-' ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $row['bidang_mengajar'] ?? '-' ?></span></td>
                        <td><?= $row['no_telp'] ?? '-' ?></td>
                        <td><span class="badge bg-success-subtle text-success px-3">Aktif</span></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id_guru'] ?>" class="btn btn-link text-primary p-0 me-2"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $row['id_guru'] ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus data guru?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>