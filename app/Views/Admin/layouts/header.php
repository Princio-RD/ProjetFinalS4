<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin MobileMoney' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --primary-dark: #162c7a;
            --surface: #f7f9fb;
            --text-secondary: #444653;
            --sidebar-width: 260px;
        }
        
        * {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        body {
            background: var(--surface);
            min-height: 100vh;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f172a 0%, #1a1a2e 50%, #16213e 100%);
            padding-top: 70px;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 20px rgba(0,0,0,0.15);
            overflow-y: auto;
        }
        
        .sidebar .sidebar-brand {
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 16px;
        }
        
        .sidebar .sidebar-brand .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
        }
        
        .sidebar .sidebar-brand h5 {
            color: white;
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar .sidebar-brand small {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
        }
        
        .sidebar .user-profile {
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 8px;
        }
        
        .sidebar .user-profile .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .sidebar .user-profile .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .sidebar .user-profile .user-role {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.6);
            padding: 12px 20px;
            margin: 2px 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            display: block;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        
        .sidebar .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .sidebar .nav-link.logout {
            color: rgba(255,100,100,0.7);
            margin-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 16px;
        }
        
        .sidebar .nav-link.logout:hover {
            color: #ff6b6b;
            background: rgba(255,100,100,0.1);
        }
        
        .navbar-custom {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(196, 197, 213, 0.3);
            box-shadow: 0 2px 20px rgba(0,0,0,0.04);
            height: 64px;
        }
        
        .navbar-custom .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .navbar-custom .navbar-brand i {
            font-size: 1.4rem;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 80px 30px 30px;
            min-height: 100vh;
        }
        
        .card-custom {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        
        .card-custom .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 18px 24px;
            font-weight: 600;
        }
        
        .card-custom .card-body {
            padding: 24px;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        
        .stat-card .stat-icon.blue { background: rgba(30, 64, 175, 0.1); color: #1e40af; }
        .stat-card .stat-icon.green { background: rgba(0, 108, 73, 0.1); color: #006c49; }
        .stat-card .stat-icon.orange { background: rgba(246, 211, 101, 0.15); color: #d4970a; }
        .stat-card .stat-icon.purple { background: rgba(118, 75, 162, 0.1); color: #764ba2; }
        .stat-card .stat-icon.red { background: rgba(186, 26, 26, 0.1); color: #ba1a1a; }
        
        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        
        .stat-card .stat-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: scale(1.02);
            color: white;
        }
        
        .form-control-custom {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }
        
        .form-select-custom {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }
        
        .form-select-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }
        
        .table-custom thead th {
            background: rgba(0,0,0,0.02);
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--text-secondary);
            padding: 14px 16px;
        }
        
        .table-custom tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
        }
        
        .table-custom tbody tr:hover {
            background: rgba(0,0,0,0.01);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                padding-top: 60px;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 70px 16px 16px;
            }
            .navbar-custom .navbar-brand span {
                display: none;
            }
        }
        
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #c4c5d5;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0a0b0;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-3">
            <div class="brand-icon">
                <i class="bi bi-phone"></i>
            </div>
            <div>
                <h5>MobileMoney</h5>
                <small><i class="bi bi-shield-lock"></i> Admin Panel</small>
            </div>
        </div>
    </div>
    
    <div class="user-profile">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <div class="user-name">Administrateur</div>
                <div class="user-role"><i class="bi bi-star-fill text-warning"></i> Super Admin</div>
            </div>
        </div>
    </div>
    
    <nav class="nav flex-column">
        <?php 
            $currentUri = current_url();
            $baseAdmin = base_url('admin');
            $isAdmin = ($currentUri == $baseAdmin);
            $isOperateur = (strpos($currentUri, '/operateur') !== false);
            $isOperation = (strpos($currentUri, '/operation') !== false);
        ?>
        
        <!-- Tableau de bord -->
        <a class="nav-link <?= $isAdmin ? 'active' : '' ?>" 
           href="<?= base_url('admin') ?>">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        
        <!-- Préfixes -->
        <a class="nav-link <?= $isOperateur ? 'active' : '' ?>" 
           href="<?= base_url('admin/operateur') ?>">
            <i class="bi bi-tags"></i> Préfixes
        </a>
        
        <!-- Opérations -->
        <a class="nav-link <?= $isOperation ? 'active' : '' ?>" 
           href="<?= base_url('admin/operation') ?>">
            <i class="bi bi-gear"></i> Opérations
        </a>
        
        <!-- Déconnexion -->
        <a class="nav-link logout" href="<?= base_url('admin/logout') ?>">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </nav>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <button class="btn btn-link d-md-none text-dark p-0 me-3" type="button" id="sidebarToggle">
            <i class="bi bi-list fs-3"></i>
        </button>
        <a class="navbar-brand" href="<?= base_url('admin') ?>">
            <i class="bi bi-phone"></i> <span>MobileMoney Admin</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-dark d-none d-sm-inline">
                <i class="bi bi-shield-lock"></i> Admin
            </span>
            <a href="<?= base_url('admin/logout') ?>" class="btn btn-sm btn-outline-danger" title="Déconnexion">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content" id="mainContent">