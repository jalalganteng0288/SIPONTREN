<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengeluaran WHERE id_pengeluaran = '$id'"));

if(isset($_POST['update'])){
    $tgl = $_POST['tgl_pengeluaran'];
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis_pengeluaran']);
    $jumlah = $_POST['jumlah_pengeluaran'];

    $query = "UPDATE pengeluaran SET 
              tgl_pengeluaran = '$tgl', 
              jenis_pengeluaran = '$jenis', 
              jumlah_pengeluaran = '$jumlah' 
              WHERE id_pengeluaran = '$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Pengeluaran Berhasil Diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card shadow-sm border-0 p-4" style="max-width: 500px;">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>Koreksi Pengeluaran</h5>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold">Tanggal</label>
            <input type="date" name="tgl_pengeluaran" class="form-control" value="<?= $data['tgl_pengeluaran'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Jenis Pengeluaran</label>
            <input type="text" name="jenis_pengeluaran" class="form-control" value="<?= $data['jenis_pengeluaran'] ?>" required>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold">Jumlah (Rp)</label>
            <input type="number" name="jumlah_pengeluaran" class="form-control" value="<?= $data['jumlah_pengeluaran'] ?>" required>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <a href="index.php" class="btn btn-light px-4">Batal</a>
            <button type="submit" name="update" class="btn btn-warning px-4 text-dark shadow-sm">Update Data</button>
        </div>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>