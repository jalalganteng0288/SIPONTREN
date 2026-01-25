<?php
// Pastikan base URL sesuai dengan folder htdocs Anda
$base_url = "http://localhost/sipontren/";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Proteksi halaman
if (!isset($_SESSION['login'])) {
    header("Location: " . $base_url . "login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPontren - Modern Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-dark: #1a202c;
            --accent-color: #3182ce;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f7fafc;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--primary-dark);
            transition: all 0.3s;
            z-index: 1000;
            color: white;
        }

        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        /* Content Styles */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }

        #content.active {
            width: 100%;
            margin-left: 0;
        }

        .nav-link {
            color: #a0aec0;
            padding: 12px 25px;
            margin: 4px 15px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--accent-color);
            color: white;
        }

        .nav-link i {
            width: 25px;
        }

        /* Navbar Toggle Button */
        .btn-toggle {
            background: #edf2f7;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <nav id="sidebar">
        <div class="p-4 text-center border-bottom border-secondary mb-3">
            <h4 class="fw-bold text-white mb-0"><i class="fas fa-mosque me-2"></i>SiPontren</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="<?= $base_url ?>index.php" class="nav-link"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li class="nav-item"><a href="<?= $base_url ?>modules/santri/index.php" class="nav-link"><i class="fas fa-users"></i> Santri Aktif</a></li>
            <li class="nav-item"><a href="<?= $base_url ?>modules/alumni/index.php" class="nav-link"><i class="fas fa-user-graduate"></i> Alumni</a></li>
            <li class="nav-item"><a href="<?= $base_url ?>modules/guru/index.php" class="nav-link"><i class="fas fa-teacher"></i> Guru</a></li>
            <li class="nav-item"><a href="<?= $base_url ?>modules/keuangan/index.php" class="nav-link"><i class="fas fa-wallet"></i> Keuangan</a></li>
            <li class="nav-item"><a href="<?= $base_url ?>modules/absensi/index.php" class="nav-link"><i class="fas fa-calendar-check"></i> Absensi</a></li>
            <li class="nav-item">
                <a href="<?= $base_url ?>modules/pengeluaran/index.php" class="nav-link <?= $directory == 'pengeluaran' ? 'active bg-primary text-white' : '' ?>">
                    <i class="fas fa-arrow-circle-up me-2"></i> Pengeluaran
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $base_url ?>modules/kitab/index.php" class="nav-link <?= $directory == 'kitab' ? 'active bg-primary text-white' : '' ?>">
                    <i class="fas fa-book me-2"></i> Master Kitab
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $base_url ?>modules/jadwal/index.php" class="nav-link <?= $directory == 'jadwal' ? 'active bg-primary text-white' : '' ?>">
                    <i class="fas fa-calendar-alt me-2"></i> Jadwal Pelajaran
                </a>
            </li>
            <li class="nav-item mt-4"><a href="<?= $base_url ?>logout.php" class="nav-link text-danger fw-bold"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

        </ul>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom p-3 shadow-sm">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=random" class="rounded-circle me-2" width="30">
                    <span class="small fw-bold">Administrator</span>
                </div>
            </div>
        </nav>
        <div class="p-4">