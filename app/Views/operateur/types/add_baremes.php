<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Ajouter une tranche de barème</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<form method="post" action="/operateur/types/baremes/add" style="max-width:400px;">
    <?= csrf_field() ?>
    
    <div class="mb-3">
        <label class="form-label">Type d'opération</label>
        <select name="id_type_operation" class="form-select" required>
            <option value="2">Retrait</option>
            <option value="3">Transfert</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Borne inférieure (Ar)</label>
        <input type="number" step="0.01" name="borne_inf" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Borne supérieure (Ar)</label>
        <input type="number" step="0.01" name="borne_sup" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Frais (Ar)</label>
        <input type="number" step="0.01" name="valeur" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="/operateur/types/baremes" class="btn btn-secondary">Annuler</a>
</form>

<?= $this->endSection() ?>