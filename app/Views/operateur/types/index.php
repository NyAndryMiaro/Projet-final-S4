<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Types d'opération</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<table class="table table-bordered bg-white" style="max-width:500px;">
    <thead><tr><th>#</th><th>Nom</th></tr></thead>
    <tbody>
        <?php foreach ($types as $t): ?>
        <tr>
            <td><?= esc($t['id']) ?></td>
            <td><?= esc($t['nom']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="/operateur/types/baremes" class="btn btn-primary">Gérer le barème des frais (retrait / transfert)</a>

<?= $this->endSection() ?>