<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des transactions - Transfert d'argent</title>
</head>
<body>
    <h2>Historique des transactions - Compte n° <?= esc($compte['id_compte']) ?></h2>

    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= esc(session()->get('error')) ?></p>
    <?php endif; ?>

    <?php if (empty($transactions)): ?>
        <p>Aucune transaction enregistrée pour ce compte.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Montant (Ariary)</th>
                    <th>Frais (Ariary)</th>
                    <th>Compte source</th>
                    <th>Compte destination</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td><?= esc($t['date_operation']) ?></td>
                        <td><?= esc($t['libelle']) ?></td>
                        <td><?= number_format($t['montant'], 2, ',', ' ') ?></td>
                        <td><?= number_format($t['frais_applique'], 2, ',', ' ') ?></td>
                        <td><?= esc($t['id_compte_source']) ?></td>
                        <td><?= esc($t['id_compte_destination'] ?? 'N/A') ?></td>
                        <td><?= esc($t['statut']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>">Retour au solde</a> |
    <a href="<?= base_url('dashboard') ?>">Retour au tableau de bord</a>
</body>
</html>
