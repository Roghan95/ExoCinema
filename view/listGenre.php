<?php
ob_start();
?>

<?php
foreach ($requeteListGenre as $genre) { ?>
    <a href="index.php?action=infoGenre&id=<?php echo $genre["id_genre"] ?>"> <?php echo $genre["nom"]; ?> <br></a>
<?php } ?>


<?php
$titre = "Liste des genres";
$content = ob_get_clean();
require "view/template.php"
?>