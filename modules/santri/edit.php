<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'");
$s = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk = $_POST['jk'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $status = $_POST['status'];

    $query = "UPDATE santri SET nis='$nis', nama_lengkap='$nama', jenis_kelamin='$jk', alamat='$alamat', status='$status' WHERE id_santri='$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card p-4 shadow-sm">
    <h4 class="mb-4"><i class="fas fa-edit me-2"></i>Edit Data Santri</h4>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" value="<?= $s['nis'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= $s['nama_lengkap'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jk" class="form-select">
                    <option value="L" <?= $s['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $s['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $s['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="alumni" <?= $s['status'] == 'alumni' ? 'selected' : '' ?>>Alumni</option>
                    <option value="keluar" <?= $s['status'] == 'keluar' ? 'selected' : '' ?>>Keluar</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"><?= $s['alamat'] ?></textarea>
            </div>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>