<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Ajouter un préfixe</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<form method="post" action="/operateur/prefixes/create" style="max-width:400px;">
    <?= csrf_field() ?>
    
    <div class="mb-3">
        <label class="form-label">Type d'opérateur</label>
        <select name="type_prefixe" id="type_prefixe" class="form-select" onchange="toggleOperateurField(this.value)">
            <option value="interne">Notre Opérateur</option>
            <option value="externe">Opérateur Tiers (Orange, Telma, etc.)</option>
        </select>
    </div>

    <div class="mb-3 d-none" id="field_nom_operateur">
        <label class="form-label">Nom de l'opérateur tiers</label>
        <input type="text" name="nom_operateur" class="form-control" placeholder="ex: Orange">
    </div>

    <div class="mb-3">
        <label class="form-label">Préfixe (ex: 033, 032)</label>
        <input type="text" name="prefixe" class="form-control" required maxlength="5" placeholder="033">
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="/operateur/prefixes" class="btn btn-secondary">Annuler</a>
</form>

<script>
function toggleOperateurField(val) {
    const field = document.getElementById('field_nom_operateur');
    if (val === 'externe') {
        field.classList.remove('d-none');
    } else {
        field.classList.add('d-none');
    }
}
</script>

<?= $this->endSection() ?>