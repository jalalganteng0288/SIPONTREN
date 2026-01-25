<?php
session_start();
// Hapus semua variabel session
$_SESSION = [];
// Hancurkan session
session_destroy();

// Redirect ke halaman login
echo "<script>
        alert('Anda telah berhasil keluar.');
        window.location='login.php';
      </script>";
exit;
?>