<?php
ob_start();

?>

<main>
    <h1>Ajout d'un casting</h1>
    
    <form action="index.php?action=addCasting" method="post">
        <label for="">
            <select name="acteur" id="">
                <option value="" disabled>Liste des acteurs</option>
                <?php foreach ($requeteAllActeurs->fetchAll() as $acteurs) { ?>
                <option value="<?= $acteurs['id_acteur'] ?>"><?= $acteurs['nomPrenom'] ?></option>
                <?php } ?>
            </select>
        </label>

        <label for="">
            <select name="film" id="">
                <option value="" disabled>Liste des films</option>
                <?php foreach ($requeteAllFilms->fetchAll() as $films) { 
                    
                    ?>

                <option value="<?= $films['id_film'] ?>"><?= $films['titre'] ?></option>
                <?php } ?>
            </select>
        </label>

        <label for="">
            <select name="role" id="">
                <option value="" disabled>Liste des acteurs</option>
                <?php foreach ($requeteAllRoles->fetchAll() as $roles) { ?>
                <option value="<?= $roles['id_role'] ?>" selected><?= $roles['personnage'] ?></option>
                <?php } ?>
            </select>
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