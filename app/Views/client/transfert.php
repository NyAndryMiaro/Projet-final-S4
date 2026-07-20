<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Transfert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 480px;">
        <div class="card-body p-4">

            <?php if (session()->getFlashdata('erreur')) : ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
            <?php endif ?>

            <?php if (session()->getFlashdata('succes')) : ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('succes')) ?></div>
            <?php endif ?>

            <ul class="nav nav-tabs mb-4" id="transfertTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="simple-tab" data-bs-toggle="tab"
                            data-bs-target="#simple" type="button" role="tab">
                        Transfert simple
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="multiple-tab" data-bs-toggle="tab"
                            data-bs-target="#multiple" type="button" role="tab">
                        Envoi multiple
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="simple" role="tabpanel">

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

                </div>

                <div class="tab-pane fade" id="multiple" role="tabpanel">

                    <form action="<?= site_url('transfert-multiple') ?>" method="post">

                        <div class="mb-3">
                            <label for="montant_total" class="form-label">Montant total à répartir (Ar)</label>
                            <input type="number" min="1" step="1" class="form-control" id="montant_total"
                                   name="montant_total" required>
                            <div class="form-text">
                                Ce montant sera divisé à parts égales entre tous les numéros ci-dessous.
                                Des frais s'ajoutent pour <strong>chaque</strong> destinataire.
                            </div>
                        </div>

                        <label class="form-label">Numéros des destinataires</label>
                        <div id="listeNumeros">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="numeros[]" placeholder="Ex: 0331234567" required>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="numeros[]" placeholder="Ex: 0371112233" required>
                            </div>
                        </div>

                        <button type="button" id="ajouterNumero" class="btn btn-outline-secondary btn-sm mb-3">
                            + Ajouter un destinataire
                        </button>

                        <div class="mb-3">
                            <p class="text-muted mb-0" id="apercuRepartition"></p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirmer l'envoi multiple</button>

                    </form>

                </div>

            </div>

            <a href="/dashboard" class="d-block text-center mt-3">Retour au tableau de bord</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('ajouterNumero').addEventListener('click', function () {
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="numeros[]" placeholder="Ex: 0340000000" required>
            <button type="button" class="btn btn-outline-danger btn-sm supprimerNumero">&times;</button>
        `;
        document.getElementById('listeNumeros').appendChild(div);
        mettreAJourApercu();
    });

    document.getElementById('listeNumeros').addEventListener('click', function (e) {
        if (e.target.classList.contains('supprimerNumero')) {
            e.target.closest('.input-group').remove();
            mettreAJourApercu();
        }
    });

    function mettreAJourApercu() {
        const montantTotal = parseFloat(document.getElementById('montant_total').value) || 0;
        const nbNumeros = document.querySelectorAll('#listeNumeros input[name="numeros[]"]').length;
        const apercu = document.getElementById('apercuRepartition');

        if (montantTotal > 0 && nbNumeros > 0) {
            const part = Math.floor(montantTotal / nbNumeros);
            apercu.textContent = `≈ ${part.toLocaleString('fr-FR')} Ar par destinataire (${nbNumeros} destinataires), hors frais.`;
        } else {
            apercu.textContent = '';
        }
    }

    document.getElementById('montant_total').addEventListener('input', mettreAJourApercu);
</script>

</body>
</html>