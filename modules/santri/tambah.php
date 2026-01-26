<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk = $_POST['jk'];
    $tmpt = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tgl = $_POST['tanggal_lahir'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $ayah = mysqli_real_escape_string($conn, $_POST['nama_ayah']);
    $ibu = mysqli_real_escape_string($conn, $_POST['nama_ibu']);
    $telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $tahun = $_POST['tahun_masuk'];

    // Query perbaikan: pastikan kolom-kolom ini sudah ada di database
    $query = "INSERT INTO santri (nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, nama_ayah, nama_ibu, no_telp, tahun_masuk, status) 
              VALUES ('$nama', '$jk', '$tmpt', '$tgl', '$alamat', '$ayah', '$ibu', '$telp', '$tahun', 'aktif')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Santri Berhasil Disimpan!'); window.location='index.php';</script>";
    } else {
        // Tampilkan error database jika gagal agar mudah dilacak
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-user-plus me-2 text-primary"></i>Tambah Santri Baru</h5>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold small">Jenis Kelamin</label>
                <select name="jk" class="form-select" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold small">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="form-control" value="<?= date('Y') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">Nama Ayah</label>
                <input type="text" name="nama_ayah" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">Nama Ibu</label>
                <input type="text" name="nama_ibu" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold small">No. Telepon / WA</label>
                <input type="text" name="no_telp" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold small">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
            <a href="index.php" class="btn btn-light me-2">Batal</a>
            <button type="submit" name="submit" class="btn btn-primary px-4">Simpan Santri</button>
        </div>
    </form>
</div>
<?php include '../../layouts/footer.php'; ?>