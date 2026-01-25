<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $nama = $_POST['nama_guru'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_hp = $_POST['no_hp'];

    $query = "INSERT INTO guru (nama_guru, spesialisasi, no_hp) VALUES ('$nama', '$spesialisasi', '$no_hp')";
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Guru Berhasil Disimpan!'); window.location='index.php';</script>";
    }
}
?>

<div class="card p-4 shadow-sm">
    <h4 class="mb-4">Tambah Data Guru Baru</h4>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_guru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bidang Pengajaran / Spesialisasi</label>
            <input type="text" name="spesialisasi" class="form-control" placeholder="Contoh: Nahwu Shorof">
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor WhatsApp</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Guru</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>