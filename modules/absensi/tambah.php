<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $tanggal = $_POST['tanggal'];
    $santri_ids = $_POST['id_santri']; // Array dari checkbox/input
    $statuses = $_POST['status'];      // Array status

    foreach($santri_ids as $key => $id_santri){
        $status = $statuses[$key];
        $ket = mysqli_real_escape_string($conn, $_POST['keterangan'][$key]);
        
        $query = "INSERT INTO absensi (id_santri, tanggal, status, keterangan) 
                  VALUES ('$id_santri', '$tanggal', '$status', '$ket')";
        mysqli_query($conn, $query);
    }
    echo "<script>alert('Absensi Berhasil Disimpan!'); window.location='index.php';</script>";
}
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-calendar-check me-2 text-primary"></i>Input Absensi Santri</h5>
    <form action="" method="POST">
        <div class="mb-4" style="max-width: 250px;">
            <label class="form-label small fw-bold">Tanggal Absensi</label>
            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Santri</th>
                        <th>Status Kehadiran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT id_santri, nama_lengkap FROM santri WHERE status='aktif'");
                    while($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td>
                            <input type="hidden" name="id_santri[]" value="<?= $row['id_santri'] ?>">
                            <span class="fw-bold"><?= $row['nama_lengkap'] ?></span>
                        </td>
                        <td>
                            <select name="status[]" class="form-select form-select-sm">
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                            </select>
                        </td>
                        <td><input type="text" name="keterangan[]" class="form-control form-control-sm" placeholder="Catatan..."></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <hr>
        <button type="submit" name="submit" class="btn btn-primary px-4">Simpan Absensi</button>
        <a href="index.php" class="btn btn-light">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>