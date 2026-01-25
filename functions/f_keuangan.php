<?php
function totalKas($conn) {
    $query = mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total FROM keuangan");
    $data = mysqli_fetch_assoc($query);
    return $data['total'] ?? 0;
}
?>