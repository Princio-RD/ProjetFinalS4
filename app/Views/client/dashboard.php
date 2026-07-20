<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Transfert d'argent</title>
</head>
<body>
    <h2>Bienvenue, client n° <?= esc($client['id_client']) ?></h2>
    <p>Numéro de téléphone : <?= esc($client['numero_telephone']) ?></p>

    <h3>Mes comptes</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID Compte</th>
                <th>Opérateur</th>
                <th>Solde (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comptes as $compte): ?>
                <tr>
                    <td><?= esc($compte['id_compte']) ?></td>
                    <td><?= esc($compte['id_operateur']) ?></td>
                    <td><?= number_format($compte['solde'], 2, ',', ' ') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="<?= base_url('logout') ?>">Se déconnecter</a>
</body>
</html>
