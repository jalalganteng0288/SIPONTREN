<?php
include '../../config/database.php';

$id = $_GET['id'];
$query = "DELETE FROM pengeluaran WHERE id_pengeluaran = '$id'";

if(mysqli_query($conn, $query)){
    echo "<script>alert('Pengeluaran telah dihapus!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data.'); window.location='index.php';</script>";
}
?>