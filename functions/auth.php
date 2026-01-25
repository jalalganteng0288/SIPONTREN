<?php
function cekLogin() {
    if (!isset($_SESSION['login'])) {
        header("Location: ../../login.php");
        exit;
    }
}
?>