<?php
ob_start();
?>

<main>
    <div class="home-title">
        <h1>NEW ITEMS OF THIS SEASON</h1>
    </div>
    <div class="card-film">
        <?php foreach ($requete->fetchAll() as $film) { ?>
            <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                <img class="afficheFilm" src="<?= $film["afficheFilm"] ?>">
            </a>
            <div class="info-film">
                <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?= $film["titre"] ?></a>
                <p>Année : <?= $film["annee"] ?></p>
                <p>Note : <?= $film["noteFilm"] ?></p>
            </div>
        <?php } ?>
    </div>
</main>

<?php
$titre = "Liste des genres";
$content = ob_get_clean();
require "view/template.php";
?>