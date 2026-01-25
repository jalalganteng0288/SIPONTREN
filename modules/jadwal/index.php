<?php
include '../../config/database.php';
include '../../layouts/header.php';

if (isset($_POST['simpan_jadwal'])) {
    $guru = $_POST['id_guru'];
    $kitab = $_POST['id_kitab'];
    $hari = $_POST['hari'];
    $mulai = $_POST['jam_mulai'];
    $selesai = $_POST['jam_selesai'];
    $kelas = $_POST['kelas'];

    mysqli_query($conn, "INSERT INTO jadwal_mengajar (id_guru, id_kitab, hari, jam_mulai, jam_selesai, kelas) 
                        VALUES ('$guru', '$kitab', '$hari', '$mulai', '$selesai', '$kelas')");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-dark">Jadwal Pelajaran</h2>
    <button class="btn btn-dark px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus me-2"></i>Tambah Jadwal
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-secondary">
                <tr>
                    <th class="ps-4">Hari</th>
                    <th>Jam</th>
                    <th>Kitab</th>
                    <th>Guru</th>
                    <th>Kelas</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT jadwal_mengajar.*, guru.nama_guru, master_kitab.nama_kitab 
                                         FROM jadwal_mengajar 
                                         JOIN guru ON jadwal_mengajar.id_guru = guru.id_guru 
                                         JOIN master_kitab ON jadwal_mengajar.id_kitab = master_kitab.id_kitab 
                                         ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), jam_mulai ASC");
                while ($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?= $row['hari'] ?></td>
                        <td><span class="badge bg-light text-dark"><?= substr($row['jam_mulai'], 0, 5) ?> - <?= substr($row['jam_selesai'], 0, 5) ?></span></td>
                        <td class="text-primary fw-bold"><?= $row['nama_kitab'] ?></td>
                        <td><?= $row['nama_guru'] ?></td>
                        <td><span class="badge bg-info-subtle text-info px-3"><?= $row['kelas'] ?></span></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="edit.php?id=<?= $row['id_jadwal'] ?>" class="btn btn-link text-primary p-0 me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id_jadwal'] ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="fw-bold">Buat Jadwal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small fw-bold">Pilih Guru</label>
                        <select name="id_guru" class="form-select" required>
                            <?php $g = mysqli_query($conn, "SELECT * FROM guru");
                            while ($rg = mysqli_fetch_assoc($g)) echo "<option value='{$rg['id_guru']}'>{$rg['nama_guru']}</option>"; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Pilih Kitab</label>
                        <select name="id_kitab" class="form-select" required>
                            <?php $k = mysqli_query($conn, "SELECT * FROM master_kitab");
                            while ($rk = mysqli_fetch_assoc($k)) echo "<option value='{$rk['id_kitab']}'>{$rk['nama_kitab']}</option>"; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Hari</label>
                            <select name="hari" class="form-select">
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>
                                <option>Minggu</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Kelas</label>
                            <select name="kelas" class="form-select">
                                <option>Kelas 1</option>
                                <option>Kelas 2</option>
                                <option>Kelas 3</option>
                                <option>Kelas 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"><label class="small fw-bold">Jam Mulai</label><input type="time" name="jam_mulai" class="form-control" required></div>
                        <div class="col-6"><label class="small fw-bold">Jam Selesai</label><input type="time" name="jam_selesai" class="form-control" required></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="simpan_jadwal" class="btn btn-primary w-100">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>