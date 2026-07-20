<h1>Liste des etudiants</h1>
<ul>
<?php 
foreach($liste as $l){ ?>
<li>Numero : <?= $l['numero'] ?> - Nom : <?= $l['nom'] ?></li>
<?php }
?>
</ul>