<?php $title = 'Gestion des préfixes'; ?>
<?= $this->include('admin/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-tags text-primary"></i> Gestion des préfixes</h2>
        <p class="text-muted"><i class="bi bi-info-circle"></i> Configurer les préfixes des opérateurs et les commissions</p>
    </div>
</div>

<!-- Ajout d'un préfixe -->
<div class="card-custom mb-4">
    <div class="card-header">
        <i class="bi bi-plus-circle text-primary"></i> Ajouter un préfixe
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/operateur/store') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-md-5">
                <label class="form-label fw-semibold">
                    <i class="bi bi-building"></i> Nom de l'opérateur
                </label>
                <input type="text" class="form-control form-control-custom" 
                       name="nom" placeholder="Ex: Orange" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="bi bi-hash"></i> Préfixe
                </label>
                <input type="text" class="form-control form-control-custom" 
                       name="prefixe" placeholder="Ex: 032" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des préfixes -->
<div class="card-custom mb-4">
    <div class="card-header">
        <i class="bi bi-list-ul"></i> Liste des préfixes
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-building"></i> Nom</th>
                        <th><i class="bi bi-hash"></i> Préfixe</th>
                        <th class="text-center"><i class="bi bi-tools"></i> Actions</th>
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
                                <a href="<?= base_url('admin/operateur/edit/' . $op['id_operateur']) ?>" 
                                   class="btn btn-sm btn-outline-primary">
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
                        <tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Aucun préfixe configuré</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Configuration des commissions -->
<div class="card-custom">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-percent"></i> Configuration des commissions
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/operateur/commission/store') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="bi bi-arrow-right-circle text-primary"></i> Opérateur Source
                </label>
                <select class="form-select form-select-custom" name="id_operateur_source" required>
                    <option value=""><i class="bi bi-plus"></i> Sélectionner</option>
                    <?php foreach ($operateurs ?? [] as $op): ?>
                        <option value="<?= $op['id_operateur'] ?>"><?= esc($op['nom']) ?> (<?= esc($op['prefixe']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="bi bi-arrow-left-circle text-primary"></i> Opérateur Destination
                </label>
                <select class="form-select form-select-custom" name="id_operateur_destination" required>
                    <option value=""><i class="bi bi-plus"></i> Sélectionner</option>
                    <?php foreach ($operateurs ?? [] as $op): ?>
                        <option value="<?= $op['id_operateur'] ?>"><?= esc($op['nom']) ?> (<?= esc($op['prefixe']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="bi bi-percent text-primary"></i> Commission (%)
                </label>
                <input type="number" class="form-control form-control-custom" 
                       name="pourcentage" step="0.01" value="0" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="bi bi-check-circle"></i> Configurer
                </button>
            </div>
        </form>

        <hr>

        <div class="table-responsive mt-3">
            <table class="table table-custom table-sm">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-building"></i> Source</th>
                        <th><i class="bi bi-building"></i> Destination</th>
                        <th class="text-center"><i class="bi bi-percent"></i> Commission</th>
                        <th class="text-center"><i class="bi bi-tools"></i> Action</th>
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
                        <tr><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Aucune commission configurée</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>