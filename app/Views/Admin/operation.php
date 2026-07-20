<!-- app/Views/admin/operation.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion Opérations</title>
</head>
<body>
    <h2>Opérations et Barèmes</h2>
    
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

    <h3>Types d'opérations</h3>
    <form action="/admin/operation/store" method="post">
        <?= csrf_field() ?>
        <input type="text" name="libelle" placeholder="ex: Achat" required>
        <button type="submit">Ajouter</button>
    </form>
    
    <ul>
        <?php foreach ($operations as $op): ?>
            <li>#<?= $op['id_type_operation'] ?> - <?= $op['libelle'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Barèmes de frais</h3>
    <form action="/admin/operation/tarif" method="post">
        <?= csrf_field() ?>
        <select name="id_type_operation" required>
            <option value="">Type</option>
            <?php foreach ($operations as $op): ?>
                <option value="<?= $op['id_type_operation'] ?>"><?= $op['libelle'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="montant_min" placeholder="Min" required>
        <input type="number" name="montant_max" placeholder="Max" required>
        <input type="number" name="frais" placeholder="Frais" required>
        <button type="submit">Ajouter</button>
    </form>

    <table border="1" cellpadding="5">
        <tr>
            <th>Type</th>
            <th>Min</th>
            <th>Max</th>
            <th>Frais</th>
            <th>Action</th>
        </tr>
        <?php foreach ($tarifs as $t): ?>
        <tr>
            <td><?= $t['libelle'] ?></td>
            <td><?= number_format($t['montant_min'], 0, ',', ' ') ?></td>
            <td><?= number_format($t['montant_max'], 0, ',', ' ') ?></td>
            <td><strong><?= number_format($t['frais'], 0, ',', ' ') ?></strong></td>
            <td>
                <a href="/admin/operation/tarif/delete/<?= $t['id_bareme'] ?>" 
                   onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>