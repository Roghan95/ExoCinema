<?php
ob_start();
?>

<?php
foreach ($requeteListRole as $role) { ?>
    <a href="index.php?action=detailRole&id=<?= $role["id_role"] ?>"> <?php echo $role["personnage"]; ?> <br></a>
<?php } ?>


<?php
$titre = "Liste des rôles";
$content = ob_get_clean();
require "view/template.php"
?>