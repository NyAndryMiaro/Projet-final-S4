<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Modifier la tranche</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<form method="post" action="/operateur/types/baremes/edit/<?= $bareme['id'] ?>" style="max-width:400px;">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Borne inférieure (Ar)</label>
        <input type="number" step="0.01" name="borne_inf" class="form-control" value="<?= esc($bareme['borne_inf'] ?? $bareme['born_inf']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Borne supérieure (Ar)</label>
        <input type="number" step="0.01" name="borne_sup" class="form-control" value="<?= esc($bareme['borne_sup'] ?? $bareme['born_sup']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Frais (Ar)</label>
        <input type="number" step="0.01" name="valeur" class="form-control" value="<?= esc($bareme['valeur']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="/operateur/types/baremes" class="btn btn-secondary">Annuler</a>
</form>

<?= $this->endSection() ?>