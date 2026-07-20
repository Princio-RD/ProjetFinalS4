<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - MobileMoney</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.min.css') ?>">
    <style>
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        .login-header {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        .login-body {
            padding: 40px;
            background: white;
        }
        .btn-dark {
            background: #212529;
            border-color: #212529;
        }
        .btn-dark:hover {
            background: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card shadow-sm">
                    <div class="login-header">
                        <i class="bi bi-phone fs-1"></i>
                        <h4 class="mt-2">Admin MobileMoney</h4>
                        <p class="text-muted small mb-0">Gestion des opérateurs et transactions</p>
                    </div>
                    <div class="login-body">
                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/auth') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-person"></i> Nom d'utilisateur
                                </label>
                                <input type="text" class="form-control" name="username" value="admin" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-lock"></i> Mot de passe
                                </label>
                                <input type="password" class="form-control" name="password" value="admin123" required>
                            </div>

                            <button type="submit" class="btn btn-dark w-100">
                                <i class="bi bi-box-arrow-in-right"></i> Se connecter
                            </button>
                        </form>

                        <div class="text-center mt-4 text-muted small">
                            © <?= date('Y') ?> MobileMoney - Version 2.0
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>