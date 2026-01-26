<?php
include '../../config/database.php';
$id = $_GET['id'];

// Ubah status menjadi 'aktif' dan set tahun masuk otomatis
$tahun_sekarang = date('Y');
$query = "UPDATE santri SET status='aktif', tahun_masuk='$tahun_sekarang' WHERE id_santri='$id'";

if(mysqli_query($conn, $query)){
    echo "<script>alert('Santri Berhasil Diaktifkan!'); window.location='../santri/index.php';</script>";
}
?>