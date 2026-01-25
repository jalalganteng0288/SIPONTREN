<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM jadwal_mengajar WHERE id_jadwal = '$id'"));

if(isset($_POST['update'])){
    $guru = $_POST['id_guru'];
    $kitab = $_POST['id_kitab'];
    $hari = $_POST['hari'];
    $mulai = $_POST['jam_mulai'];
    $selesai = $_POST['jam_selesai'];
    $kelas = $_POST['kelas'];

    $query = "UPDATE jadwal_mengajar SET 
              id_guru='$guru', id_kitab='$kitab', hari='$hari', 
              jam_mulai='$mulai', jam_selesai='$selesai', kelas='$kelas' 
              WHERE id_jadwal='$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Jadwal Berhasil Diperbarui!'); window.location='index.php';</script>";
    }
}
?>

<div class="card shadow-sm border-0 p-4">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-primary"></i>Edit Jadwal Pembelajaran</h5>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Pilih Guru</label>
                <select name="id_guru" class="form-select">
                    <?php 
                    $g = mysqli_query($conn, "SELECT * FROM guru"); 
                    while($rg=mysqli_fetch_assoc($g)){
                        $sel = ($rg['id_guru'] == $data['id_guru']) ? 'selected' : '';
                        echo "<option value='{$rg['id_guru']}' $sel>{$rg['nama_guru']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Pilih Kitab</label>
                <select name="id_kitab" class="form-select">
                    <?php 
                    $k = mysqli_query($conn, "SELECT * FROM master_kitab"); 
                    while($rk=mysqli_fetch_assoc($k)){
                        $sel = ($rk['id_kitab'] == $data['id_kitab']) ? 'selected' : '';
                        echo "<option value='{$rk['id_kitab']}' $sel>{$rk['nama_kitab']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Hari</label>
                <select name="hari" class="form-select">
                    <?php 
                    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    foreach($hari_list as $h){
                        $sel = ($h == $data['hari']) ? 'selected' : '';
                        echo "<option value='$h' $sel>$h</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Kelas</label>
                <select name="kelas" class="form-select">
                    <?php 
                    for($i=1; $i<=4; $i++){
                        $kls = "Kelas $i";
                        $sel = ($kls == $data['kelas']) ? 'selected' : '';
                        echo "<option value='$kls' $sel>$kls</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" value="<?= $data['jam_mulai'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" value="<?= $data['jam_selesai'] ?>">
            </div>
        </div>
        <hr>
        <button type="submit" name="update" class="btn btn-primary px-4">Update Jadwal</button>
        <a href="index.php" class="btn btn-light px-4">Batal</a>
    </form>
</div>

<?php include '../../layouts/footer.php'; ?>