<?php $title = 'Dashboard Admin'; ?>
<?= $this->include('admin/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-speedometer2 text-primary"></i> Tableau de Bord</h1>
    <span class="badge bg-dark">Système actif</span>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase small">Clients</h6>
                        <h2 class="mb-0 text-white"><?= $total_clients ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-people fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase small">Comptes</h6>
                        <h2 class="mb-0 text-white"><?= $total_comptes ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-wallet2 fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase small">Solde Total</h6>
                        <h2 class="mb-0 text-white"><?= number_format($solde_total ?? 0, 0, ',', ' ') ?></h2>
                    </div>
                    <i class="bi bi-cash-stack fs-1 text-white-50"></i>
                </div>
                <small class="text-white-50">FCFA</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase small">Total Gains</h6>
                        <h2 class="mb-0 text-white"><?= number_format($total_gains ?? 0, 0, ',', ' ') ?></h2>
                    </div>
                    <i class="bi bi-graph-up-arrow fs-1 text-white-50"></i>
                </div>
                <small class="text-white-50">FCFA</small>
            </div>
        </div>
    </div>
</div>

<!-- Gains par opérateur -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Gains par opérateur</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Opérateur</th>
                        <th>Préfixe</th>
                        <th class="text-end">Dépôt</th>
                        <th class="text-end">Retrait</th>
                        <th class="text-end">Transfert</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($gains_details)): ?>
                        <?php foreach ($gains_details as $id => $data): ?>
                        <tr>
                            <td><strong><?= esc($data['nom']) ?></strong></td>
                            <td><span class="badge bg-dark"><?= esc($data['prefixe']) ?></span></td>
                            <td class="text-end"><?= number_format($data['depot'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><?= number_format($data['retrait'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><?= number_format($data['transfert'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><strong class="text-primary"><?= number_format($gains_par_operateur[$id]['total'] ?? 0, 0, ',', ' ') ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Aucune donnée disponible</td></tr>
                    <?php endif; ?>
                    <tr class="table-dark">
                        <td colspan="5" class="text-end fw-bold">TOTAL GENERAL</td>
                        <td class="text-end fw-bold text-primary"><?= number_format($total_gains ?? 0, 0, ',', ' ') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Montants à envoyer -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-send"></i> Montants à envoyer aux opérateurs</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Opérateur</th>
                        <th>Préfixe</th>
                        <th class="text-end">Montant à payer</th>
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
                        <tr><td colspan="3" class="text-center text-muted py-4">Aucune donnée disponible</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Liste des clients -->
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-people"></i> Liste des clients</h5>
        <span class="badge bg-primary">Total: <?= $total_clients ?? 0 ?></span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Numéro</th>
                        <th>Date création</th>
                        <th class="text-center">Comptes</th>
                        <th class="text-end">Solde Total</th>
                        <th class="text-center">Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients_avec_comptes)): ?>
                        <?php foreach ($clients_avec_comptes as $item): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?= esc($item['client']['id_client']) ?></span></td>
                            <td><strong><?= esc($item['client']['nom']) ?></strong></td>
                            <td><?= esc($item['client']['numero_telephone']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($item['client']['date_creation'])) ?></td>
                            <td class="text-center"><span class="badge bg-dark"><?= $item['nombre_comptes'] ?></span></td>
                            <td class="text-end"><strong class="text-primary"><?= number_format($item['solde_total'], 0, ',', ' ') ?></strong></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-dark" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#details-<?= $item['client']['id_client'] ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="collapse mt-2 text-start" id="details-<?= $item['client']['id_client'] ?>">
                                    <?php foreach ($item['comptes'] as $compte): ?>
                                        <small class="d-block">
                                            <span class="badge bg-secondary"><?= esc($compte['operateur_nom'] ?? 'N/A') ?></span>
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