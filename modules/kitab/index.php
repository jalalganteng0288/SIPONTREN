<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 

if(isset($_POST['simpan_kitab'])){
    $nama = $_POST['nama_kitab'];
    mysqli_query($conn, "INSERT INTO master_kitab (nama_kitab) VALUES ('$nama')");
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3">
            <h5 class="fw-bold">Tambah Kitab</h5>
            <form method="POST">
                <input type="text" name="nama_kitab" class="form-control mb-3" placeholder="Nama Kitab/Pelajaran" required>
                <button type="submit" name="simpan_kitab" class="btn btn-primary w-100">Simpan Kitab</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0 p-3">
            <h5 class="fw-bold">Daftar Kitab</h5>
            <table class="table">
                <thead><tr><th>No</th><th>Nama Kitab</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php 
                    $no=1;
                    $q = mysqli_query($conn, "SELECT * FROM master_kitab");
                    while($r = mysqli_fetch_assoc($q)){
                        echo "<tr><td>$no</td><td>{$r['nama_kitab']}</td><td><a href='hapus.php?id={$r['id_kitab']}' class='text-danger'><i class='fas fa-trash'></i></a></td></tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>