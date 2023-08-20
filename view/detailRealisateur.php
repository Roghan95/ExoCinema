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


</main>

<?php
$titre = "Biographie du réalisateur";
$content = ob_get_clean();
require "view/template.php"
?>