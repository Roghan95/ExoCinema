<?php
ob_start();
?>

<main>
    <div class="main-bg">
        <h1 class="titreDePage"><?= $titreSecondaire = "LISTE DES FILMS"; ?></h1>
        <?php
        foreach ($requeteFilms->fetchAll() as $film) { ?>
            <div class="info-film">
                <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                    <img src="<?= $film["afficheFilm"] ?>">
                    <h3><?= $film["titre"] ?></h3>
                </a>
                <p><?= $film["dateSortie"] ?></p>
            </div>
        <?php } ?>
    </div>
</main>
<?php

$titre = "Liste des films";
$content = ob_get_clean();
require "view/template.php";
?>