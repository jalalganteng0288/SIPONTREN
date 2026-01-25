<?php
include '../../config/database.php';
$id = $_GET['id'];
$update = mysqli_query($conn, "UPDATE santri SET status='alumni' WHERE id_santri='$id'");

if($update){
    echo "<script>alert('Santri telah menjadi Alumni!'); window.location='index.php';</script>";
}
?>