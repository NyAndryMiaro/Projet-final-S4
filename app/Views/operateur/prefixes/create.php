<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Ajouter un préfixe</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<form method="post" action="/operateur/prefixes/create" style="max-width:400px;">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Préfixe (ex: 033)</label>
        <input type="text" name="prefixe" class="form-control" required maxlength="10">
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="/operateur/prefixes" class="btn btn-secondary">Annuler</a>
</form>

<?= $this->endSection() ?>