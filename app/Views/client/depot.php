<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dépôt - Transfert d'argent</title>
</head>
<body>
    <h2>Dépôt sur le compte n° <?= esc($compte['id_compte']) ?></h2>

    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= esc(session()->get('error')) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/depot') ?>">
        <label for="montant">Montant à déposer (Ariary) :</label><br>
        <input type="number" name="montant" id="montant" step="0.01" min="0.01" required>
        <br><br>
        <button type="submit">Confirmer le dépôt</button>
    </form>

    <br>
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>">Retour au solde</a>
</body>
</html>
