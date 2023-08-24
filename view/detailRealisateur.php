<?php
ob_start();
?>
<main>
    <h1>Biographie du Réalisateur</h1>

    <?php
    $realisateur = $requeteDetailRealisateur->fetch(); ?>

    <img src="<?= $realisateur["photoAR"] ?>">
    <p><?= $realisateur["nomPrenom"] ?></p>
    <p> Né(e) le : <?= $realisateur["bday"] ?></p>
    <p class="synopsis">Biographie :</p>
    <p><?= $realisateur["biographie"] ?></p>
    <h2>Les films du réalisateur</h2>
    <?php foreach($requeteFilmsRea->fetchAll() as $filmsRea) { ?>
        <a href="index.php?action=detailFilm&id=<?= $filmsRea['id_film'] ?>">
            <img src="<?= $filmsRea['afficheFilm'] ?>" alt="">
            <p><?= $filmsRea['titre'] ?></p>
        </a>
    <?php } ?>
</main>

<?php
$titre = "Biographie du réalisateur";
$content = ob_get_clean();
require "view/template.php"
?>