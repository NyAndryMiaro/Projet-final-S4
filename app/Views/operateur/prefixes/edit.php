<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Modifier le préfixe</h2>

<form method="post" action="/operateur/prefixes/edit/<?= $prefixe['id'] ?>" style="max-width:400px;">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Préfixe</label>
        <input type="text" name="prefixe" class="form-control" value="<?= esc($prefixe['prefixe']) ?>" required maxlength="10">
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="/operateur/prefixes" class="btn btn-secondary">Annuler</a>
</form>

<?= $this->endSection() ?>