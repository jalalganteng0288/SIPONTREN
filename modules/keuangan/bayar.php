<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $id_santri = $_POST['id_santri'];
    $jumlah = $_POST['jumlah'];
    $ket = $_POST['keterangan'];

    $insert = mysqli_query($conn, "INSERT INTO keuangan (id_santri, jumlah_bayar, keterangan) VALUES ('$id_santri', '$jumlah', '$ket')");
    
    if($insert){
        echo "<script>alert('Pembayaran Berhasil!'); window.location='index.php';</script>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Input Pembayaran Syahriah</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Pilih Santri</label>
                        <select name="id_santri" class="form-select" required>
                            <option value="">-- Pilih Santri --</option>
                            <?php
                            $s = mysqli_query($conn, "SELECT id_santri, nama_lengkap FROM santri WHERE status='aktif'");
                            while($d = mysqli_fetch_assoc($s)){
                                echo "<option value='{$d['id_santri']}'>{$d['nama_lengkap']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 200000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" placeholder="Contoh: Bayar SPP Bulan Januari 2026"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>