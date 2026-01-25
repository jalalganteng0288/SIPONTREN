<?php 
include '../../config/database.php';
include '../../layouts/header.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM keuangan WHERE id_bayar = '$id'"));

if(isset($_POST['update'])){
    $syahriah = $_POST['bayar_syahriah'];
    $masak = $_POST['bayar_masak'];
    $beras = $_POST['beras_5kg'];
    $total = $syahriah + $masak;
    
    // Status otomatis: Lunas jika syahriah & masak sudah diisi
    $status = ($syahriah > 0 && $masak > 0) ? "Lunas" : "Belum Lunas";
    $ket = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "UPDATE keuangan SET 
            bayar_syahriah = '$syahriah', 
            bayar_masak = '$masak', 
            jumlah_bayar = '$total', 
            beras_5kg = '$beras',
            status_pembayaran = '$status',
            keterangan = '$ket' 
            WHERE id_bayar = '$id'";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Data Pembayaran Berhasil Diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card p-4 shadow-sm border-0">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2"></i>Koreksi Data Pembayaran</h5>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nominal Syahriah (Rp)</label>
                <input type="number" name="bayar_syahriah" class="form-control" value="<?= $data['bayar_syahriah'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nominal Uang Masak (Rp)</label>
                <input type="number" name="bayar_masak" class="form-control" value="<?= $data['bayar_masak'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status Beras 5kg</label>
                <select name="beras_5kg" class="form-select">
                    <option value="Belum" <?= $data['beras_5kg'] == 'Belum' ? 'selected' : '' ?>>Belum</option>
                    <option value="Sudah" <?= $data['beras_5kg'] == 'Sudah' ? 'selected' : '' ?>>Sudah</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Keterangan / Catatan</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= $data['keterangan'] ?></textarea>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
            <a href="index.php" class="btn btn-light me-2">Batal</a>
            <button type="submit" name="update" class="btn btn-primary px-4">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?php include '../../layouts/footer.php'; ?>