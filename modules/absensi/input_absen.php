<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['simpan_absen'])){
    $tgl = $_POST['tgl_absen'];
    $statuses = $_POST['status']; // Ini berupa array

    foreach($statuses as $id_santri => $status) {
        // Cek apakah hari ini santri tersebut sudah absen (biar tidak double)
        $cek = mysqli_query($conn, "SELECT id_absen FROM absensi WHERE id_santri='$id_santri' AND tgl_absen='$tgl'");
        if(mysqli_num_rows($cek) > 0) {
            mysqli_query($conn, "UPDATE absensi SET status_absen='$status' WHERE id_santri='$id_santri' AND tgl_absen='$tgl'");
        } else {
            mysqli_query($conn, "INSERT INTO absensi (id_santri, tgl_absen, status_absen) VALUES ('$id_santri', '$tgl', '$status')");
        }
    }
    echo "<script>alert('Absensi berhasil disimpan!'); window.location='index.php';</script>";
}
?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Input Presensi Santri - Tanggal <?= date('d F Y') ?></h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <input type="hidden" name="tgl_absen" value="<?= date('Y-m-d') ?>">
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nama Santri</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Sakit</th>
                            <th class="text-center">Izin</th>
                            <th class="text-center">Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $santri = mysqli_query($conn, "SELECT id_santri, nama_lengkap FROM santri WHERE status='aktif' ORDER BY nama_lengkap ASC");
                        while($s = mysqli_fetch_assoc($santri)){
                        ?>
                        <tr>
                            <td><?= $s['nama_lengkap'] ?></td>
                            <td class="text-center"><input type="radio" name="status[<?= $s['id_santri'] ?>]" value="hadir" checked></td>
                            <td class="text-center"><input type="radio" name="status[<?= $s['id_santri'] ?>]" value="sakit"></td>
                            <td class="text-center"><input type="radio" name="status[<?= $s['id_santri'] ?>]" value="izin"></td>
                            <td class="text-center"><input type="radio" name="status[<?= $s['id_santri'] ?>]" value="alpha"></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <button type="submit" name="simpan_absen" class="btn btn-success px-5">Simpan Semua</button>
                <a href="index.php" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>