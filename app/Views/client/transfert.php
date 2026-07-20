<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Transfert - Transfert d'argent</title>
    <link rel="stylesheet" href="/style/main.css">
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
    <p><em>Une commission est appliquée si l'opérateur source et l'opérateur destination sont différents.</em></p>

    <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/transfert') ?>">
        <div id="telephones-container">
            <div class="champ-telephone" style="margin-bottom: 8px;">
                <label>Numéro de téléphone du destinataire :</label><br>
                <input type="tel" name="telephone_destination[]" placeholder="Ex: 0331562072" required>
                <br><br>
                <label>Montant à transférer (Ariary) :</label><br>
                <input type="number" name="montant[]" step="0.01" min="0.01" required>
                <br><br>
            </div>
        </div>

        <button type="button" id="btn-ajouter" onclick="ajouterChamp()">+ Ajouter un autre destinataire</button>
        <br><br>

        <button type="submit">Confirmer le transfert</button>
    </form>

    <br>
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>">Retour au solde</a>
    <script>
        function ajouterChamp() {
            const container = document.getElementById('telephones-container');

            const div = document.createElement('div');
            div.className = 'champ-telephone';
            div.style.marginBottom = '8px';

            div.innerHTML = `
                <label>Numéro de téléphone du destinataire :</label><br>
                <input type="tel" name="telephone_destination[]" placeholder="Ex: 0331234567" required>
                <br><br>
                <label>Montant à transférer (Ariary) :</label><br>
                <input type="number" name="montant[]" step="0.01" min="0.01" required>
                <br><br>
                <button type="button" onclick="supprimerChamp(this)" style="color:red;">Supprimer</button>
                <br><br>
            `;

            container.appendChild(div);
        }

        function supprimerChamp(bouton) {
            bouton.parentElement.remove();
        }
    </script>
</body>
</html>
