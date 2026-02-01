<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 

// Ambil ID dari URL
$id = $_GET['id'];
$query_data = mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'");
$data = mysqli_fetch_assoc($query_data);

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk = $_POST['jk'];
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status_sosial = $_POST['status_sosial'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $angkatan = $_POST['angkatan'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // KUNCI PERBAIKAN: Pastikan status tetap 'alumni' agar tidak pindah ke santri aktif
    $query = "UPDATE santri SET 
                nama_lengkap='$nama', 
                jenis_kelamin='$jk', 
                no_telp='$telp', 
                alamat='$alamat', 
                tahun_masuk='$masuk', 
                angkatan='$angkatan', 
                status_sosial='$sosial',
                status='alumni' 
              WHERE id_santri='$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Alumni berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="card p-4 shadow-sm border-0">
    <h4 class="mb-4 fw-bold"><i class="fas fa-edit me-2 text-warning"></i> Edit Data Alumni</h4>
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
                <label class="form-label fw-bold small">No. HP/WA</label>
                <input type="text" name="no_telp" class="form-control" value="<?= $data['no_telp'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="form-control" value="<?= $data['tahun_masuk'] ?>">
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
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Jenis Kelamin</label>
                <select name="jk" class="form-select">
                    <option value="L" <?= $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold small">Alamat Terakhir</label>
                <textarea name="alamat" class="form-control" rows="2"><?= $data['alamat'] ?></textarea>
            </div>
        </div>
        <hr>
        <button type="submit" name="update" class="btn btn-primary px-4">Update Alumni</button>
        <a href="index.php" class="btn btn-light">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>