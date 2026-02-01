<?php
session_start();
include '../../config/database.php';
include '../../layouts/header.php';

// REKAPAN: Menghitung total alumni secara keseluruhan
$q_total = mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='alumni'");
$total_alumni = mysqli_num_rows($q_total);
?>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<style>
    .card-angkatan {
        transition: transform 0.3s;
    }

    .card-angkatan:hover {
        transform: translateY(-5px);
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div>
            <h3 class="fw-bold"><i class="fas fa-user-graduate me-2 text-success"></i> Data Alumni</h3>
            <p class="text-muted">Total Keseluruhan: <span class="badge bg-success rounded-pill"><?= $total_alumni ?> Alumni</span></p>
        </div>
        <div class="d-flex gap-2">
            <input type="text" id="cariAlumni" class="form-control shadow-sm" placeholder="Cari nama alumni..." style="width: 250px;">
            <a href="tambah.php" class="btn btn-success shadow-sm px-4"><i class="fas fa-plus me-2"></i>Tambah Alumni</a>
        </div>
    </div>

    <?php
    // Mengambil daftar angkatan secara unik
    $sql_angkatan = mysqli_query($conn, "SELECT DISTINCT angkatan FROM santri WHERE status='alumni' AND angkatan IS NOT NULL ORDER BY angkatan ASC");

    if (mysqli_num_rows($sql_angkatan) == 0) {
        echo "<div class='alert alert-info text-center shadow-sm'>Belum ada data alumni. Silakan tambah data baru.</div>";
    }

    $delay = 100; // Untuk jeda animasi tiap kartu
    while ($row_angkatan = mysqli_fetch_assoc($sql_angkatan)) {
        $no_angkatan = $row_angkatan['angkatan'];
        $jml_per = mysqli_num_rows(mysqli_query($conn, "SELECT id_santri FROM santri WHERE status='alumni' AND angkatan='$no_angkatan'"));
    ?>

        <div class="card shadow-sm border-0 mb-5 card-angkatan" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-folder-open me-2 text-warning"></i> Angkatan <?= $no_angkatan ?></h5>
                <div class="d-flex gap-2 align-items-center">
                    <a href="generate_undangan.php?angkatan=<?= $no_angkatan ?>" class="btn btn-outline-light btn-sm shadow-sm">
                        <i class="fas fa-file-word me-1"></i> Download Undangan (Word)
                    </a> <span class="badge bg-primary px-3 py-2 rounded-pill"><?= $jml_per ?> Alumni</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tabel-<?= $no_angkatan ?>">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Lengkap</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Status Sosial</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM santri WHERE status='alumni' AND angkatan='$no_angkatan' ORDER BY nama_lengkap ASC");
                            while ($data = mysqli_fetch_assoc($query)) {
                                $badge_color = ($data['status_sosial'] == 'Meninggal') ? 'bg-danger' : 'bg-info';
                            ?>
                                <tr class="row-alumni">
                                    <td class="fw-bold ps-4 text-primary"><?= $data['nama_lengkap'] ?></td>
                                    <td class="small"><?= $data['alamat'] ?? '-' ?></td>
                                    <td>
                                        <a href="https://wa.me/<?= $data['no_telp'] ?>" target="_blank" class="text-decoration-none text-dark">
                                            <i class="fab fa-whatsapp text-success me-1"></i> <?= $data['no_telp'] ?? '-' ?>
                                        </a>
                                    </td>
                                    <td><span class="badge <?= $badge_color ?> shadow-sm"><?= $data['status_sosial'] ?? 'Hidup' ?></span></td>
                                    <td class="text-center pe-4">
                                        <a href="edit.php?id=<?= $data['id_santri'] ?>" class="btn btn-warning btn-sm shadow-sm" title="Edit">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
                                        <a href="hapus.php?id=<?= $data['id_santri'] ?>" class="btn btn-danger btn-sm shadow-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data alumni ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
        $delay += 100; // Tambah delay untuk kartu berikutnya
    }
    ?>
</div>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 700,
        once: true
    });

    // Fitur Search Nama
    document.getElementById('cariAlumni').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.row-alumni');

        rows.forEach(row => {
            let nama = row.querySelector('td:first-child').textContent.toLowerCase();
            if (nama.indexOf(filter) > -1) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

<?php include '../../layouts/footer.php'; ?>