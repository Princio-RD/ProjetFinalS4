<?php $title = 'Retrait'; ?>
<?= $this->include('client/layouts/header') ?>

<div class="mb-4">
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="icon-circle danger mx-auto mb-3" style="width:70px;height:70px;font-size:2rem;background:rgba(186,26,26,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#ba1a1a;">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>
                    <h4 class="fw-bold"><i class="bi bi-arrow-down-circle text-danger"></i> Faire un retrait</h4>
                    <p class="text-muted"><i class="bi bi-wallet2"></i> Compte n° <?= esc($compte['id_compte']) ?></p>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Solde disponible : <strong><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</strong>
                    <br><small><i class="bi bi-info-circle"></i> Des frais de retrait sont appliqués selon le barème en vigueur.</small>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/retrait') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-coin"></i> Montant à retirer (Ar)
                        </label>
                        <input type="number" class="form-control form-control-custom" 
                               name="montant" step="0.01" min="0.01" 
                               placeholder="Ex: 5000" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger py-3">
                            <i class="bi bi-check-circle"></i> Confirmer le retrait
                        </button>
                        <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>" 
                           class="btn btn-outline-secondary text-center">
                            <i class="bi bi-x-circle"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('client/layouts/footer') ?>