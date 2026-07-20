<?php $title = 'Gestion des Préfixes'; ?>
<?= $this->include('admin/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-tags text-primary"></i> Gestion des Préfixes</h1>
</div>

<!-- Ajout d'un préfixe -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Ajouter un préfixe</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/operateur/store') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-md-5">
                <label class="form-label fw-bold">
                    <i class="bi bi-building text-primary"></i> Nom de l'opérateur
                </label>
                <input type="text" class="form-control" name="nom" placeholder="Ex: Orange" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">
                    <i class="bi bi-hash text-primary"></i> Préfixe
                </label>
                <input type="text" class="form-control" name="prefixe" placeholder="Ex: 032" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des préfixes -->
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-list-ul"></i> Liste des préfixes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Préfixe</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($operateurs)): ?>
                        <?php foreach ($operateurs as $op): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?= esc($op['id_operateur']) ?></span></td>
                            <td><strong><?= esc($op['nom']) ?></strong></td>
                            <td><span class="badge bg-dark"><?= esc($op['prefixe']) ?></span></td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/operateur/edit/' . $op['id_operateur']) ?>" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/operateur/delete/' . $op['id_operateur']) ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer ce préfixe ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucun préfixe configuré</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Configuration des commissions -->
<div class="card shadow-sm mt-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-percent"></i> Configuration des commissions</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/operateur/commission/store') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-md-4">
                <label class="form-label fw-bold">
                    <i class="bi bi-arrow-right-circle text-primary"></i> Opérateur Source
                </label>
                <select class="form-select" name="id_operateur_source" required>
                    <option value="">Sélectionner</option>
                    <?php foreach ($operateurs ?? [] as $op): ?>
                        <option value="<?= $op['id_operateur'] ?>"><?= esc($op['nom']) ?> (<?= esc($op['prefixe']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">
                    <i class="bi bi-arrow-left-circle text-primary"></i> Opérateur Destination
                </label>
                <select class="form-select" name="id_operateur_destination" required>
                    <option value="">Sélectionner</option>
                    <?php foreach ($operateurs ?? [] as $op): ?>
                        <option value="<?= $op['id_operateur'] ?>"><?= esc($op['nom']) ?> (<?= esc($op['prefixe']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">
                    <i class="bi bi-percent text-primary"></i> Commission (%)
                </label>
                <input type="number" class="form-control" name="pourcentage" step="0.01" value="0" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-circle"></i> Configurer
                </button>
            </div>
        </form>

        <hr>

        <div class="table-responsive mt-3">
            <table class="table table-sm table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th class="text-center">Commission</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($commissions)): ?>
                        <?php foreach ($commissions as $c): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?= esc($c['id_commission']) ?></span></td>
                            <td><?= esc($c['source_nom']) ?> <span class="badge bg-dark"><?= esc($c['source_prefixe']) ?></span></td>
                            <td><?= esc($c['dest_nom']) ?> <span class="badge bg-dark"><?= esc($c['dest_prefixe']) ?></span></td>
                            <td class="text-center"><strong class="text-primary"><?= esc($c['pourcentage']) ?> %</strong></td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/operateur/commission/delete/' . $c['id_commission']) ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer cette commission ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucune commission configurée</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>