<?php
/**
 * Admin Header - Modern Dashboard Edition
 * Sakura Florist Solo
 */
require_once 'auth.php';
require_login();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sakura Florist Solo</title>
    <!-- Google Fonts Inter & Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="sidebar-brand">Sakura</span> Admin
        </div>
        <nav class="sidebar-nav">
            <a class="nav-link-admin <?= strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : '' ?>" href="index.php">
                <i class="fas fa-grid-2"></i> Dashboard
            </a>
            <a class="nav-link-admin <?= strpos($_SERVER['PHP_SELF'], 'categories.php') !== false ? 'active' : '' ?>" href="categories.php">
                <i class="fas fa-layer-group"></i> Categories
            </a>
            <a class="nav-link-admin <?= strpos($_SERVER['PHP_SELF'], 'flowers.php') !== false ? 'active' : '' ?>" href="flowers.php">
                <i class="fas fa-leaf"></i> Flowers
            </a>
            <a class="nav-link-admin <?= strpos($_SERVER['PHP_SELF'], 'blogs.php') !== false ? 'active' : '' ?>" href="blogs.php">
                <i class="fas fa-pen-nib"></i> Blogs
            </a>
            <a class="nav-link-admin <?= strpos($_SERVER['PHP_SELF'], 'pages.php') !== false ? 'active' : '' ?>" href="pages.php">
                <i class="fas fa-pager"></i> Pages
            </a>
            <a class="nav-link-admin <?= strpos($_SERVER['PHP_SELF'], 'config.php') !== false ? 'active' : '' ?>" href="config.php">
                <i class="fas fa-sliders-h"></i> Configuration
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="logout.php" class="btn btn-outline-danger btn-sm w-100 py-2 border-0">
                <i class="fas fa-power-off me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-area">
        <!-- Top Header Bar -->
        <header class="top-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-link link-dark d-lg-none navbar-toggler-admin me-3 p-0">
                    <i class="fas fa-bars h4 mb-0"></i>
                </button>
                <div class="page-title">
                    <h4 class="h5 mb-0 fw-bold">Dashboard</h4>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="/" target="_blank" class="btn btn-light btn-sm rounded-pill px-3 d-none d-sm-inline-flex align-items-center">
                    <i class="fas fa-external-link-alt me-2 small"></i> View Site
                </a>
                <div class="user-profile d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold small"><?= htmlspecialchars($_SESSION['admin_user']) ?></div>
                        <div class="text-muted" style="font-size: 0.7rem;">Administrator</div>
                    </div>
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                        <?= strtoupper(substr($_SESSION['admin_user'], 0, 1)) ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <div class="p-4 p-lg-5">
