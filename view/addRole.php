<?php
ob_start();
?>

<main>
    <h1>Ajouter un rôle</h1>
    <form class="addform" action="index.php?action=addRole" method="post">
        <label for="nomRole">Nom rôle : </label>
        <input id="role" name="nomRole" required />
        <input type="submit" name="submit">
    </form>
</main>


<?php
$titre = "Ajouter un rôle";
$content = ob_get_clean();
require "view/template.php"
?>