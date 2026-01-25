<?php
function getSantriAktif($conn) {
    return mysqli_query($conn, "SELECT * FROM santri WHERE status='aktif' ORDER BY nama_lengkap ASC");
}

function hapusSantri($conn, $id) {
    return mysqli_query($conn, "DELETE FROM santri WHERE id_santri = '$id'");
}
?>