<?php
ob_start();
?>

<main>
    <?php
    $detailRole = $requeteDetailRole->fetchAll(); ?>

    <?php foreach ($detailRole as $role) { ?>
        <p>Le personnage <?= $role["personnage"] ?> a été jouer par
            <a href="index.php?action=detailActeur&id=<?= $role["id_acteur"] ?>"><?= $role["nomPrenom_acteur"] ?> </a> dans
            <a href="index.php?action=detailFilm&id=<?= $role["id_film"] ?>"><?= $role["titre"] ?></a>
        </p>
    <?php } ?>
</main>
<?php
$titre = "Détails rôle";
$content = ob_get_clean();
require "view/template.php"
?>