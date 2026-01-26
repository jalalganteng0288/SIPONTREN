<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['submit'])){
    $tanggal = $_POST['tanggal'];
    $id_jadwal = $_POST['id_jadwal']; // Mengambil ID Jadwal yang dipilih
    $santri_ids = $_POST['id_santri']; 
    $statuses = $_POST['status'];      

    foreach($santri_ids as $key => $id_santri){
        $status = $statuses[$key];
        $ket = mysqli_real_escape_string($conn, $_POST['keterangan'][$key]);
        
        // Sekarang kita simpan juga id_jadwal agar tahu ini absen pelajaran apa
        $query = "INSERT INTO absensi (id_santri, id_jadwal, tanggal, status, keterangan) 
                  VALUES ('$id_santri', '$id_jadwal', '$tanggal', '$status', '$ket')";
        mysqli_query($conn, $query);
    }
    echo "<script>alert('Absensi Berhasil Disimpan!'); window.location='index.php';</script>";
}
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-calendar-check me-2 text-primary"></i>Input Absensi Per Jadwal</h5>
    <form action="" method="POST">
        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tanggal Absensi</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Pilih Jadwal / Pelajaran</label>
                <select name="id_jadwal" class="form-select" required>
                    <option value="">-- Pilih Jadwal Pelajaran --</option>
                    <?php
                    // Mengambil jadwal lengkap dengan nama guru dan kitab
                    $q_jadwal = mysqli_query($conn, "SELECT j.*, g.nama_guru, k.nama_kitab 
                                                     FROM jadwal_mengajar j
                                                     JOIN guru g ON j.id_guru = g.id_guru
                                                     JOIN master_kitab k ON j.id_kitab = k.id_kitab
                                                     ORDER BY j.hari ASC");
                    while($dj = mysqli_fetch_assoc($q_jadwal)) {
                        echo "<option value='{$dj['id_jadwal']}'>{$dj['hari']} | {$dj['nama_kitab']} ({$dj['nama_guru']}) - {$dj['kelas']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Santri</th>
                        <th>Status Kehadiran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil santri aktif
                    $res = mysqli_query($conn, "SELECT id_santri, nama_lengkap FROM santri WHERE status='aktif' ORDER BY nama_lengkap ASC");
                    while($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td>
                            <input type="hidden" name="id_santri[]" value="<?= $row['id_santri'] ?>">
                            <span class="fw-bold"><?= $row['nama_lengkap'] ?></span>
                        </td>
                        <td>
                            <select name="status[]" class="form-select form-select-sm">
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                            </select>
                        </td>
                        <td><input type="text" name="keterangan[]" class="form-control form-control-sm" placeholder="Catatan..."></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <hr>
        <button type="submit" name="submit" class="btn btn-primary px-4">Simpan Absensi</button>
        <a href="index.php" class="btn btn-light px-4">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>