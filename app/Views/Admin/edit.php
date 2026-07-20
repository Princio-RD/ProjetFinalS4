<!-- app/Views/Admin/edit.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier un préfixe</title>
</head>
<body>
    <h2>Modifier un préfixe</h2>
    
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
    
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- Formulaire de modification -->
    <h3>Modifier l'opérateur #<?= $operateur['id_operateur'] ?></h3>
    <form action="/admin/operateur/update/<?= $operateur['id_operateur'] ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label>Nom :</label><br>
            <input type="text" name="nom" value="<?= $operateur['nom'] ?>" required>
        </p>
        <p>
            <label>Préfixe :</label><br>
            <input type="text" name="prefixe" value="<?= $operateur['prefixe'] ?>" required>
        </p>
        <p>
            <button type="submit">Mettre à jour</button>
            <a href="/admin/operateur">Annuler</a>
        </p>
    </form>

    <hr>

    <!-- Liste des opérateurs -->
    <h3>Liste des préfixes</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Préfixe</th>
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
</body>
</html>