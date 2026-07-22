<?php $title = 'Tableau de bord'; ?>
<?= $this->include('client/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Bonjour, <?= session()->get('client_nom') ?? 'Client' ?></h2>
        <p class="text-muted"><i class="bi bi-info-circle"></i> Voici le résumé de votre compte</p>
    </div>
</div>

<div class="card-glass p-4 p-md-5 mb-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 w-25 h-25 bg-primary opacity-10 rounded-circle translate-middle"></div>
    <div class="position-relative">
        <p class="text-muted small text-uppercase mb-1">
            <i class="bi bi-wallet2"></i> Solde disponible
        </p>
        <h2 class="display-4 fw-bold text-primary mb-3">
            <?= number_format($compte['solde'] ?? 0, 0, ',', ' ') ?> Ar
        </h2>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-success-subtle text-success">
                <i class="bi bi-arrow-up"></i> +2.4% ce mois
            </span>
            <small class="text-muted"><i class="bi bi-calendar3"></i> vs mois dernier</small>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-1">
                        <i class="bi bi-phone"></i> <?= esc($compte['nom'] ?? 'N/A') ?>
                    </span>
                    <div class="fw-bold fs-4"><?= number_format($compte['solde'] ?? 0, 0, ',', ' ') ?> Ar</div>
                    <small class="text-muted"><i class="bi bi-sim"></i> <?= esc($compte['numero_telephone'] ?? 'N/A') ?></small>
                </div>
                <span class="badge bg-secondary">Compte #<?= $compte['id_compte'] ?? 'N/A' ?></span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php $compteId = $compte['id_compte'] ?? 1; ?>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('compte/' . $compteId . '/depot') ?>" class="text-decoration-none text-dark">
            <div class="stat-card text-center">
                <div class="icon primary mx-auto mb-2">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div class="fw-semibold">Dépôt</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('compte/' . $compteId . '/retrait') ?>" class="text-decoration-none text-dark">
            <div class="stat-card text-center">
                <div class="icon danger mx-auto mb-2">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div class="fw-semibold">Retrait</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('compte/' . $compteId . '/transfert') ?>" class="text-decoration-none text-dark">
            <div class="stat-card text-center">
                <div class="icon success mx-auto mb-2">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div class="fw-semibold">Transfert</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('compte/' . $compteId . '/historique') ?>" class="text-decoration-none text-dark">
            <div class="stat-card text-center">
                <div class="icon warning mx-auto mb-2">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="fw-semibold">Historique</div>
            </div>
        </a>
    </div>
</div>

<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-list-ul text-primary"></i> Détail du compte
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-building"></i> Opérateur</th>
                        <th><i class="bi bi-sim"></i> Numéro</th>
                        <th class="text-end"><i class="bi bi-coin"></i> Solde (Ar)</th>
                        <th class="text-center"><i class="bi bi-tools"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($compte)): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?= esc($compte['id_compte']) ?></span></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">
                                    <i class="bi bi-phone"></i> <?= esc($compte['nom'] ?? 'N/A') ?>
                                </span>
                            </td>
                            <td><i class="bi bi-sim"></i> <?= esc($compte['numero_telephone']) ?></td>
                            <td class="text-end fw-bold"><?= number_format($compte['solde'], 0, ',', ' ') ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>" 
                                       class="btn btn-outline-primary" title="Solde">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/depot') ?>" 
                                       class="btn btn-outline-success" title="Dépôt">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/retrait') ?>" 
                                       class="btn btn-outline-danger" title="Retrait">
                                        <i class="bi bi-arrow-down-circle"></i>
                                    </a>
                                    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/transfert') ?>" 
                                       class="btn btn-outline-info" title="Transfert">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </a>
                                    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/historique') ?>" 
                                       class="btn btn-outline-secondary" title="Historique">
                                        <i class="bi bi-clock-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Aucun compte trouvé
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('client/layouts/footer') ?>