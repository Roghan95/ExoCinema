<?php
ob_start();
?>

<main>

</main>

<?php
$titre = "Liste des genres";
$content = ob_get_clean();
require "view/template.php"
?>