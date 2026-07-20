<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Transfert - Transfert d'argent</title>
</head>
<body>
    <h2>Transfert depuis le compte n° <?= esc($compte['id_compte']) ?></h2>

    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= esc(session()->get('error')) ?></p>
    <?php endif; ?>
    <?php if (session()->get('success')): ?>
        <p style="color: green;"><?= esc(session()->get('success')) ?></p>
    <?php endif; ?>

    <p>Solde disponible : <?= number_format($compte['solde'], 2, ',', ' ') ?> Ariary</p>
    <p><em>Des frais de transfert sont appliqués selon le barème en vigueur (déduits du solde).</em></p>

    <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/transfert') ?>">
        <label for="telephone_destination">Numéro de téléphone du destinataire :</label><br>
        <input type="tel" name="telephone_destination" id="telephone_destination" placeholder="Ex: 0331562072" required>
        <br><br>

        <label for="montant">Montant à transférer (Ariary) :</label><br>
        <input type="number" name="montant" id="montant" step="0.01" min="0.01" required>
        <br><br>

        <button type="submit">Confirmer le transfert</button>
    </form>

    <br>
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>">Retour au solde</a>
</body>
</html>
