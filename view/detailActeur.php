<?php
ob_start();
?>

<h1>Biographie de l'acteur</h1>

<?php
$acteur = $requeteActeur->fetch() ?>

<img src="<?= $acteur["photoAR"] ?>" alt="">
<p><?= $acteur["nomPrenom"] ?></p>
<p> Né(e) le : <?= $acteur["bday"] ?></p>
<p class="synopsis">Biographie :
<p>
<p><?= $acteur["biographie"] ?></p>




<?php
$titre = "Liste des acteurs";
$content = ob_get_clean();
require "view/template.php"
?>