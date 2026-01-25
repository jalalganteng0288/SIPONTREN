<?php
include '../../config/database.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Perintah hapus berdasarkan id_jadwal
    $query = "DELETE FROM jadwal_mengajar WHERE id_jadwal = '$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>
                alert('Jadwal berhasil dihapus!'); 
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