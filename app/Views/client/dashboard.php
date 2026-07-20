<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Mobile Money</span>
        <a href="/" class="btn btn-outline-light btn-sm">Déconnexion</a>
    </div>
</nav>

<div class="container">

    <?php if (session()->getFlashdata('succes')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('succes')) ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('erreur')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
    <?php endif ?>

    <div class="card text-center mb-4 shadow-sm">
        <div class="card-body">
            <h5> Solde actuel : <?= esc($solde['solde'] ?? 0) ?> Ar</h5>
            <p class="text-muted">Numéro de téléphone : <?= esc($numero ?? 'Non spécifié') ?></p>
            <p class="text-muted">Solde disponible</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <a href="/depot" class="btn btn-success w-100 py-3">Dépôt</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/retrait" class="btn btn-warning w-100 py-3">Retrait</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/transfert" class="btn btn-primary w-100 py-3">Transfert</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/historique" class="btn btn-secondary w-100 py-3">Historique</a>
        </div>
    </div>

</div>

</body>
</html>
