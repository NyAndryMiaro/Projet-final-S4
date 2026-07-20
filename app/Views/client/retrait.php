<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Retrait</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="mb-4">Faire un retrait</h4>

            <?php if (session()->getFlashdata('erreur')) : ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
            <?php endif ?>

            <?= form_open('client/retrait') ?>

                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (Ar)</label>
                    <input type="number" min="1" step="1" class="form-control" id="montant" name="montant" required>
                    <div class="form-text">Des frais seront appliqués selon le barème en vigueur.</div>
                </div>

                <button type="submit" class="btn btn-warning w-100">Confirmer le retrait</button>

            <?= form_close() ?>

            <a href="/client/dashboard" class="d-block text-center mt-3">Retour au tableau de bord</a>
        </div>
    </div>
</div>

</body>
</html>
