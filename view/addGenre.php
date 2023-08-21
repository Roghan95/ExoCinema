<?php
ob_start();
?>

<main>
    <h1>Ajouter un genre</h1>
    <form class="addform" action="index.php?action=addGenre" method="post">
        <label for="nomGenre">Nom genre : </label>
        <input id="genre" name="nomGenre" required />
        <input type="submit" name="submit">
    </form>
</main>

<?php
$titre = "Ajouter un genre";
$content = ob_get_clean();
require "view/template.php"
?>