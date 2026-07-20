<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="text-center mb-4">Mobile Money</h4>

            <?php if (session()->getFlashdata('erreur')) : ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('erreur')) ?>
                </div>
            <?php endif ?>

            <?= form_open('client/login') ?>

                <div class="mb-3">
                    <label for="numero" class="form-label">Numero de telephone</label>
                    <input
                        type="text"
                        class="form-control"
                        id="numero"
                        name="numero"
                        placeholder="Ex: 0331234567"
                        value="<?= esc(old('numero')) ?>"
                        required
                        pattern="0[0-9]{9}"
                        title="Format attendu : 0XXXXXXXXX"
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100">Se connecter</button>

            <?= form_close() ?>

            <p class="text-muted text-center mt-3" style="font-size: 0.85rem;">
                Si votre numero n'est pas encore enregistre, un compte sera creer automatiquement.
            </p>
        </div>
    </div>
</div>

</body>
</html>
