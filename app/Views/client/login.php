<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Client - MobileMoney</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f7f9fb 0%, #e0e3e5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            padding: 40px;
            max-width: 420px;
            width: 100%;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-card .logo i {
            font-size: 3rem;
            color: #1e40af;
        }
        .login-card .logo h1 {
            font-weight: 700;
            color: #1e40af;
            margin-top: 10px;
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
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }
        .btn-primary-custom {
            background: #1e40af;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-primary-custom:hover {
            background: #1a3a8a;
            transform: scale(1.02);
        }
        .btn-admin {
            background: transparent;
            color: #1e40af;
            border: 1px solid #1e40af;
            padding: 10px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-admin:hover {
            background: #1e40af;
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
        .switch-link {
            color: #1e40af;
            text-decoration: none;
            font-weight: 500;
        }
        .switch-link:hover {
            text-decoration: underline;
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
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="bi bi-phone"></i>
            <h1>MobileMoney</h1>
            <p><i class="bi bi-shield-lock"></i> Portail client sécurisé</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/loginAuto') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-4 input-icon">
                <i class="bi bi-phone"></i>
                <input type="tel" class="form-control form-control-custom" 
                       name="numero_telephone" placeholder="Numéro de téléphone" 
                       required>
            </div>

            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>
        </form>

        <div class="divider">
            <span>ou</span>
        </div>

        <a href="<?= base_url('admin/login') ?>" class="btn-admin text-center text-decoration-none d-block">
            <i class="bi bi-shield-lock"></i> Connexion Admin
        </a>

        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="bi bi-shield-lock"></i> Connexion sécurisée
            </small>
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