<?php
include '../../config/database.php';
$id = $_GET['id'];
$delete = mysqli_query($conn, "DELETE FROM santri WHERE id_santri='$id'");

if($delete){
    echo "<script>alert('Data Santri Telah Dihapus!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data.'); window.location='index.php';</script>";
}
?>