<?= $this->extend('operateur/layout') ?>
<?= $this->section('contenu') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Barème des frais</h2>
    <a href="/operateur/types/baremes/add" class="btn btn-primary">+ Ajouter une tranche</a>
</div>

<p class="text-muted">Ce barème s'applique aux opérations de retrait et de transfert selon le montant.</p>

<table class="table table-bordered bg-white">
    <thead>
        <tr><th>#</th><th>Borne inf.</th><th>Borne sup.</th><th>Frais</th><th style="width:180px">Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach ($baremes as $b): ?>
        <tr>
            <td><?= esc($b['id']) ?></td>
            <td><?= number_format($b['born_inf'], 0, ',', ' ') ?></td>
            <td><?= number_format($b['born_sup'], 0, ',', ' ') ?></td>
            <td><?= number_format($b['valeur'], 0, ',', ' ') ?> Ar</td>
            <td>
                <a href="/operateur/types/baremes/edit/<?= $b['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="/operateur/types/baremes/delete/<?= $b['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette tranche ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>