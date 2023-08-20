<?php
ob_start();
$infoGenre = $requeteInfoGenre->fetchAll();
?>

<main>

    <?php
    if (!empty($infoGenre) && isset($infoGenre[0]["nomGenre"])) {
        $nomGenre = $infoGenre[0]["nomGenre"];
    ?>

        <h1><?= $nomGenre ?></h1>
        <?php foreach ($infoGenre as $film) { ?>
            <?php $titre = $film["titre"] ?>
            <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                <img src="<?= $film["afficheFilm"] ?>">
                <p><?= $film["titre"] ?> (<?= $film["dateSortie"] ?>)</p>
            </a>
        <?php
            $nomPrenom_realisateur = $film["nomPrenom_realisateur"];
            echo '<a href="index.php?action=detailRealisateur&id=' . $film["id_realisateur"] . '">' . '</a>';
        } ?>

    <?php
    } else {
        echo "<p>" . "Aucun film de ce genre." . "</p>";
    } ?>

</main>
<?php
$titre = "Information du genre";
$content = ob_get_clean();
require "view/template.php";
?>