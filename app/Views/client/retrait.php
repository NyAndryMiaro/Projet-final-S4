<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mobile Money - Retrait</title>
<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<div class="auth-shell d-flex align-items-center justify-content-center p-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12" style="max-width: 420px; margin: 0 auto;">

                <div class="auth-card">
                    <div class="auth-card-accent"></div>
                    <div class="p-4 p-md-5">

                        <div class="text-center">
                            <div class="op-icon op-withdraw">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                    <path d="M4.5 7.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </div>
                            <h4 class="fw-bold brand-title mb-1">Faire un retrait</h4>
                            <p class="subtitle small mb-4">Retirez des fonds de votre compte</p>
                        </div>

                        <?php if (session()->getFlashdata('erreur')) : ?>
                            <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
                        <?php endif ?>

                        <form action="<?= site_url('retrait') ?>" method="post">

                            <div class="mb-3 text-start">
                                <label for="montant" class="form-label fw-semibold">Montant</label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        min="1"
                                        step="1"
                                        class="form-control"
                                        id="montant"
                                        name="montant"
                                        placeholder="0"
                                        required
                                        autofocus
                                    >
                                    <span class="input-group-text suffix">Ar</span>
                                </div>
                                <div class="form-text">Des frais seront appliques selon le bareme en vigueur.</div>
                            </div>

                            <button type="submit" class="btn btn-withdraw w-100 fw-semibold">
                                Confirmer le retrait
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="<?= site_url('dashboard') ?>" class="back-link">
                                &larr; Retour au tableau de bord
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>