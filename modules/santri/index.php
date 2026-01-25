<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-user-graduate me-2"></i> Data Santri Aktif</h3>
    <a href="tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Santri</a>
</div>

<div class="card p-3">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='aktif'");
            while($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>{$row['nis']}</td>
                    <td>{$row['nama_lengkap']}</td>
                    <td>{$row['alamat']}</td>
                    <td><span class='badge bg-success'>{$row['status']}</span></td>
                    <td>
                        <a href='edit.php?id={$row['id_santri']}' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                        <a href='hapus.php?id={$row['id_santri']}' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../../layouts/footer.php'; ?>