<?php $title = 'Historique des transactions'; ?>
<?= $this->include('client/layouts/header') ?>

<div class="mb-4">
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-clock-history text-primary"></i> 
            Historique - Compte n° <?= esc($compte['id_compte']) ?>
        </h5>
        <p class="text-muted small mb-0">
            <i class="bi bi-phone"></i> <?= esc($compte['numero_telephone']) ?> 
            <span class="mx-2">|</span>
            <i class="bi bi-building"></i> <?= esc($compte['nom'] ?? 'N/A') ?>
        </p>
    </div>
    <div class="card-body">
        <?php if (empty($transactions)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <p class="text-muted"><i class="bi bi-info-circle"></i> Aucune transaction enregistrée pour ce compte.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th><i class="bi bi-calendar3"></i> Date</th>
                            <th><i class="bi bi-tag"></i> Type</th>
                            <th class="text-end"><i class="bi bi-coin"></i> Montant (Ar)</th>
                            <th class="text-end"><i class="bi bi-receipt"></i> Frais (Ar)</th>
                            <th class="text-end"><i class="bi bi-percent"></i> Commission (Ar)</th>
                            <th class="text-center"><i class="bi bi-check-circle"></i> Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td class="text-nowrap">
                                <i class="bi bi-clock"></i> <?= date('d/m/Y H:i', strtotime($t['date_operation'])) ?>
                            </td>
                            <td>
                                <span class="badge 
                                    <?php 
                                        $libelle = strtolower($t['libelle'] ?? '');
                                        if ($libelle == 'dépôt' || $libelle == 'depot') echo 'bg-success';
                                        elseif ($libelle == 'retrait') echo 'bg-danger';
                                        elseif ($libelle == 'transfert') echo 'bg-info text-white';
                                        else echo 'bg-secondary';
                                    ?>">
                                    <?php if ($libelle == 'dépôt' || $libelle == 'depot'): ?>
                                        <i class="bi bi-plus-circle"></i>
                                    <?php elseif ($libelle == 'retrait'): ?>
                                        <i class="bi bi-arrow-down-circle"></i>
                                    <?php elseif ($libelle == 'transfert'): ?>
                                        <i class="bi bi-arrow-left-right"></i>
                                    <?php endif; ?>
                                    <?= esc($t['libelle'] ?? 'N/A') ?>
                                </span>
                            </td>
                            <td class="text-end fw-bold"><?= number_format($t['montant'], 0, ',', ' ') ?></td>
                            <td class="text-end"><?= number_format($t['frais_applique'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-end"><?= number_format($t['commission_appliquee'] ?? 0, 0, ',', ' ') ?></td>
                            <td class="text-center">
                                <span class="badge-status 
                                    <?= strtolower($t['statut']) == 'réussi' ? 'success' : 'danger' ?>">
                                    <?php if (strtolower($t['statut']) == 'réussi'): ?>
                                        <i class="bi bi-check-circle"></i>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle"></i>
                                    <?php endif; ?>
                                    <?= esc($t['statut']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->include('client/layouts/footer') ?>