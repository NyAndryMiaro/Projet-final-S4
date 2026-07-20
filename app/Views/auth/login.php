<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mobile Money - Connexion</title>
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
                            <div class="login-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#2f6690" viewBox="0 0 16 16">
                                    <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                    <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                </svg>
                            </div>
                            <h4 class="fw-bold brand-title mb-1">Mobile Money</h4>
                            <p class="subtitle small mb-4">Connectez-vous avec votre numero de telephone</p>
                        </div>

                        <form action="<?= site_url('auth/login') ?>" method="post">

                            <div class="mb-3 text-start">
                                <label for="numero" class="form-label fw-semibold">Numero de telephone</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="#6b7a86" viewBox="0 0 16 16">
                                            <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                        </svg>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="numero"
                                        name="numero"
                                        placeholder="Ex: 0331234567"
                                        value="<?= esc(old('numero')) ?>"
                                        required
                                        pattern="033[0-9]{7}"
                                        autofocus
                                    >
                                </div>
                                <div class="form-text">Format attendu : 033 XXX XXX</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-semibold">
                                Se connecter
                            </button>

                            <p class="text-muted text-center small mt-3 mb-0" style="font-size: 0.8rem;">
                                Si votre numero n'est pas encore enregistre, un compte sera cree automatiquement.
                            </p>
                        </form>

                        <div class="divider">ou</div>

                        <a href="<?= site_url('operateur/dashboard') ?>" class="btn btn-outline-secondary w-100 fw-semibold">
                            Connexion operateur
                        </a>

                    </div>
                </div>

                <p class="text-center footer-note small mt-3 mb-0">
                    &copy; <?= date('Y') ?> Mobile Money. Tous droits reserves.
                </p>

            </div>
        </div>
    </div>
</div>

</body>
</html>