<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM santri WHERE id_santri='$id'"));

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $telp = $_POST['no_telp'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    // Logika Update Foto (Opsional)
    if($_FILES['foto_pribadi']['name'] != ""){
        $foto_pribadi = time()."_".$_FILES["foto_pribadi"]["name"];
        move_uploaded_file($_FILES["foto_pribadi"]["tmp_name"], "../../assets/uploads/santri/" . $foto_pribadi);
        $sql_foto = ", foto_pribadi='$foto_pribadi'";
    } else { $sql_foto = ""; }

    $update = mysqli_query($conn, "UPDATE santri SET 
              nama_lengkap='$nama', no_telp='$telp', alamat='$alamat' $sql_foto 
              WHERE id_santri='$id'");
    
    if($update){
        echo "<script>alert('Data Pendaftar Diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>Edit Pendaftar Baru</h5>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label fw-bold small">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="<?= $s['nama_lengkap'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold small">No. HP/WA</label>
            <input type="text" name="no_telp" class="form-control" value="<?= $s['no_telp'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold small">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2"><?= $s['alamat'] ?></textarea>
        </div>
        <div class="mb-4">
            <label class="form-label fw-bold small">Ganti Foto (Kosongkan jika tidak diubah)</label>
            <input type="file" name="foto_pribadi" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-warning px-4 text-dark shadow-sm">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-light px-4">Batal</a>
    </form>
</div>