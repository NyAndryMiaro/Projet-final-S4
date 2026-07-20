<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/client/compte">MobileMoney - Client</a>
        <div class="navbar-nav">
            <a class="nav-link" href="/client/compte">Compte</a>
            <a class="nav-link" href="/client/depot">Dépôt</a>
            <a class="nav-link" href="/client/retrait">Retrait</a>
            <a class="nav-link" href="/client/transfert">Transfert</a>
            <a class="nav-link" href="/client/historique">Historique</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <?php if (! empty($error)) : ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('contenu') ?>
</div>
</body>
</html>