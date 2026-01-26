<?php
include '../../config/database.php';
include '../../layouts/header.php';

if (isset($_POST['simpan'])) {
    $tgl = $_POST['tgl_pengeluaran'];
    $jenis = $_POST['jenis_pengeluaran'];
    $jumlah = $_POST['jumlah_pengeluaran'];
    mysqli_query($conn, "INSERT INTO pengeluaran (tgl_pengeluaran, jenis_pengeluaran, jumlah_pengeluaran) VALUES ('$tgl', '$jenis', '$jumlah')");
    echo "<script>window.location='index.php';</script>";
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3 shadow-sm border-0">
            <h5 class="fw-bold">Input Pengeluaran</h5>
            <form action="" method="POST">
                <input type="date" name="tgl_pengeluaran" class="form-control mb-2" required>
                <input type="text" name="jenis_pengeluaran" class="form-control mb-2" placeholder="Contoh: Beli Token Listrik" required>
                <input type="number" name="jumlah_pengeluaran" class="form-control mb-3" placeholder="Jumlah (Rp)" required>
                <button type="submit" name="simpan" class="btn btn-danger w-100">Simpan Pengeluaran</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-3 shadow-sm border-0">
            <h5 class="fw-bold"><i class="fas fa-history me-2 text-danger"></i>Riwayat Pengeluaran</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle small">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Pengeluaran</th>
                            <th>Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY tgl_pengeluaran DESC");
                        while ($r = mysqli_fetch_assoc($q)) { ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($r['tgl_pengeluaran'])) ?></td>
                                <td class="fw-bold"><?= $r['jenis_pengeluaran'] ?></td>
                                <td class="text-danger fw-bold">Rp <?= number_format($r['jumlah_pengeluaran'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="edit.php?id=<?= $r['id_pengeluaran'] ?>" class="btn btn-white btn-sm text-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="hapus.php?id=<?= $r['id_pengeluaran'] ?>" class="btn btn-white btn-sm text-danger" onclick="return confirm('Hapus riwayat pengeluaran ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>