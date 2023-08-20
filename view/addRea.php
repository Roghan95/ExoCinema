<?php
ob_start();
?>

<main>
    
</main>

<?php
$titre = "Ajout réalisateur";
$titreSecondaire = "Ajout réalisateur";
$content = ob_get_clean();
require "view/template.php";
?>