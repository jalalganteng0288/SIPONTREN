<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPontren - Sistem Informasi Pondok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #2c3e50; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.1); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block sidebar p-3">
            <h4 class="text-center mb-4"><i class="fas fa-mosque me-2"></i>SiPontren</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="../../index.php" class="nav-link"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a href="../santri/index.php" class="nav-link"><i class="fas fa-users me-2"></i> Data Santri</a></li>
                <li class="nav-item"><a href="../keuangan/index.php" class="nav-link"><i class="fas fa-wallet me-2"></i> Keuangan</a></li>
                <li class="nav-item"><a href="../absensi/index.php" class="nav-link"><i class="fas fa-check-double me-2"></i> Absensi</a></li>
            </ul>
        </div>
        <div class="col-md-10 p-4">