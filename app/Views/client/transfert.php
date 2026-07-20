<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Transfert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="mb-4">Faire un transfert</h4>

            <?php if (session()->getFlashdata('erreur')) : ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
            <?php endif ?>

            <form action="<?= site_url('transfert') ?>" method="post">

                <div class="mb-3">
                    <label for="numero_destinataire" class="form-label">Numéro du destinataire</label>
                    <input type="text" class="form-control" id="numero_destinataire" name="numero_destinataire"
                           placeholder="Ex: 0371234567" required>
                </div>

                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (Ar)</label>
                    <input type="number" min="1" step="1" class="form-control" id="montant" name="montant" required>
                    <div class="form-text">Des frais seront appliqués selon le barème en vigueur.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Confirmer le transfert</button>

            </form>

            <a href="/dashboard" class="d-block text-center mt-3">Retour au tableau de bord</a>
        </div>
    </div>
</div>

</body>
</html>
