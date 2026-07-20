<!-- app/Views/admin/operateur.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion Préfixes</title>
</head>
<body>
    <h2>Configuration des Préfixes</h2>
    
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

    <h3>Ajouter un préfixe</h3>
    <form action="/admin/operateur/store" method="post">
        <?= csrf_field() ?>
        Nom: <input type="text" name="nom" required>
        Préfixe: <input type="text" name="prefixe" required>
        <button type="submit">Ajouter</button>
    </form>

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
                <a href="/admin/operateur/delete/<?= $op['id_operateur'] ?>" 
                   onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>