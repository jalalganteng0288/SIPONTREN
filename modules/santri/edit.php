<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$query_data = mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'");
$s = mysqli_fetch_assoc($query_data);

if(isset($_POST['update'])){
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk     = $_POST['jk'];
    $tmpt   = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tgl    = $_POST['tanggal_lahir'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $ayah   = mysqli_real_escape_string($conn, $_POST['nama_ayah']);
    $ibu    = mysqli_real_escape_string($conn, $_POST['nama_ibu']);
    $telp   = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $tahun  = $_POST['tahun_masuk'];
    $status = $_POST['status'];

    $sql_update = "UPDATE santri SET 
                   nama_lengkap='$nama', 
                   jenis_kelamin='$jk',
                   tempat_lahir='$tmpt', 
                   tanggal_lahir='$tgl', 
                   alamat='$alamat',
                   nama_ayah='$ayah', 
                   nama_ibu='$ibu', 
                   no_telp='$telp', 
                   tahun_masuk='$tahun',
                   status='$status' 
                   WHERE id_santri='$id'";
    
    if(mysqli_query($conn, $sql_update)){
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-user-edit me-2 text-warning"></i>Edit Data Santri</h5>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= $s['nama_lengkap'] ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold small">Jenis Kelamin</label>
                <select name="jk" class="form-select" required>
                    <option value="L" <?= $s['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $s['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold small">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="form-control" value="<?= $s['tahun_masuk'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="<?= $s['tempat_lahir'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= $s['tanggal_lahir'] ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">Nama Ayah</label>
                <input type="text" name="nama_ayah" class="form-control" value="<?= $s['nama_ayah'] ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">Nama Ibu</label>
                <input type="text" name="nama_ibu" class="form-control" value="<?= $s['nama_ibu'] ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">No. Telepon / WA</label>
                <input type="text" name="no_telp" class="form-control" value="<?= $s['no_telp'] ?>">
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label fw-bold small">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="2"><?= $s['alamat'] ?></textarea>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">Status Santri</label>
                <select name="status" class="form-select" required>
                    <option value="aktif" <?= $s['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="lulus" <?= $s['status'] == 'lulus' ? 'selected' : '' ?>>Alumni / Lulus</option>
                    <option value="keluar" <?= $s['status'] == 'keluar' ? 'selected' : '' ?>>Keluar</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
            <a href="index.php" class="btn btn-light me-2">Batal</a>
            <button type="submit" name="update" class="btn btn-warning px-4 text-dark">Update Data</button>
        </div>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>