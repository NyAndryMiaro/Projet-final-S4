<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Opérateur - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajout des icônes Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/operateur/dashboard">MobileMoney - Opérateur</a>
        <div class="navbar-nav">
            <a class="nav-link" href="/operateur/dashboard">Dashboard</a>
            <a class="nav-link" href="/operateur/config">Configuration</a>
            <a class="nav-link" href="/operateur/prefixes">Préfixes Locaux</a>
            <a class="nav-link" href="/operateur/types">Types & Barèmes</a>
            <a class="nav-link" href="/operateur/comptes">Comptes clients</a>
            <a class="nav-link" href="/operateur/dim">Modifier diminuation frais</a>
            <a class="nav-link" href="/">Déconnexion</a>
        </div>
    </div>
</nav>
<div class="container">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('contenu') ?>
</div>
</body>
</html>