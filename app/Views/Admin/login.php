<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - MobileMoney</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 420px;
            width: 100%;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-card .logo .brand-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .login-card .logo .brand-icon i {
            font-size: 2rem;
            color: white;
        }
        .login-card .logo h1 {
            font-weight: 700;
            color: #1a1a2e;
            font-size: 1.5rem;
        }
        .login-card .logo p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .form-control-custom {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 18px;
            transition: all 0.3s ease;
        }
        .form-control-custom:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-login:hover {
            transform: scale(1.02);
            color: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .btn-client {
            background: transparent;
            color: #667eea;
            border: 1px solid #667eea;
            padding: 10px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-client:hover {
            background: #667eea;
            color: white;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0a0a0;
        }
        .input-icon input {
            padding-left: 48px;
        }
        .security-badge {
            background: rgba(0,0,0,0.05);
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 0.75rem;
            color: #6c757d;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider span {
            padding: 0 15px;
            color: #6c757d;
            font-size: 0.85rem;
        }
        .switch-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .switch-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <div class="brand-icon">
                <i class="bi bi-phone"></i>
            </div>
            <h1><i class="bi bi-shield-lock"></i> MobileMoney Admin</h1>
            <p><i class="bi bi-gear"></i> Gestion des opérateurs et transactions</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/auth') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3 input-icon">
                <i class="bi bi-person"></i>
                <input type="text" class="form-control form-control-custom" 
                       name="username" placeholder="Nom d'utilisateur" 
                       value="local" required>
            </div>

            <div class="mb-4 input-icon">
                <i class="bi bi-lock"></i>
                <input type="password" class="form-control form-control-custom" 
                       name="password" placeholder="Mot de passe" 
                       value="okeybrada" required>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>
        </form>

        <div class="divider">
            <span>ou</span>
        </div>

        <a href="<?= base_url('/') ?>" class="btn-client text-center text-decoration-none d-block">
            <i class="bi bi-person"></i> Connexion Client
        </a>

        <div class="text-center mt-4">
            <span class="security-badge">
                <i class="bi bi-shield-lock"></i> Connexion sécurisée
            </span>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">
                <i class="bi bi-c-circle"></i> <?= date('Y') ?> MobileMoney
            </small>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>