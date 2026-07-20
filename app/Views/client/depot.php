<?php $title = 'Dépôt'; ?>
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
                    <div class="icon-circle blue mx-auto mb-3" style="width:70px;height:70px;font-size:2rem;background:rgba(30,64,175,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#1e40af;">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h4 class="fw-bold"><i class="bi bi-plus-circle text-success"></i> Faire un dépôt</h4>
                    <p class="text-muted"><i class="bi bi-wallet2"></i> Compte n° <?= esc($compte['id_compte']) ?></p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/depot') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-coin"></i> Montant à déposer (Ar)
                        </label>
                        <input type="number" class="form-control form-control-custom" 
                               name="montant" step="0.01" min="0.01" 
                               placeholder="Ex: 10000" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom py-3">
                            <i class="bi bi-check-circle"></i> Confirmer le dépôt
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