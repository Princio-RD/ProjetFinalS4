<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Mobile Money</h2>
    
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    
    <form action="/admin/auth" method="post">
        <?= csrf_field() ?>
        <p>Nom: <input type="text" name="username" value="local"></p>
        <p>Mot de passe: <input type="password" name="password" value="okeybrada"></p>
        <p><button type="submit">Se connecter</button></p>
    </form>
</body>
</html>