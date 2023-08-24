<?php
ob_start();
?>

<main>
    <h1>Biographie de l'acteur</h1>

    <?php
    $acteur = $requeteActeur->fetch() ?>

    <img src="<?= $acteur["photoAR"] ?>" alt="Margot Robbie">
    <p><?= $acteur["nomPrenom"] ?></p>
    <p> Né(e) le : <?= $acteur["bday"] ?></p>
    <p class="synopsis">Biographie :
    <p>
    <p><?= $acteur["biographie"] ?></p>
    <h2>Les films de l'acteur</h2>
    <?php foreach($requeteFilmsActeur->fetchAll() as $filmsActeur) { ?>
        <a href="index.php?action=detailFilm&id=<?= $filmsActeur['id_film'] ?>">
            <img src="<?= $filmsActeur['afficheFilm'] ?>">
            <p><?= $filmsActeur['titre'] ?></p>
        </a>
        <a href="index.php?action=detailRole&id=<?= $filmsActeur['id_role'] ?>">
            <p><?= $filmsActeur['personnage'] ?></p>
        </a>
    <?php } ?>
</main>


<?php
$titre = "Liste des acteurs";
$content = ob_get_clean();
require "view/template.php"
?>