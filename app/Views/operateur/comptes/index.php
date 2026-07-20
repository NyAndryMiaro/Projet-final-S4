<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Situation des comptes clients</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<form method="get" action="/operateur/comptes" class="mb-3" style="max-width:400px;">
    <div class="input-group">
        <input type="text" name="numero" class="form-control" placeholder="Rechercher par numéro..." value="<?= esc($numero ?? '') ?>">
        <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
        <?php if (!empty($numero)): ?>
            <a href="/operateur/comptes" class="btn btn-outline-danger">Réinitialiser</a>
        <?php endif; ?>
    </div>
</form>

<table class="table table-bordered bg-white">
    <thead><tr><th>#</th><th>Numéro</th><th>Solde</th></tr></thead>
    <tbody>
        <?php foreach ($utilisateurs as $u): ?>
        <tr>
            <td><?= esc($u['id']) ?></td>
            <td><?= esc($u['numero']) ?></td>
            <td><?= number_format($u['solde'], 2, ',', ' ') ?> Ar</td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($utilisateurs)): ?>
        <tr><td colspan="3" class="text-center text-muted">Aucun client trouvé.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>