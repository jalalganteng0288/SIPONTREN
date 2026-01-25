<?php
function hitungTotalUang($conn) {
    $q = mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total FROM keuangan");
    $d = mysqli_fetch_assoc($q);
    return $d['total'] ?? 0;
}
?>