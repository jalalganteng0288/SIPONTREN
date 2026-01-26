<?php
include '../../config/database.php';
include '../../layouts/header.php';

if (isset($_POST['submit'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jk     = $_POST['jk'];
    $tmpt   = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tgl_l  = $_POST['tanggal_lahir'];
    $tgl_m  = $_POST['tanggal_masuk'];
    $ayah   = mysqli_real_escape_string($conn, $_POST['nama_ayah']);
    $ibu    = mysqli_real_escape_string($conn, $_POST['nama_ibu']);
    $telp   = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $biaya  = $_POST['biaya_pendaftaran'];

    // Proses Upload Foto Pribadi
    $foto_pribadi = "";
    if ($_FILES['foto_pribadi']['name'] != "") {
        $target_dir = "../../assets/uploads/santri/";
        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $foto_pribadi = time() . "_" . $_FILES["foto_pribadi"]["name"];
        move_uploaded_file($_FILES["foto_pribadi"]["tmp_name"], $target_dir . $foto_pribadi);
    }

    // Query INSERT dengan status 'baru' agar selaras
    $query = "INSERT INTO santri (nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, tanggal_masuk, nama_ayah, nama_ibu, alamat, no_telp, foto_pribadi, biaya_pendaftaran, status) 
              VALUES ('$nama', '$jk', '$tmpt', '$tgl_l', '$tgl_m', '$ayah', '$ibu', '$alamat', '$telp', '$foto_pribadi', '$biaya', 'baru')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Santri Baru Berhasil Didaftarkan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container py-4" data-aos="fade-up">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-user-plus me-2"></i>Formulir Pendaftaran Santri Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small">Jenis Kelamin</label>
                        <select name="jk" class="form-select">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-primary">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-danger">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">No. HP/WA Wali</label>
                        <input type="text" name="no_telp" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Biaya Pendaftaran (Rp)</label>
                        <input type="number" name="biaya_pendaftaran" class="form-control">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold small">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold small">Foto Pribadi (untuk KTS)</label>
                        <input type="file" name="foto_pribadi" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-success"><i class="fas fa-book me-1"></i> Biaya Kitab (Rp)</label>
                        <input type="number" name="biaya_kitab" class="form-control" placeholder="Contoh: 250000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Status Pembayaran Kitab</label>
                        <select name="status_kitab" class="form-select">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="index.php" class="btn btn-light px-4">Batal</a>
                    <button type="submit" name="submit" class="btn btn-primary px-5 shadow-sm">Simpan Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include '../../layouts/footer.php'; ?>