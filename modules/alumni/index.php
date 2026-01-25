<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 
?>

<div class="mb-4">
    <h3><i class="fas fa-user-graduate me-2"></i> Data Alumni</h3>
    <p class="text-muted">Daftar santri yang telah menyelesaikan pendidikan.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Tahun Masuk</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' ORDER BY nama_lengkap ASC");
                if(mysqli_num_rows($query) == 0) echo "<tr><td colspan='4' class='text-center'>Belum ada data alumni.</td></tr>";
                while($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                        <td>{$row['nis']}</td>
                        <td>{$row['nama_lengkap']}</td>
                        <td>{$row['tahun_masuk']}</td>
                        <td><span class='badge bg-secondary'>Alumni</span></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>