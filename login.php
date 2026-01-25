<?php
session_start();
include 'config/database.php';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Untuk sementara kita pakai user manual, nanti bisa buat tabel 'users'
    if($username == "admin" && $password == "admin123"){
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - SiPontren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #2c3e50; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { width: 400px; border-radius: 15px; }
    </style>
</head>
<body>
    <div class="card shadow p-4">
        <div class="text-center mb-4">
            <h4><i class="fas fa-mosque me-2"></i>SiPontren</h4>
            <small class="text-muted">Silakan masuk ke sistem</small>
        </div>
        <?php if(isset($error)) : ?>
            <div class="alert alert-danger">Username atau Password salah!</div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>