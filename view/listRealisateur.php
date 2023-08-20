<?php
ob_start();
?>

<?php
foreach ($requeteRealisateur->fetchAll() as $realisateur) { ?>
    <a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_realisateur"] ?>"><?= $realisateur["nomPrenom"] ?><br></a>
<?php } ?>


<?php
$titre = "Liste des realisateur";
$content = ob_get_clean();
require "view/template.php"
?>