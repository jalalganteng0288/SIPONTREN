<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 

// REKAPAN: Menghitung total alumni secara keseluruhan
$q_total = mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='alumni'");
$total_alumni = mysqli_num_rows($q_total);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3><i class="fas fa-user-graduate me-2"></i> Data Alumni</h3>
        <p class="text-muted">Total Keseluruhan: <b><?= $total_alumni ?> Alumni</b></p>
    </div>
    <a href="tambah.php" class="btn btn-success shadow-sm"><i class="fas fa-plus me-1"></i> Tambah Alumni</a>
</div>

<?php
// Mengambil daftar angkatan secara unik dari database
$sql_angkatan = mysqli_query($conn, "SELECT DISTINCT angkatan FROM santri WHERE status='alumni' AND angkatan IS NOT NULL ORDER BY angkatan ASC");

if(mysqli_num_rows($sql_angkatan) == 0) {
    echo "<div class='alert alert-info text-center'>Belum ada data alumni. Silakan tambah data baru.</div>";
}

while($row_angkatan = mysqli_fetch_assoc($sql_angkatan)) {
    $no_angkatan = $row_angkatan['angkatan'];
    // Hitung jumlah per angkatan
    $jml_per = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='alumni' AND angkatan='$no_angkatan'"));
?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Angkatan <?= $no_angkatan ?></h5>
        <span class="badge bg-primary"><?= $jml_per ?> Santri</span>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                    <th>Status Sosial</th>
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
                    <td class="fw-bold"><?= $data['nama_lengkap'] ?></td>
                    <td><?= $data['alamat'] ?? '-' ?></td>
                    <td><?= $data['no_telp'] ?? '-' ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $data['status_sosial'] ?? 'Hidup' ?></span></td>
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
<?php } ?>

<?php include '../../layouts/footer.php'; ?>