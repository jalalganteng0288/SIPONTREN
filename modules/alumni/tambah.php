<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk = $_POST['jk'];
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status_sosial = $_POST['status_sosial'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $angkatan = $_POST['angkatan']; // Tambahan Fitur Angkatan
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "INSERT INTO santri (nama_lengkap, jenis_kelamin, no_telp, alamat, tahun_masuk, angkatan, status, status_sosial) 
              VALUES ('$nama', '$jk', '$no_telp', '$alamat', '$tahun_masuk', '$angkatan', 'alumni', '$status_sosial')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Alumni berhasil disimpan!'); window.location='index.php';</script>";
    }
}
?>

<div class="card p-4 shadow-sm">
    <h4 class="mb-4"><i class="fas fa-plus me-2 text-success"></i> Tambah Alumni Baru</h4>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-primary">Angkatan Ke- (1, 2, 3...)</label>
                <input type="number" name="angkatan" class="form-control" placeholder="Contoh: 1" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">No. HP/WA</label>
                <input type="text" name="no_telp" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="form-control" value="<?= date('Y') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-danger">Status Sosial</label>
                <select name="status_sosial" class="form-select">
                    <option value="Lajang">Lajang</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Hidup">Hidup</option>
                    <option value="Meninggal">Meninggal Dunia</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Jenis Kelamin</label>
                <select name="jk" class="form-select">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Alamat Terakhir</label>
                <textarea name="alamat" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <hr>
        <button type="submit" name="submit" class="btn btn-success px-4">Simpan Alumni</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>