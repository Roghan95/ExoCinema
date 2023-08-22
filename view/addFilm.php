<?php
ob_start();

?>

<main>
    <h1>Ajout d'un film</h1>
    
    <form action="index.php?action=addFilm" method="post">
        <label for="titre">
            Titre : 
            <input type="text" name="titre" required>
        </label>

        <label for="dateSortie">
            Date de sortie :
            <input type="date" name="dateSortie" required>
        </label>

        <label for="duree">
            Durée (min) :
            <input type="text" name="duree" required>
        </label>

        <label for="synopsis">
            Synopsis : 
            <textarea name="synopsis" id="synopsis" cols="30" rows="10" required></textarea>
        </label>

        <label for="noteFilm">
            Note : 
            <select name="noteFilm">
                <?php for ($i = 0; $i <= 5; $i++) { ?>
                <option value="<?= $i ?>" required><?= $i ?></option>
                <?php } ?>
            </select>
        </label>

        <label for="afficheFilm">
            Affiche du film : 
            <input type="text" name="afficheFilm" required>
        </label>

        <input class="btn-envoyer" type="submit" name="submit">
    </form>
</main>

<?php
$titre = "Ajouter un film";
$titreSecondaire = "Ajouter un film";
$content = ob_get_clean();
require "view/template.php";
?>