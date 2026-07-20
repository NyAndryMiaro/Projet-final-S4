<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mobile Money - Tableau de bord</title>
<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar app-navbar navbar-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Mobile Money</span>
        <a href="<?= site_url('/') ?>" class="btn btn-outline-light btn-logout btn-sm">Deconnexion</a>
    </div>
</nav>

<div class="container pb-5" style="max-width: 720px;">

    <?php if (session()->getFlashdata('succes')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('succes')) ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('erreur')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
    <?php endif ?>

    <div class="balance-card text-center mb-4">
        <div class="balance-label mb-2">Solde disponible</div>
        <div class="balance-amount mb-2"><?= esc($solde ?? 0) ?> Ar</div>
        <div class="balance-phone">
            <?= esc($numero ?? 'Numero non specifie') ?>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <a href="<?= site_url('depot') ?>" class="action-tile">
                <div class="action-tile-icon icon-deposit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </div>
                <div class="action-tile-label">Depot</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= site_url('retrait') ?>" class="action-tile">
                <div class="action-tile-icon icon-withdraw">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                        <path d="M4.5 7.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>
                <div class="action-tile-label">Retrait</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= site_url('transfert') ?>" class="action-tile">
                <div class="action-tile-icon icon-transfer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16">
                        <path d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zM15 4.5a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 5H14.5a.5.5 0 0 0 .5-.5z"/>
                    </svg>
                </div>
                <div class="action-tile-label">Transfert</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= site_url('historique') ?>" class="action-tile">
                <div class="action-tile-icon icon-history">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16">
                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483zm.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501zm-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                </div>
                <div class="action-tile-label">Historique</div>
            </a>
        </div>
    </div>