<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    // Membersihkan input untuk keamanan dari SQL Injection
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun_masuk']);

    // Query untuk menyimpan data
    $query = "INSERT INTO santri (nis, nama_lengkap, jenis_kelamin, alamat, tahun_masuk, status) 
              VALUES ('$nis', '$nama', '$jk', '$alamat', '$tahun', 'aktif')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>
                alert('Data Santri Berhasil Disimpan!'); 
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data: " . mysqli_error($conn) . "');
              </script>";
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus me-2"></i>Tambah Santri Baru</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor Induk Santri (NIS)</label>
                            <input type="text" name="nis" class="form-control" required placeholder="Contoh: 2024001">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <select name="jk" class="form-select" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" class="form-control" value="<?= date('Y') ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap domisili"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <a href="index.php" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" name="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>