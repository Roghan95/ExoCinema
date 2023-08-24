<?php
ob_start();
?>

<main>

    <?php foreach ($requete->fetchAll() as $film) { ?>
        <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
            <img class="afficheFilm" src="<?= $film["afficheFilm"] ?>">
            <h2><?= $film["titre"] ?></h2>
        </a>
        <p>Année : <?= $film["annee"] ?></p>
        <p>Durée : <?= $film["duree"] ?></p>
        <p>Note : <?= $film["noteFilm"] ?></p>
    <?php } ?>

</main>

<?php
$titre = "Liste des genres";
$content = ob_get_clean();
require "view/template.php";
?>