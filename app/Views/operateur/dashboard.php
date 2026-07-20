<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<h2 class="mb-4">Vue d'ensemble des gains</h2>

<?php if (! empty($error)) : ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<div class="btn-group mb-4">
    <a href="/operateur/dashboard" class="btn btn-outline-secondary <?= !$periode ? 'active' : '' ?>">Global</a>
    <a href="/operateur/dashboard?periode=jour" class="btn btn-outline-secondary <?= $periode === 'jour' ? 'active' : '' ?>">Jour</a>
    <a href="/operateur/dashboard?periode=semaine" class="btn btn-outline-secondary <?= $periode === 'semaine' ? 'active' : '' ?>">Semaine</a>
    <a href="/operateur/dashboard?periode=mois" class="btn btn-outline-secondary <?= $periode === 'mois' ? 'active' : '' ?>">Mois</a>
</div>

<div class="card" style="max-width: 400px;">
    <div class="card-body text-center">
        <h6 class="text-muted">Total des gains (frais retrait + transfert)</h6>
        <h1 class="display-5"><?= number_format($total_gains, 2, ',', ' ') ?> Ar</h1>
    </div>
</div>

<?= $this->endSection() ?>