<?php $title = 'Tableau de bord Admin'; ?>
<?= $this->include('admin/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-speedometer2 text-primary"></i> Tableau de bord</h2>
        <p class="text-muted"><i class="bi bi-info-circle"></i> Aperçu des statistiques et de l'activité du système</p>
    </div>
    <span class="badge bg-success-subtle text-success px-3 py-2">
        <i class="bi bi-check-circle"></i> Système actif
    </span>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label"><i class="bi bi-people"></i> Clients</div>
                    <div class="stat-number"><?= $total_clients ?? 0 ?></div>
                </div>
                <div class="stat-icon blue">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label"><i class="bi bi-wallet2"></i> Comptes</div>
                    <div class="stat-number"><?= $total_comptes ?? 0 ?></div>
                </div>
                <div class="stat-icon purple">
                    <i class="bi bi-wallet-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label"><i class="bi bi-cash-stack"></i> Solde Total</div>
                    <div class="stat-number"><?= number_format($solde_total ?? 0, 0, ',', ' ') ?></div>
                </div>
                <div class="stat-icon green">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
            <small class="text-muted"><i class="bi bi-coin"></i> Ar</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label"><i class="bi bi-graph-up-arrow"></i> Total Gains</div>
                    <div class="stat-number"><?= number_format($total_gains ?? 0, 0, ',', ' ') ?></div>
                </div>
                <div class="stat-icon orange">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
            <small class="text-muted"><i class="bi bi-coin"></i> Ar</small>
        </div>
    </div>
</div>

<!-- Gains par opérateur -->
<div class="card-custom mb-4">
    <div class="card-header">
        <i class="bi bi-pie-chart text-primary"></i> Gains par opérateur
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th><i class="bi bi-building"></i> Opérateur</th>
                        <th><i class="bi bi-hash"></i> Préfixe</th>
                        <th class="text-end"><i class="bi bi-coin"></i> Dépôt</th>
                        <th class="text-end"><i class="bi bi-arrow-down-circle"></i> Retrait</th>
                        <th class="text-end"><i class="bi bi-arrow-left-right"></i> Transfert</th>
                        <th class="text-end"><i class="bi bi-cash-stack"></i> Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($gains_details)): ?>
                        <?php foreach ($gains_details as $id => $data): ?>
                        <tr>
                            <td><strong><?= esc($data['nom']) ?></strong></td>
                            <td><span class="badge bg-secondary"><?= esc($data['prefixe']) ?></span></td>
                            <td class="text-end"><?= number_format($data['depot'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><?= number_format($data['retrait'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><?= number_format($data['transfert'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><strong class="text-primary"><?= number_format($gains_par_operateur[$id]['total'] ?? 0, 0, ',', ' ') ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Aucune donnée disponible</td></tr>
                    <?php endif; ?>
                    <tr class="table-light">
                        <td colspan="5" class="text-end fw-bold"><i class="bi bi-cash-stack"></i> TOTAL GENERAL</td>
                        <td class="text-end fw-bold text-primary"><?= number_format($total_gains ?? 0, 0, ',', ' ') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Montants à envoyer -->
<div class="card-custom mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-send"></i> Montants à envoyer aux opérateurs
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th><i class="bi bi-building"></i> Opérateur</th>
                        <th><i class="bi bi-hash"></i> Préfixe</th>
                        <th class="text-end"><i class="bi bi-cash-stack"></i> Montant à payer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($montants_a_envoyer)): ?>
                        <?php foreach ($montants_a_envoyer as $id => $data): ?>
                        <tr>
                            <td><strong><?= esc($data['nom']) ?></strong></td>
                            <td><span class="badge bg-primary"><?= esc($data['prefixe']) ?></span></td>
                            <td class="text-end"><strong class="text-primary"><?= number_format($data['total_a_payer'] ?? 0, 0, ',', ' ') ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Aucune donnée disponible</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Liste des clients -->
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people text-primary"></i> Liste des clients</span>
        <span class="badge bg-primary"><i class="bi bi-people"></i> Total: <?= $total_clients ?? 0 ?></span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-person"></i> Nom</th>
                        <th><i class="bi bi-phone"></i> Numéro</th>
                        <th><i class="bi bi-calendar3"></i> Date création</th>
                        <th class="text-center"><i class="bi bi-wallet2"></i> Comptes</th>
                        <th class="text-end"><i class="bi bi-cash-stack"></i> Solde Total</th>
                        <th class="text-center"><i class="bi bi-eye"></i> Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients_avec_comptes)): ?>
                        <?php foreach ($clients_avec_comptes as $item): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?= esc($item['client']['id_client']) ?></span></td>
                            <td><strong><?= esc($item['client']['nom']) ?></strong></td>
                            <td><i class="bi bi-sim"></i> <?= esc($item['numero_telephone'] ?? '') ?></td>
                            <td><i class="bi bi-clock"></i> <?= date('d/m/Y H:i', strtotime($item['client']['date_creation'])) ?></td>
                            <td class="text-center"><span class="badge bg-secondary"><?= $item['nombre_comptes'] ?></span></td>
                            <td class="text-end"><strong class="text-primary"><?= number_format($item['solde_total'], 0, ',', ' ') ?></strong></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#details-<?= $item['client']['id_client'] ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="collapse mt-2 text-start" id="details-<?= $item['client']['id_client'] ?>">
                                    <?php foreach ($item['comptes'] as $compte): ?>
                                        <small class="d-block">
                                            <span class="badge bg-secondary"><i class="bi bi-phone"></i> <?= esc($compte['operateur_nom'] ?? 'N/A') ?></span>
                                            : <span class="text-primary"><?= number_format($compte['solde'], 0, ',', ' ') ?></span>
                                        </small>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Aucun client trouvé
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>