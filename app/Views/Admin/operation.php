<?php $title = 'Gestion des Opérations'; ?>
<?= $this->include('admin/layouts/header') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-gear text-primary"></i> Gestion des Opérations</h1>
</div>

<div class="row">
    <!-- Types d'opérations -->
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Types d'opérations</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/operation/store') ?>" method="post" class="mb-3">
                    <?= csrf_field() ?>
                    <div class="input-group">
                        <input type="text" class="form-control" name="libelle" placeholder="Ex: Achat" required>
                        <button class="btn btn-dark" type="submit">
                            <i class="bi bi-plus-circle"></i> Ajouter
                        </button>
                    </div>
                </form>
                <ul class="list-group list-group-flush">
                    <?php if (!empty($operations)): ?>
                        <?php foreach ($operations as $op): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <span class="badge bg-dark me-2">#<?= esc($op['id_type_operation']) ?></span>
                                <?= esc($op['libelle']) ?>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucun type d'opération
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Barèmes de frais -->
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-coin"></i> Barèmes de frais</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/operation/tarif') ?>" method="post" class="row g-2 mb-3">
                    <?= csrf_field() ?>
                    <div class="col-4">
                        <select class="form-select form-select-sm" name="id_type_operation" required>
                            <option value="">Type</option>
                            <?php foreach ($operations ?? [] as $op): ?>
                                <option value="<?= esc($op['id_type_operation']) ?>"><?= esc($op['libelle']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control form-control-sm" name="montant_min" placeholder="Min" required>
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control form-control-sm" name="montant_max" placeholder="Max" required>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary w-100 btn-sm" type="submit">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Type</th>
                                <th class="text-end">Min</th>
                                <th class="text-end">Max</th>
                                <th class="text-end">Frais</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tarifs)): ?>
                                <?php foreach ($tarifs as $t): ?>
                                <tr>
                                    <td><span class="badge bg-dark"><?= esc($t['libelle']) ?></span></td>
                                    <td class="text-end"><?= number_format($t['montant_min'], 0, ',', ' ') ?></td>
                                    <td class="text-end"><?= number_format($t['montant_max'], 0, ',', ' ') ?></td>
                                    <td class="text-end"><strong class="text-primary"><?= number_format($t['frais'], 0, ',', ' ') ?></strong></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/operation/tarif/delete/' . $t['id_bareme']) ?>" 
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Supprimer ce barème ?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Aucun barème configuré
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>