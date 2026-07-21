<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Mobile Money</span>
        <a href="/" class="btn btn-outline-light btn-sm">Déconnexion</a>
    </div>
</nav>

<div class="container">
    <div class="card text-center mb-4 shadow-sm">
        <h1>Pourcentage actuel : <?php if($test){echo "Non configure";}else{echo $pourcentage+"%" ;} ?> </h1>
        <div class="card-body">
            <form action="/client/updateEpargne" method="post">
                <input type="number" name="montant" id="" min=0 max=100>
                <input type="submit" value="Choisir ce pourcentage">
            </form>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <a href="/depot" class="btn btn-success w-100 py-3">Dépôt</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/retrait" class="btn btn-warning w-100 py-3">Retrait</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/transfert" class="btn btn-primary w-100 py-3">Transfert</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/historique" class="btn btn-secondary w-100 py-3">Historique</a>
        </div>
    </div>

</div>

</body>
</html>
