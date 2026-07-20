<?= $this->extend('client/layout') ?>
<?= $this->section('contenu') ?>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h4 mb-3">Mon compte</h2>
        <form method="get" action="/client/compte" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Numéro de téléphone</label>
                <input type="text" name="numero" class="form-control" value="<?= esc($numero ?? '') ?>" placeholder="0331234567">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">Afficher</button>
            </div>
        </form>
    </div>
</div>

<?php if (! empty($utilisateur)) : ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="h5">Résumé</h3>
            <p class="mb-1"><strong>Numéro :</strong> <?= esc($utilisateur['numero']) ?></p>
            <p class="mb-0"><strong>Solde :</strong> <?= number_format((float) $utilisateur['solde'], 2, ',', ' ') ?> Ar</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 mb-3">Historique</h3>
            <?php if (! empty($historique)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Valeur</th>
                            <th>Frais</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($historique as $operation) : ?>
                            <tr>
                                <td><?= esc($operation['date_operation']) ?></td>
                                <td><?= esc($operation['type_nom']) ?></td>
                                <td><?= number_format((float) $operation['valeur'], 2, ',', ' ') ?> Ar</td>
                                <td><?= number_format((float) $operation['frais'], 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert alert-info mb-0">Aucune opération trouvée pour ce compte.</div>
            <?php endif; ?>
        </div>
    </div>
<?php elseif (! empty($numero)) : ?>
    <div class="alert alert-warning">Aucun compte trouvé pour ce numéro.</div>
<?php endif; ?>

<?= $this->endSection() ?>