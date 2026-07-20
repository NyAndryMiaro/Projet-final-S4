<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Modifier la tranche</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<form method="post" action="/operateur/types/baremes/edit/<?= $bareme['id'] ?>" style="max-width:400px;">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Borne inférieure</label>
        <input type="number" step="0.01" name="born_inf" class="form-control" value="<?= esc($bareme['born_inf']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Borne supérieure</label>
        <input type="number" step="0.01" name="born_sup" class="form-control" value="<?= esc($bareme['born_sup']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Frais</label>
        <input type="number" step="0.01" name="valeur" class="form-control" value="<?= esc($bareme['valeur']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="/operateur/types/baremes" class="btn btn-secondary">Annuler</a>
</form>

<?= $this->endSection() ?>