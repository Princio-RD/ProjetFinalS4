<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Dashboard Admin</h2>
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

    <h3>Situation des comptes clients</h3>
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

    <h3>Situation des gains par operateur</h3>
    <table border="1" cellpadding="5" width="100%">
        <tr bgcolor="#f0f0f0">
            <th>Operateur</th>
            <th>Prefixe</th>
            <th>Depot</th>
            <th>Retrait</th>
            <th>Transfert</th>
            <th>Total</th>
        </tr>
        <?php foreach ($gains_details as $id => $data): ?>
        <tr>
            <td><strong><?= $data['nom'] ?></strong></td>
            <td><span style="background:#007bff;color:white;padding:2px 8px;border-radius:3px;"><?= $data['prefixe'] ?></span></td>
            <td><?= number_format($data['depot'], 0, ',', ' ') ?> Ar</td>
            <td><?= number_format($data['retrait'], 0, ',', ' ') ?> Ar</td>
            <td><?= number_format($data['transfert'], 0, ',', ' ') ?> Ar</td>
            <td><strong><?= number_format($gains_par_operateur[$id]['total'] ?? 0, 0, ',', ' ') ?> Ar</strong></td>
        </tr>
        <?php endforeach; ?>
        <tr bgcolor="#e0e0e0">
            <td colspan="5" align="right"><strong>TOTAL GENERAL</strong></td>
            <td><strong><?= number_format($total_gains ?? 0, 0, ',', ' ') ?> Ar</strong></td>
        </tr>
    </table>
    <br>

    <h3>Situation des gains vers les autres operateurs</h3>
    <table border="1" cellpadding="5" width="100%">
        <tr bgcolor="#f0f0f0">
            <th>Operateur Source</th>
            <th>Vers Operateur</th>
            <th>Frais collectes</th>
            <th>Commission (%)</th>
            <th>Montant a payer</th>
        </tr>
        <?php 
        $total_frais_inter = 0;
        $total_commissions = 0;
        foreach ($montants_a_envoyer as $id_dest => $data_dest):
            foreach ($data_dest['details'] as $detail):
                $total_frais_inter += $detail['frais'];
                $total_commissions += $detail['montant'];
        ?>
        <tr>
            <td><strong><?= $detail['source'] ?></strong></td>
            <td><strong><?= $data_dest['nom'] ?> (<?= $data_dest['prefixe'] ?>)</strong></td>
            <td><?= number_format($detail['frais'], 0, ',', ' ') ?> Ar</td>
            <td><?= $detail['pourcentage'] ?> %</td>
            <td><strong><?= number_format($detail['montant'], 0, ',', ' ') ?> Ar</strong></td>
        </tr>
        <?php 
            endforeach;
        endforeach;
        ?>
        <tr bgcolor="#e0e0e0">
            <td colspan="2" align="right"><strong>TOTAL</strong></td>
            <td><strong><?= number_format($total_frais_inter, 0, ',', ' ') ?> Ar</strong></td>
            <td></td>
            <td><strong><?= number_format($total_commissions, 0, ',', ' ') ?> Ar</strong></td>
        </tr>
    </table>
    <br>

    <h3>Situation des montants à envoyer à chaque operateur</h3>
    <table border="1" cellpadding="5">
        <tr bgcolor="#f0f0f0">
            <th>Operateur</th>
            <th>Prefixe</th>
            <th>Montant à payer</th>
        </tr>
        <?php foreach ($montants_a_envoyer as $id => $data): ?>
        <tr>
            <td><strong><?= $data['nom'] ?></strong></td>
            <td><span style="background:#007bff;color:white;padding:2px 8px;border-radius:3px;"><?= $data['prefixe'] ?></span></td>
            <td><strong><?= number_format($data['total_a_payer'], 0, ',', ' ') ?> Ar</strong></td>
        </tr>
        <?php endforeach; ?>
        <?php 
        $total_a_payer = 0;
        foreach ($montants_a_envoyer as $id => $data):
            $total_a_payer += $data['total_a_payer'];
        endforeach;
        ?>
        <tr bgcolor="#e0e0e0">
            <td colspan="2" align="right"><strong>TOTAL A PAYER</strong></td>
            <td><strong><?= number_format($total_a_payer, 0, ',', ' ') ?> Ar</strong></td>
        </tr>
    </table>
    <br>

    <h3>Liste des clients</h3>
    <table border="1" cellpadding="5" width="100%">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Numéro</th>
            <th>Date création</th>
            <th>Comptes</th>
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
                <td colspan="7" align="center">Aucun client</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>

    <h3>Comptes par opérateur</h3>
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