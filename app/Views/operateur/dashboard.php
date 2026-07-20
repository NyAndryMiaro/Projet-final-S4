<?= $this->extend('operateur/layout') ?>

<?= $this->section('contenu') ?>

<div class="container-fluid px-2 py-3">

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= esc($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- En-tête de page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-dark font-weight-bold">Tableau de Bord</h2>
            <p class="text-muted mb-0">Vue d'ensemble des frais locaux et des situations inter-opérateurs</p>
        </div>
    </div>

    <!-- SECTION 1 : Situation Gain via les différents frais -->
    <h5 class="text-secondary mb-3"><i class="bi bi-pie-chart-fill me-2"></i>Situation des gains</h5>
    
    <div class="row g-3 mb-4">
        <!-- Gains locaux -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-primary border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted fw-bold small">Gains Opérateur Local</div>
                            <div class="fs-3 fw-bold text-primary mt-1"><?= number_format($gains_locaux, 2, ',', ' ') ?> Ar</div>
                            <small class="text-muted">Frais des transactions internes</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="bi bi-arrow-down-left-circle fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commissions Tiers -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-info border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted fw-bold small">Commissions Inter-Opérateurs</div>
                            <div class="fs-3 fw-bold text-info mt-1"><?= number_format($gains_inter_operateurs, 2, ',', ' ') ?> Ar</div>
                            <small class="text-muted">Part prélevée (<?= esc($pourcentage_commission) ?>%)</small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="bi bi-percent fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cumulé -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-white-50 fw-bold small">Gain Total Cumulé</div>
                            <div class="fs-3 fw-bold mt-1"><?= number_format($total_gains, 2, ',', ' ') ?> Ar</div>
                            <small class="text-white-50">Local + Commissions inter-opérateurs</small>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-circle text-white">
                            <i class="bi bi-cash-stack fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2 : Situation des montants à envoyer à chaque opérateur -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h5 class="card-title mb-0 text-dark fw-bold">
                <i class="bi bi-arrow-left-right me-2 text-primary"></i>Situation des montants à envoyer aux opérateurs tiers
            </h5>
            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                Taux Commission : <?= esc($pourcentage_commission) ?> %
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th class="ps-4">Opérateur Tiers</th>
            <th>Préfixe</th>
            <th class="text-center">Nb Envois</th>
            <th class="text-end">Montant Total Envoyé</th>
            <th class="text-end">Commission Due Tiers</th>
            <th class="text-end pe-4">Total à Reverser</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($situation_operateurs)): ?>
            <?php foreach ($situation_operateurs as $op): ?>
                <tr>
                    <td class="ps-4 fw-bold text-dark"><?= esc($op['nom_operateur']) ?></td>
                    <td><span class="badge bg-secondary px-2 py-1"><?= esc($op['prefixe']) ?></span></td>
                    <td class="text-center fw-semibold"><?= esc($op['nb_operations']) ?></td>
                    <td class="text-end fw-semibold"><?= number_format($op['total_envoye'], 2, ',', ' ') ?> Ar</td>
                    <td class="text-end text-warning fw-bold">+ <?= number_format($op['commission_due'], 2, ',', ' ') ?> Ar</td>
                    <!-- Montant principal + commission que nous devons payer à l'autre -->
                    <td class="text-end text-danger fw-bold pe-4"><?= number_format($op['net_a_reverser'], 2, ',', ' ') ?> Ar</td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>