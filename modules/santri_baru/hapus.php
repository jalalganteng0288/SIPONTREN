<?php
include '../../config/database.php';

// Menangkap 'id' dari parameter URL
$id = $_GET['id'];

if (isset($id)) {
    // Pastikan menggunakan kolom 'id_santri' sesuai struktur tabel
    $query = "DELETE FROM santri WHERE id_santri = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>