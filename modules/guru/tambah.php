<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_guru']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bidang = mysqli_real_escape_string($conn, $_POST['bidang_mengajar']);
    $telp = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // Query tanpa kolom NIP agar selaras dengan permintaanmu
    $query = "INSERT INTO guru (nama_guru, email, bidang_mengajar, no_telp, status_guru) 
              VALUES ('$nama', '$email', '$bidang', '$telp', 'Aktif')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Guru Berhasil Ditambah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="card shadow-sm border-0 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-user-plus me-2 text-primary"></i>Tambah Guru Baru</h5>
    </div>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Nama Lengkap Guru</label>
                <input type="text" name="nama_guru" class="form-control" placeholder="Contoh: Ustaz Hendra" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Email</label>
                <input type="email" name="email" class="form-control" placeholder="hendra@pesantren.com">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">Bidang Mengajar (Kitab)</label>
                <input type="text" name="bidang_mengajar" class="form-control" placeholder="Contoh: Tajweed / Matematika">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" placeholder="081234567890">
            </div>
        </div>
        <hr class="my-4">
        <div class="d-flex justify-content-end gap-2">
            <a href="index.php" class="btn btn-light px-4">Batal</a>
            <button type="submit" name="submit" class="btn btn-primary px-4 shadow-sm">Simpan Data Guru</button>
        </div>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>