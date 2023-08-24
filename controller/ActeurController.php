<?php 

namespace Controller;

use Model\Connect;

class ActeurController {

    // LISTE ACTEURS
    public function listActeurs()
    {
        $pdo = connect::seConnecter();
        $requeteListActeurs = $pdo->prepare("
        SELECT id_acteur, CONCAT(personne.prenom, ' ', personne.nom) AS  nomPrenom
        FROM acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne");
        $requeteListActeurs->execute();
        require "view/listActeurs.php";
    }

    // DETAIL ACTEURS
    public function detailActeur($id)
    {
        $pdo = connect::seConnecter();
        $requeteActeur = $pdo->prepare("
        SELECT id_acteur, photoAR, biographie, CONCAT(personne.prenom, ' ', personne.nom) AS nomPrenom, 
        personne.sexe, DATE_FORMAT(personne.dateNaissance, '%d/%m/%Y') AS bday
        FROM acteur
        INNER JOIN personne ON personne.id_personne = acteur.id_personne
        WHERE acteur.id_acteur = :id");
        $requeteActeur->execute(["id" => $id]);

        $requeteFilmsActeur = $pdo->prepare("
        SELECT jouer.id_acteur, jouer.id_film, jouer.id_role, film.titre AS titre, 
        film.dateSortie, film.afficheFilm AS afficheFilm, role.id_role, role.personnage AS personnage
        FROM jouer
        INNER JOIN film ON jouer.id_film = film.id_film
        INNER JOIN role ON jouer.id_role = role.id_role
        WHERE jouer.id_acteur = :id");
        $requeteFilmsActeur->execute(["id" => $id]);
        require "view/detailActeur.php";
    }

    public function addActeur()
    {

        if (isset($_POST['submit'])) {
            $nomActeur = filter_input(INPUT_POST, 'nomActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenomActeur = filter_input(INPUT_POST, 'prenomActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $sexeActeur = filter_input(INPUT_POST, 'sexeActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $bdayActeur = filter_input(INPUT_POST, 'bdayActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $photoActeur = filter_input(INPUT_POST, 'photoActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $bioActeur = filter_input(INPUT_POST, 'bioActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($nomActeur && $prenomActeur && $sexeActeur && $bdayActeur && $photoActeur && $bioActeur) {
            $pdo = connect::seConnecter();
            $requeteAddActeur = $pdo->prepare("INSERT INTO personne (nom, prenom, sexe, dateNaissance, photoAR, biographie)
            VALUES (:nomActeur, :prenomActeur, :sexeActeur, :bdayActeur, :photoActeur, :bioActeur)");
            $requeteAddActeur->execute([
                'nomActeur' => $nomActeur,
                'prenomActeur' => $prenomActeur,
                'sexeActeur' => $sexeActeur,
                'bdayActeur' => $bdayActeur,
                'photoActeur' => $photoActeur,
                'bioActeur' => $bioActeur
            ]);
            $newIdPersonne = $pdo->lastInsertId();

            $requeteAddActeur2 = $pdo->prepare("INSERT INTO acteur (id_personne)
            VALUES (:idPersonne)");
            $requeteAddActeur2->execute([
                'idPersonne' => $newIdPersonne
            ]);
            header("Location:index.php?action=listActeurs&id=" . $newIdPersonne);
            exit();
        }
    }
        require "view/addActeur.php";
    }

}

?>