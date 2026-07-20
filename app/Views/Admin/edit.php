<?php $title = 'Modifier un préfixe'; ?>
<?= $this->include('admin/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-pencil text-primary"></i> Modifier un préfixe</h2>
        <p class="text-muted"><i class="bi bi-info-circle"></i> Modifier les informations de l'opérateur</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-pencil-square text-primary"></i> Modifier l'opérateur #<?= $operateur['id_operateur'] ?>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/operateur/update/' . $operateur['id_operateur']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-building"></i> Nom de l'opérateur
                        </label>
                        <input type="text" class="form-control form-control-custom" 
                               name="nom" value="<?= esc($operateur['nom']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-hash"></i> Préfixe
                        </label>
                        <input type="text" class="form-control form-control-custom" 
                               name="prefixe" value="<?= esc($operateur['prefixe']) ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </button>
                        <a href="<?= base_url('admin/operateur') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-list-ul"></i> Liste des préfixes
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach ($operateurs as $op): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary">#<?= $op['id_operateur'] ?></span>
                            <strong><?= esc($op['nom']) ?></strong>
                            <span class="badge bg-dark"><?= esc($op['prefixe']) ?></span>
                        </div>
                        <div>
                            <a href="<?= base_url('admin/operateur/edit/' . $op['id_operateur']) ?>" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url('admin/operateur/delete/' . $op['id_operateur']) ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Supprimer ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>