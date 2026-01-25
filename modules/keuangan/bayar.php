<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $id_santri = $_POST['id_santri'];
    $syahriah = $_POST['bayar_syahriah'];
    $masak = $_POST['bayar_masak'];
    $beras = $_POST['beras_5kg'];
    
    // Hitung total otomatis
    $total = $syahriah + $masak;
    
    // Logika Status Otomatis
    // Anggap Lunas jika Syahriah & Masak diisi (bisa kamu sesuaikan nominalnya)
    $status = ($syahriah > 0 && $masak > 0) ? "Lunas" : "Belum Lunas";
    $ket = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $query = "INSERT INTO keuangan (id_santri, jumlah_bayar, bayar_syahriah, bayar_masak, beras_5kg, status_pembayaran, keterangan) 
              VALUES ('$id_santri', '$total', '$syahriah', '$masak', '$beras', '$status', '$ket')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Pembayaran Berhasil! Status: $status'); window.location='index.php';</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Pembayaran Terpadu</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Pilih Santri</label>
                    <select name="id_santri" class="form-select" required>
                        <?php
                        $s = mysqli_query($conn, "SELECT id_santri, nama_lengkap FROM santri WHERE status='aktif'");
                        while($d = mysqli_fetch_assoc($s)) echo "<option value='{$d['id_santri']}'>{$d['nama_lengkap']}</option>";
                        ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bayar Syahriah (Rp)</label>
                    <input type="number" name="bayar_syahriah" class="form-control" placeholder="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bayar Uang Masak (Rp)</label>
                    <input type="number" name="bayar_masak" class="form-control" placeholder="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Beras 5kg</label>
                    <select name="beras_5kg" class="form-select">
                        <option value="Belum">Belum</option>
                        <option value="Sudah">Sudah</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary px-5">Konfirmasi Pembayaran</button>
        </form>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>