<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retrait - Transfert d'argent</title>
</head>
<body>
    <h2>Retrait sur le compte n° <?= esc($compte['id_compte']) ?></h2>

    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= esc(session()->get('error')) ?></p>
    <?php endif; ?>

    <p>Solde disponible : <?= number_format($compte['solde'], 2, ',', ' ') ?> Ariary</p>
    <p><em>Des frais de retrait sont appliqués selon le barème en vigueur (déduits du solde).</em></p>

    <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/retrait') ?>">
        <label for="montant">Montant à retirer (Ariary) :</label><br>
        <input type="number" name="montant" id="montant" step="0.01" min="0.01" required>
        <br><br>
        <button type="submit">Confirmer le retrait</button>
    </form>

    <br>
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>">Retour au solde</a>
</body>
</html>
