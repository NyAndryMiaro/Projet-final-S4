<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Historique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Historique</span>
        <a href="/dashboard" class="btn btn-outline-light btn-sm">Retour</a>
    </div>
</nav>

<div class="container">

    <?php if (empty($operations)) : ?>
        <p class="text-muted">Aucune opération pour le moment.</p>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped bg-white shadow-sm">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Sens</th>
                        <th>Montant</th>
                        <th>Frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($operations as $op) : ?>
                        <?php
                            $estEnvoyeur = (int) $op['envoyeur'] === (int) $idUtilisateur;
                            $sens = $estEnvoyeur ? 'Envoyé' : 'Reçu';

                            if ($op['type_nom'] === 'depot') {
                                $sens = 'Dépôt';
                            } elseif ($op['type_nom'] === 'retrait') {
                                $sens = 'Retrait';
                            }
                        ?>
                        <tr>
                            <td><?= esc($op['date_operation']) ?></td>
                            <td></td>
                            <td><?= esc($sens) ?></td>
                            <td><?= number_format($op['valeur'], 0, ',', ' ') ?> Ar</td>
                            <td><?= number_format($op['frais'], 0, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>

</div>

</body>
</html>
