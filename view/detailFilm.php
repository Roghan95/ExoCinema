<?php
ob_start();
$film = $requeteDetailFilm->fetchAll();
?>


<main>
    <h1 class="titreDePage"><?= $titreSecondaire = "DETAIL FILM"; ?></h1>
    <div class="card">
        <h2><?= $film[0]["titre"]; ?></h2>
        <img class="afficheFilm" src="<?= $film[0]["affiche"] ?>">
        <div class="card-info">
            <p>Realisateur : <a href="index.php?action=detailRealisateur&id=<?= $film[0]["id_realisateur"] ?>"><?= $film[0]["nomPrenom_realisateur"] ?></a></p>
            <p> Avec :
                <?php foreach ($film as $acteur) { ?>
                    <a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>">
                        <?= $acteur["nomPrenom_acteur"] ?>
                    </a>, dans le rôle de
                    <a href="index.php?action=detailRole&id= <?= $acteur["id_role"] ?>">
                        <?= $acteur["rolePersonnage"] ?><br>
                    </a>
                <?php } ?>
            </p>

            <p>Durée : <?= $film[0]["dureeFilm"] ?></p>
            <p>Date de sortie : <?= $film[0]["annee"] ?></p>

            <?php foreach ($requeteDetailGenre->fetchAll() as $genre) { ?>
                <a href="index.php?action=infoGenre&id=<?= $genre["id_genre"] ?>"><?= $genre["nomGenre"] . "," ?></a>
            <?php } ?>

            <div class="synopsis">SYNOPSIS
                <p><?= $film[0]["synopsis"] ?></p>
            </div>
        </div>
    </div>
</main>

<?php
$titre = "Détail film";
$titreSecondaire = "Détail film";
$content = ob_get_clean();
require "view/template.php";
