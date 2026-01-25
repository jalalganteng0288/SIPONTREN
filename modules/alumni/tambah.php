<?php 
session_start();
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    // NIS TIDAK DIAMBIL LAGI DARI POST
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk = $_POST['jk'];
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status_sosial = $_POST['status_sosial'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Query tanpa kolom NIS agar tidak duplikat
    $query = "INSERT INTO santri (nama_lengkap, jenis_kelamin, no_telp, alamat, tahun_masuk, status, status_sosial) 
              VALUES ('$nama', '$jk', '$no_telp', '$alamat', '$tahun_masuk', 'alumni', '$status_sosial')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Alumni berhasil disimpan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="card p-4 shadow-sm">
    <h4 class="mb-4"><i class="fas fa-plus me-2"></i> Tambah Alumni Baru</h4>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">No. Telepon / WA</label>
                <input type="text" name="no_telp" class="form-control" placeholder="08xxx">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status (Pernikahan/Kondisi)</label>
                <select name="status_sosial" class="form-select">
                    <option value="Lajang">Lajang</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Hidup">Hidup</option>
                    <option value="Meninggal">Meninggal Dunia</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jk" class="form-select">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="form-control" value="<?= date('Y') ?>">
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Alamat Terakhir</label>
                <textarea name="alamat" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Alumni</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>