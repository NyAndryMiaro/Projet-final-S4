<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mobile Money - Historique</title>
<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar app-navbar navbar-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Historique</span>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-light btn-logout btn-sm">Retour</a>
    </div>
</nav>

<div class="container pb-5" style="max-width: 900px;">

    <?php if (empty($operations)) : ?>

        <div class="history-card empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 16 16">
                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483zm.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501zm-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
            </svg>
            <p class="mb-0">Aucune operation pour le moment.</p>
        </div>

    <?php else : ?>

        <div class="history-card">
            <div class="table-responsive">
                <table class="table history-table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Sens</th>
                            <th class="text-end">Montant</th>
                            <th class="text-end">Frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($operations as $op) : ?>
                            <?php
                                $estEnvoyeur = (int) $op['envoyeur'] === (int) $idUtilisateur;
                                $sens = $estEnvoyeur ? 'Envoye' : 'Recu';
                                $badgeClass = $estEnvoyeur ? 'badge-envoye' : 'badge-recu';

                                if ($op['type_nom'] === 'depot') {
                                    $sens = 'Depot';
                                    $badgeClass = 'badge-depot';
                                } elseif ($op['type_nom'] === 'retrait') {
                                    $sens = 'Retrait';
                                    $badgeClass = 'badge-retrait';
                                }
                            ?>
                            <tr>
                                <td><?= esc($op['date_operation']) ?></td>
                                <td><?= esc(ucfirst($op['type_nom'])) ?></td>
                                <td><span class="badge-sens <?= $badgeClass ?>"><?= esc($sens) ?></span></td>
                                <td class="text-end amount-cell"><?= number_format($op['valeur'], 0, ',', ' ') ?> Ar</td>
                                <td class="text-end fee-cell"><?= number_format($op['frais'], 0, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif ?>

</div>

</body>
</html>