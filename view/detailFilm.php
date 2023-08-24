<?php
ob_start();
$film = $requeteDetailFilm->fetch();
$casting = $requeteCasting->fetchAll();

?>


<main>
    <h1 class=""><?= $titreSecondaire = "Détail Film"; ?></h1>
    <div class="card">
        <h2><?= $film["titre"]; ?></h2>
        <img class="afficheFilm" src="<?= $film["affiche"] ?>">
        <div class="card-info">
            <p>Realisateur : <a href="index.php?action=detailRealisateur&id=<?= $film["id_realisateur"] ?>"><?= $film["nomPrenom_realisateur"] ?></a></p>
            <p> Avec :
                <?php foreach ($casting as $acteur) { ?>
                    <a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>">
                        <?= $acteur["nomPrenom"] ?>
                    </a>, dans le rôle de
                    <a href="index.php?action=detailRole&id= <?= $acteur["id_role"] ?>">
                        <?= $acteur["rolePersonnage"] ?><br>
                    </a>
                <?php } ?>
            </p>

            <p>Durée : <?= $film["dureeFilm"] ?></p>
            <p>Date de sortie : <?= $film["annee"] ?></p>

            <?php foreach ($requeteDetailGenre->fetchAll() as $genre) { ?>
                <a href="index.php?action=infoGenre&id=<?= $genre["id_genre"] ?>"><?= $genre["nomGenre"] . "," ?></a>
            <?php } ?>

            <div class="synopsis">SYNOPSIS
                <p><?= $film["synopsis"] ?></p>
            </div>
        </div>
    </div>
</main>

<?php
$titre = "Détail film";
$titreSecondaire = "Détail film";
$content = ob_get_clean();
require "view/template.php";
