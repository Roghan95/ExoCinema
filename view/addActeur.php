<?php
ob_start();
?>

<main>
    <h1>Ajouter un acteur</h1>
    <form action="index.php?action=addActeur" method="post">
        <label for="nomActeur">
            Nom :
            <input type="text" name="nomActeur">
        </label>

        <label for="prenomActeur">
            Prénom :
            <input type="text" name="prenomActeur">
        </label>

        <label for="sexeActeur">
            <select name="sexeActeur">
                <option>Sexe :</option>
                <option value="h">H</option>
                <option value="f">F</option>
            </select>
        </label>

        <label for="bdayActeur">
            Date de naissance :
            <input type="date" name="bdayActeur">
        </label>

        <label for="bioActeur">
            Biographie :
            <textarea type="text" name="bioActeur"></textarea>
        </label>

        <label for="photoActeur">
            Photo :
            <input type="text" name="photoActeur">
        </label>

        <input class="btn-envoyer" type="submit" name="submit">
    </form>
</main>

<?php
$titre = "Ajouter un acteur";
$titreSecondaire = "Ajouter un acteur";
$content = ob_get_clean();
require "view/template.php";
?>