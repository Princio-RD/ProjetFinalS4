<?php $title = 'Solde du compte'; ?>
<?= $this->include('client/layouts/header') ?>

<div class="mb-4">
    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5 text-center">
        <div class="mb-3">
            <span class="badge bg-primary-subtle text-primary fs-6 px-4 py-2">
                <i class="bi bi-wallet2"></i> Compte n° <?= esc($compte['id_compte']) ?>
            </span>
        </div>
        
        <p class="text-muted small text-uppercase mb-1">
            <i class="bi bi-coin"></i> Solde actuel
        </p>
        <h2 class="display-3 fw-bold text-primary"><?= esc($solde) ?> Ar</h2>
        
        <p class="text-muted mt-3">
            <i class="bi bi-phone"></i> <?= esc($compte['numero_telephone']) ?>
            <span class="mx-2">|</span>
            <span class="badge bg-light text-dark">
                <i class="bi bi-building"></i> <?= esc($compte['nom'] ?? 'N/A') ?>
            </span>
        </p>

        <hr class="my-4">

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="<?= base_url('compte/' . $compte['id_compte'] . '/depot') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Dépôt
            </a>
            <a href="<?= base_url('compte/' . $compte['id_compte'] . '/retrait') ?>" class="btn btn-danger">
                <i class="bi bi-arrow-down-circle"></i> Retrait
            </a>
            <a href="<?= base_url('compte/' . $compte['id_compte'] . '/transfert') ?>" class="btn btn-info text-white">
                <i class="bi bi-arrow-left-right"></i> Transfert
            </a>
            <a href="<?= base_url('compte/' . $compte['id_compte'] . '/historique') ?>" class="btn btn-secondary">
                <i class="bi bi-clock-history"></i> Historique
            </a>
        </div>
    </div>
</div>

<?= $this->include('client/layouts/footer') ?>