<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h2> Dashboard Admin</h2>
    <hr>
    
    <p>
        <a href="/admin">Dashboard</a> | 
        <a href="/admin/operateur">Préfixes</a> | 
        <a href="/admin/operation">Opérations</a> | 
        <a href="/admin/logout">Déconnexion</a>
    </p>
    <hr>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <!-- ========================================================= -->
    <!-- 1. Situation des comptes clients -->
    <!-- ========================================================= -->
    <h3> Situation des comptes clients</h3>
    <table border="1" cellpadding="5">
        <tr>
            <td><strong>Clients</strong></td>
            <td><strong>Comptes</strong></td>
            <td><strong>Solde Total</strong></td>
        </tr>
        <tr>
            <td><?= $total_clients ?? 0 ?></td>
            <td><?= $total_comptes ?? 0 ?></td>
            <td><?= number_format($solde_total ?? 0, 0, ',', ' ') ?> Ar</td>
        </tr>
    </table>
    <br>

    <!-- ========================================================= -->
    <!-- 2. Gains par type d'opération -->
    <!-- ========================================================= -->
    <h3> Gains par type d'opération</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Type d'opération</th>
            <th>Total des frais</th>
        </tr>
        <?php foreach ($gains_par_operation as $libelle => $montant): ?>
        <tr>
            <td><?= $libelle ?></td>
            <td><strong><?= number_format($montant, 0, ',', ' ') ?> Ar</strong></td>
        </tr>
        <?php endforeach; ?>
        <tr bgcolor="#f0f0f0">
            <td><strong>TOTAL GAINS</strong></td>
            <td><strong><?= number_format($total_gains ?? 0, 0, ',', ' ') ?> Ar</strong></td>
        </tr>
    </table>
    <br>

    <!-- ========================================================= -->
    <!-- 3. Liste des clients avec leurs comptes -->
    <!-- ========================================================= -->
    <h3> Liste des clients</h3>
    <table border="1" cellpadding="5" width="100%">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Numéro</th>
            <th>Date création</th>
            <th>Nombre comptes</th>
            <th>Solde Total</th>
            <th>Détails comptes</th>
        </tr>
        <?php if (!empty($clients_avec_comptes)): ?>
            <?php foreach ($clients_avec_comptes as $item): ?>
            <tr>
                <td><?= $item['client']['id_client'] ?></td>
                <td><?= $item['client']['nom'] ?></td>
                <td><?= $item['client']['numero_telephone'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($item['client']['date_creation'])) ?></td>
                <td align="center"><?= $item['nombre_comptes'] ?></td>
                <td align="right"><strong><?= number_format($item['solde_total'], 0, ',', ' ') ?> Ar</strong></td>
                <td>
                    <?php foreach ($item['comptes'] as $compte): ?>
                        (<?= $compte['operateur_nom'] ?>) 
                        : <?= number_format($compte['solde'], 0, ',', ' ') ?> Ar<br>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" align="center">Aucun client</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>

    <!-- ========================================================= -->
    <!-- 4. Comptes par opérateur -->
    <!-- ========================================================= -->
    <h3> Comptes par opérateur</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Opérateur</th>
            <th>Nombre</th>
            <th>Solde Total</th>
        </tr>
        <?php foreach ($comptes_par_operateur ?? [] as $item): ?>
        <tr>
            <td><?= $item['nom'] ?> (<?= $item['prefixe'] ?>)</td>
            <td><?= $item['total'] ?></td>
            <td><?= number_format($item['solde_total'], 0, ',', ' ') ?> Ar</td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>