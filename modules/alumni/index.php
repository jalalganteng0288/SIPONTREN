<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3><i class="fas fa-user-graduate me-2"></i> Data Alumni</h3>
        <p class="text-muted">Daftar santri yang telah menyelesaikan pendidikan.</p>
    </div>
    <a href="tambah.php" class="btn btn-success"><i class="fas fa-plus me-1"></i> Tambah Alumni</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nama Lengkap</th>
                    <th>No. Telepon</th>
                    <th>Status Kondisi</th>
                    <th class="text-center">Tahun Masuk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' ORDER BY nama_lengkap ASC");
                if(mysqli_num_rows($query) == 0) {
                    echo "<tr><td colspan='5' class='text-center'>Belum ada data alumni.</td></tr>";
                }
                while($data = mysqli_fetch_assoc($query)) { // Kita gunakan $data agar tidak tertukar
                    $badge = ($data['status_sosial'] == 'Meninggal') ? 'bg-danger' : 'bg-info';
                ?>
                <tr>
                    <td class="fw-bold"><?= $data['nama_lengkap'] ?></td>
                    <td><?= $data['no_telp'] ?? '-' ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $data['status_sosial'] ?? 'Hidup' ?></span></td>
                    <td class="text-center"><?= $data['tahun_masuk'] ?></td>
                    <td class="text-center">
                        <a href="../santri/edit.php?id=<?= $data['id_santri'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="../santri/hapus.php?id=<?= $data['id_santri'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>