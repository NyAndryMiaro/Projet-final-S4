<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gestion des préfixes</h2>
    <a href="/operateur/prefixes/create" class="btn btn-primary">+ Ajouter un préfixe</a>
</div>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<div class="row g-4">
    <!-- Nos Préfixes -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Nos Préfixes (Opérateur Réseau)</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>#</th><th>Préfixe</th><th style="width:140px">Actions</th></tr></thead>
                    <tbody>
                        <?php foreach ($prefixes as $p): ?>
                        <tr>
                            <td><?= esc($p['id']) ?></td>
                            <td><strong><?= esc($p['prefixe']) ?></strong></td>
                            <td>
                                <a href="/operateur/prefixes/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/operateur/prefixes/delete/<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">X</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($prefixes)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Aucun préfixe local.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Autres Opérateurs -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Opérateurs Tiers (Concurrents)</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Opérateur</th><th>Préfixe</th></tr></thead>
                    <tbody>
                        <?php if (!empty($autres_prefixes)): ?>
                            <?php foreach ($autres_prefixes as $ap): ?>
                            <tr>
                                <td><strong><?= esc($ap['nom_operateur']) ?></strong></td>
                                <td><span class="badge bg-secondary"><?= esc($ap['prefixe']) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center text-muted">Aucun opérateur tiers configuré.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>