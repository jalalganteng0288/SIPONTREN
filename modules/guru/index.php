<?php 
include '../../config/database.php';
include '../../layouts/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-chalkboard-teacher me-2"></i> Data Guru / Ustadz</h3>
    <a href="tambah_guru.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Guru</a>
</div>

<div class="row">
    <?php
    $res = mysqli_query($conn, "SELECT * FROM guru");
    while($g = mysqli_fetch_assoc($res)) {
    ?>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="fas fa-user-tie fa-2x text-primary"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold"><?= $g['nama_guru'] ?></h6>
                    <small class="text-muted"><?= $g['spesialisasi'] ?></small><br>
                    <small class="text-primary"><i class="fas fa-phone-alt me-1"></i> <?= $g['no_hp'] ?></small>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php include '../../layouts/footer.php'; ?>