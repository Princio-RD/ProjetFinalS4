<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion Préfixes</title>
</head>
<body>
    <h2>Configuration des Prefixes</h2>
    
    <p>
        <a href="/admin">Dashboard</a> | 
        <a href="/admin/operateur">Prefixes</a> | 
        <a href="/admin/operation">Operations</a> | 
        <a href="/admin/logout">Deconnexion</a>
    </p>
    <hr>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <h3>Ajouter un prefixe</h3>
    <form action="/admin/operateur/store" method="post">
        <?= csrf_field() ?>
        Nom: <input type="text" name="nom" required>
        Prefixe: <input type="text" name="prefixe" required>
        <button type="submit">Ajouter</button>
    </form>

    <h3>Liste des prefixes</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prefixe</th>
            <th>Action</th>
        </tr>
        <?php foreach ($operateurs as $op): ?>
        <tr>
            <td><?= $op['id_operateur'] ?></td>
            <td><?= $op['nom'] ?></td>
            <td><strong><?= $op['prefixe'] ?></strong></td>
            <td>
                <a href="/admin/operateur/edit/<?= $op['id_operateur'] ?>">Modifier</a> |
                <a href="/admin/operateur/delete/<?= $op['id_operateur'] ?>" 
                   onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <h3>Configuration des commissions</h3>
    <form action="/admin/operateur/commission/store" method="post">
        <?= csrf_field() ?>
        <p>
            <select name="id_operateur_source" required>
                <option value="">Source</option>
                <?php foreach ($operateurs as $op): ?>
                    <option value="<?= $op['id_operateur'] ?>"><?= $op['nom'] ?> (<?= $op['prefixe'] ?>)</option>
                <?php endforeach; ?>
            </select>
            
            <select name="id_operateur_destination" required>
                <option value="">Destination</option>
                <?php foreach ($operateurs as $op): ?>
                    <option value="<?= $op['id_operateur'] ?>"><?= $op['nom'] ?> (<?= $op['prefixe'] ?>)</option>
                <?php endforeach; ?>
            </select>
            
            Commission (%): <input type="number" name="pourcentage" step="0.01" value="0" required>
            <button type="submit">Configurer</button>
        </p>
    </form>

    <h4>Commissions configurées</h4>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Commission (%)</th>
            <th>Action</th>
        </tr>
        <?php foreach ($commissions ?? [] as $c): ?>
        <tr>
            <td><?= $c['id_commission'] ?></td>
            <td><?= $c['source_nom'] ?> (<?= $c['source_prefixe'] ?>)</td>
            <td><?= $c['dest_nom'] ?> (<?= $c['dest_prefixe'] ?>)</td>
            <td><strong><?= $c['pourcentage'] ?> %</strong></td>
            <td>
                <a href="/admin/operateur/commission/delete/<?= $c['id_commission'] ?>" 
                   onclick="return confirm('Supprimer cette commission ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>