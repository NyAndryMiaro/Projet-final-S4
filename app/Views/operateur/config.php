<?= $this->extend('operateur/layout') ?>

<?= $this->section('contenu') ?>

<div class="container-fluid py-3">

    <div class="mb-4">
        <h2 class="h3 mb-0 text-dark font-weight-bold">Configuration Inter-Opérateurs</h2>
        <p class="text-muted">Gérez le taux de commission prélevé et les préfixes des opérateurs concurrents.</p>
    </div>

    <div class="row g-4">
        
        <!-- SECTION 1 : Taux de Commission -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="bi bi-percent me-2"></i>Commission Inter-Opérateur
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('operateur/config/commission') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="pourcentage" class="form-label fw-semibold">Pourcentage de commission (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100" class="form-control" id="pourcentage" name="pourcentage" value="<?= esc($pourcentage) ?>" required>
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="form-text text-muted">
                                Ce pourcentage sera appliqué sur le montant total des transferts effectués vers d'autres opérateurs.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            Enregistrer le pourcentage
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- SECTION 2 : Préfixes des autres opérateurs -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-telephone me-2"></i>Préfixes Opérateurs Tiers
                    </h5>
                </div>
                <div class="card-body">
                    
                    <!-- Formulaire d'ajout rapide -->
                    <form action="<?= base_url('operateur/config/prefixe/add') ?>" method="post" class="row g-2 mb-4">
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <input type="text" name="nom_operateur" class="form-control" placeholder="Opérateur (ex: Orange, Telma)" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="prefixe" class="form-control" placeholder="Préfixe (ex: 032)" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100" title="Ajouter">+</button>
                        </div>
                    </form>

                    <!-- Table des préfixes -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom Opérateur</th>
                                    <th>Préfixe</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($autres_prefixes)): ?>
                                    <?php foreach ($autres_prefixes as $p): ?>
                                        <tr>
                                            <td class="fw-bold"><?= esc($p['nom_operateur']) ?></td>
                                            <td><span class="badge bg-info text-dark px-2 py-1"><?= esc($p['prefixe']) ?></span></td>
                                            <td class="text-end">
                                                <a href="<?= base_url('operateur/config/prefixe/delete/' . $p['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Supprimer ce préfixe ?');">
                                                    Supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">Aucun autre opérateur configuré.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>