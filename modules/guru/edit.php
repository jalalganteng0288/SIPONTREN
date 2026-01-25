<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM guru WHERE id_guru = '$id'"));

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_guru']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bidang = mysqli_real_escape_string($conn, $_POST['bidang_mengajar']);
    $telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status = $_POST['status_guru'];

    $query = "UPDATE guru SET 
              nama_guru = '$nama', 
              email = '$email', 
              bidang_mengajar = '$bidang', 
              no_telp = '$telp',
              status_guru = '$status' 
              WHERE id_guru = '$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Guru Berhasil Diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>Edit Data Guru</h5>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Nama Lengkap Guru</label>
                <input type="text" name="nama_guru" class="form-control" value="<?= $data['nama_guru'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Bidang Mengajar / Kitab</label>
                <input type="text" name="bidang_mengajar" class="form-control" value="<?= $data['bidang_mengajar'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Status</label>
                <select name="status_guru" class="form-select">
                    <option value="Aktif" <?= $data['status_guru'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Non-Aktif" <?= $data['status_guru'] == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold small">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="<?= $data['no_telp'] ?>">
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
            <a href="index.php" class="btn btn-light me-2">Batal</a>
            <button type="submit" name="update" class="btn btn-warning px-4">Update Data</button>
        </div>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>