<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Transfert d'argent</title>
</head>
<body>
    <h2>Connexion Client</h2>
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('auth/loginAuto') ?>" method="post">
        <?= csrf_field() ?>
        <label for="numero_telephone">Numéro de téléphone (ex: 0331234567) :</label><br>
        <input type="text" name="numero_telephone" id="numero_telephone" required placeholder="033XXXXXXX">
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>