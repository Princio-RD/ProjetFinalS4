<?php $title = 'Transfert'; ?>
<?= $this->include('client/layouts/header') ?>

<div class="mb-4">
    <a href="<?= base_url('compte/' . $compte['id_compte'] . '/solde') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="icon-circle success mx-auto mb-3" style="width:70px;height:70px;font-size:2rem;background:rgba(0,108,73,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#006c49;">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <h4 class="fw-bold"><i class="bi bi-arrow-left-right text-success"></i> Transfert d'argent</h4>
                    <p class="text-muted"><i class="bi bi-wallet2"></i> Compte source n° <?= esc($compte['id_compte']) ?></p>
                    <p class="text-muted small">
                        <i class="bi bi-coin"></i> Solde : <strong><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</strong>
                    </p>
                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-info-circle"></i>
                    <strong>Même opérateur uniquement</strong>
                    <br><small><i class="bi bi-info-circle"></i> Les transferts multiples ne sont autorisés qu'entre comptes du même opérateur.</small>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('compte/' . $compte['id_compte'] . '/transfert') ?>">
                    <?= csrf_field() ?>
                    
                    <div id="destinataires-container">
                        <div class="destinataire-row border rounded-3 p-3 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-phone"></i> Numéro du destinataire
                                    </label>
                                    <input type="tel" class="form-control form-control-custom" 
                                           name="telephone_destination[]" 
                                           placeholder="Ex: 0321562072" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-coin"></i> Montant (Ar)
                                    </label>
                                    <input type="number" class="form-control form-control-custom" 
                                           name="montant[]" step="0.01" min="0.01" 
                                           placeholder="0" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-destinataire w-100">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="ajouter-destinataire">
                        <i class="bi bi-plus-circle"></i> Ajouter un destinataire
                    </button>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary-custom py-3">
                            <i class="bi bi-check-circle"></i> Confirmer le transfert
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

<script>
document.getElementById('ajouter-destinataire')?.addEventListener('click', function() {
    const container = document.getElementById('destinataires-container');
    const row = document.querySelector('.destinataire-row').cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(row);
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-destinataire')) {
        const rows = document.querySelectorAll('.destinataire-row');
        if (rows.length > 1) {
            e.target.closest('.destinataire-row').remove();
        } else {
            alert('Vous devez avoir au moins un destinataire.');
        }
    }
});
</script>

<?= $this->include('client/layouts/footer') ?>