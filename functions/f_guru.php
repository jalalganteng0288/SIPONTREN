<?php
function getSemuaGuru($conn) {
    return mysqli_query($conn, "SELECT * FROM guru ORDER BY nama_guru ASC");
}
?>