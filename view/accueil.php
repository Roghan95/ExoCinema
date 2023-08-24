<?php
ob_start();
?>

<main>
    <div>
        <h1>NEW ITEMS OF THIS SEASON</h1>
    </div>
    <div>
        <?php foreach ($requete->fetchAll() as $film) { ?>
            <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                <img class="afficheFilm" src="<?= $film["afficheFilm"] ?>">
                <h2><?= $film["titre"] ?></h2>
            </a>
            <p>Année : <?= $film["annee"] ?></p>
            <p>Note : <?= $film["noteFilm"] ?></p>
        <?php } ?>
    </div>
</main>

<?php
$titre = "Liste des genres";
$content = ob_get_clean();
require "view/template.php";
?>