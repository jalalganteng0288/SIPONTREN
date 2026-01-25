<?php
include '../../config/database.php';

// Ambil ID dari URL
$id = $_GET['id'];

if (isset($id)) {
    // Query hapus data berdasarkan id_bayar
    $query = "DELETE FROM keuangan WHERE id_bayar = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data pembayaran berhasil dihapus!'); 
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($conn) . "'); 
                window.location='index.php';
              </script>";
    }
} else {
    header("Location: index.php");
}
?>