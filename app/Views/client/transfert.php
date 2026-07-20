<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mobile Money - Transfert</title>
<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<div class="auth-shell d-flex align-items-center justify-content-center p-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12" style="max-width: 480px; margin: 0 auto;">

                <div class="transfer-card">
                    <div class="transfer-card-accent"></div>
                    <div class="p-4 p-md-5">

                        <div class="text-center mb-4">
                            <div class="op-icon op-transfer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 16 16">
                                    <path d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zM15 4.5a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 5H14.5a.5.5 0 0 0 .5-.5z"/>
                                </svg>
                            </div>
                            <h4 class="fw-bold brand-title mb-1">Transfert</h4>
                            <p class="subtitle small mb-0">Envoyez de l'argent en toute simplicite</p>
                        </div>

                        <?php if (session()->getFlashdata('erreur')) : ?>
                            <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
                        <?php endif ?>

                        <?php if (session()->getFlashdata('succes')) : ?>
                            <div class="alert alert-success"><?= esc(session()->getFlashdata('succes')) ?></div>
                        <?php endif ?>

                        <ul class="nav transfer-tabs mb-4" id="transfertTabs" role="tablist">
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

                                    <div class="mb-3 text-start">
                                        <label for="numero_destinataire" class="form-label fw-semibold">Numero du destinataire</label>
                                        <input type="text" class="form-control" id="numero_destinataire" name="numero_destinataire"
                                               placeholder="Ex: 0371234567" required>
                                    </div>

                                    <div class="mb-3 text-start">
                                        <label for="montant" class="form-label fw-semibold">Montant</label>
                                        <div class="input-group">
                                            <input type="number" min="1" step="1" class="form-control" id="montant" name="montant" placeholder="0" required>
                                            <span class="input-group-text suffix">Ar</span>
                                        </div>
                                        <div class="form-text">Des frais seront appliques selon le bareme en vigueur.</div>
                                    </div>

                                    <div class="mb-3 form-check text-start">
                                        <input type="checkbox" class="form-check-input" id="confirmer" name="validation">
                                        <label class="form-check-label" for="confirmer">Transfert avec frais</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Confirmer le transfert</button>

                                </form>

                            </div>

                            <div class="tab-pane fade" id="multiple" role="tabpanel">

                                <form action="<?= site_url('transfert-multiple') ?>" method="post">

                                    <div class="mb-3 text-start">
                                        <label for="montant_total" class="form-label fw-semibold">Montant total a repartir</label>
                                        <div class="input-group">
                                            <input type="number" min="1" step="1" class="form-control" id="montant_total"
                                                   name="montant_total" placeholder="0" required>
                                            <span class="input-group-text suffix">Ar</span>
                                        </div>
                                        <div class="form-text">
                                            Ce montant sera divise a parts egales entre tous les numeros ci-dessous.
                                            Des frais s'ajoutent pour chaque destinataire.
                                        </div>
                                    </div>

                                    <label class="form-label fw-semibold text-start d-block">Numeros des destinataires</label>
                                    <div id="listeNumeros">
                                        <div class="input-group mb-2 recipient-row">
                                            <input type="text" class="form-control" name="numeros[]" placeholder="Ex: 0331234567" required>
                                        </div>
                                        <div class="input-group mb-2 recipient-row">
                                            <input type="text" class="form-control" name="numeros[]" placeholder="Ex: 0371112233" required>
                                        </div>
                                    </div>

                                    <button type="button" id="ajouterNumero" class="btn btn-outline-secondary btn-add-recipient btn-sm mb-3">
                                        + Ajouter un destinataire
                                    </button>

                                    <div class="mb-3">
                                        <p class="split-preview mb-0" id="apercuRepartition"></p>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Confirmer l'envoi multiple</button>

                                </form>

                            </div>

                        </div>

                        <div class="text-center mt-4">
                            <a href="<?= site_url('dashboard') ?>" class="back-link">&larr; Retour au tableau de bord</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    // Gestion des onglets sans dependance a bootstrap.bundle.min.js
    document.querySelectorAll('#transfertTabs .nav-link').forEach(function (tabButton) {
        tabButton.addEventListener('click', function () {
            const targetSelector = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetSelector);

            document.querySelectorAll('#transfertTabs .nav-link').forEach(function (btn) {
                btn.classList.remove('active');
            });
            document.querySelectorAll('.tab-content .tab-pane').forEach(function (pane) {
                pane.classList.remove('show', 'active');
            });

            this.classList.add('active');
            targetPane.classList.add('show', 'active');
        });
    });

    document.getElementById('ajouterNumero').addEventListener('click', function () {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 recipient-row';
        div.innerHTML = `
            <input type="text" class="form-control" name="numeros[]" placeholder="Ex: 0340000000" required>
            <button type="button" class="btn btn-outline-danger btn-remove-recipient btn-sm supprimerNumero">&times;</button>
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