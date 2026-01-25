<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $nis = $_POST['nis'];
    $nama = $_POST['nama_lengkap'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $tahun = $_POST['tahun_masuk'];

    $query = "INSERT INTO santri (nis, nama_lengkap, jenis_kelamin, alamat, tahun_masuk) 
              VALUES ('$nis', '$nama', '$jk', '$alamat', '$tahun')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='index.php';</script>";
    }
}
?>

<div class="card p-4 shadow-sm">
    <h4 class="mb-4">Tambah Data Santri Baru</h4>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" required placeholder="Contoh: 2024001">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
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
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>