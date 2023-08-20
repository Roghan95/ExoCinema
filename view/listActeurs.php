<?php
ob_start();
?>
<main>
    <?php
    foreach ($requeteListActeurs->fetchAll() as $acteur) { ?>
        <a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>"><?= $acteur["nomPrenom"] ?><br></a>
    <?php } ?>
</main>
<?php
$titre = "Liste des acteurs";
$content = ob_get_clean();
require "view/template.php"
?>