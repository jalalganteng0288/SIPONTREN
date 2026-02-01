<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'"));

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $angkatan = $_POST['angkatan'];
    $status_sosial = $_POST['status_sosial'];

    // KUNCI: Status dipaksa tetap 'alumni'
    $query = "UPDATE santri SET 
                nama_lengkap='$nama', 
                no_telp='$no_telp', 
                alamat='$alamat', 
                angkatan='$angkatan', 
                status_sosial='$status_sosial',
                status='alumni' 
              WHERE id_santri='$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Alumni berhasil diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card p-4 shadow-sm border-0">
    <h4 class="mb-4 fw-bold"><i class="fas fa-edit me-2 text-warning"></i> Edit Alumni Angkatan <?= $data['angkatan'] ?></h4>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= $data['nama_lengkap'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small text-primary">Angkatan Ke-</label>
                <input type="number" name="angkatan" class="form-control" value="<?= $data['angkatan'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">No. WhatsApp</label>
                <input type="text" name="no_telp" class="form-control" value="<?= $data['no_telp'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Status Sosial</label>
                <select name="status_sosial" class="form-select">
                    <option value="Lajang" <?= $data['status_sosial'] == 'Lajang' ? 'selected' : '' ?>>Lajang</option>
                    <option value="Menikah" <?= $data['status_sosial'] == 'Menikah' ? 'selected' : '' ?>>Menikah</option>
                    <option value="Hidup" <?= $data['status_sosial'] == 'Hidup' ? 'selected' : '' ?>>Hidup</option>
                    <option value="Meninggal" <?= $data['status_sosial'] == 'Meninggal' ? 'selected' : '' ?>>Meninggal Dunia</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold small">Alamat Terakhir</label>
                <textarea name="alamat" class="form-control" rows="2"><?= $data['alamat'] ?></textarea>
            </div>
        </div>
        <hr>
        <button type="submit" name="update" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-light px-4">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>