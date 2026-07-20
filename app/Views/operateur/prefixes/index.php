<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Préfixes opérateur</h2>
    <a href="/operateur/prefixes/create" class="btn btn-primary">+ Ajouter un préfixe</a>
</div>

<table class="table table-bordered bg-white">
    <thead>
        <tr><th>#</th><th>Préfixe</th><th style="width:180px">Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach ($prefixes as $p): ?>
        <tr>
            <td><?= esc($p['id']) ?></td>
            <td><?= esc($p['prefixe']) ?></td>
            <td>
                <a href="/operateur/prefixes/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="/operateur/prefixes/delete/<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce préfixe ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($prefixes)): ?>
        <tr><td colspan="3" class="text-center text-muted">Aucun préfixe configuré.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>