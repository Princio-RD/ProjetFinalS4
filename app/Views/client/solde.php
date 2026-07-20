<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Solde du compte - Transfert d'argent</title>
</head>
<body>
    <h2>Solde du compte n° <?= esc($compte['id_compte']) ?></h2>

    <?php if (session()->get('success')): ?>
        <p style="color: green;"><?= esc(session()->get('success')) ?></p>
    <?php endif; ?>
    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= esc(session()->get('error')) ?></p>
    <?php endif; ?>

    <p><strong>Solde actuel :</strong> <?= esc($solde) ?> Ariary</p>

    <p>
        <a href="<?= base_url('compte/' . $compte['id_compte'] . '/depot') ?>">Faire un dépôt</a> |
        <a href="<?= base_url('compte/' . $compte['id_compte'] . '/retrait') ?>">Faire un retrait</a>
    </p>

    <br>
    <a href="<?= base_url('dashboard') ?>">Retour au tableau de bord</a>
</body>
</html>
