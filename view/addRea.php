<?php
ob_start();
?>

<main>
    <h1>Ajout réalisateur</h1>
    <form action="index.php?action=addRea" method="post">
        <label for="prenomRea">
            Nom :
            <input type="text" name="nomRea">
        </label>

        <label for="prenomRea">
            Prénom :
            <input type="text" name="prenomRea">
        </label>

        <label for="sexeRea">
            <select name="sexeRea">
                <option>Sexe :</option>
                <option value="h">H</option>
                <option value="f">F</option>
            </select>
        </label>

        <label for="bdayRea">
            Date de naissance :
            <input type="date" name="bdayRea">
        </label>

        <label for="bioRea">
            Biographie :
            <textarea type="text" name="bioRea"></textarea>
        </label>

        <label for="photoRea">
            Photo :
            <input type="text" name="photoRea">
        </label>

        <input class="btn-envoyer" type="submit" name="submit">
    </form>
</main>

<?php
$titre = "Ajouter un réalisateur";
$titreSecondaire = "Ajouter un réalisateur";
$content = ob_get_clean();
require "view/template.php";
?>