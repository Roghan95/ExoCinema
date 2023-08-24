<?php

namespace Controller;

use Model\Connect;

class RoleController
{
    // LIST ROLE
    public function listRole()
    {
        $pdo = connect::seConnecter();
        $requeteListRole = $pdo->query("
     SELECT * FROM role");
        require "view/listRole.php";
    }

    // DETAIL ROLE
    public function detailRole($id)
    {
        $pdo = connect::seConnecter();
        $requeteDetailRole = $pdo->prepare("
     SELECT acteur.id_acteur, film.titre, film.id_film, film.dateSortie, film.afficheFilm,
     role.personnage, CONCAT(personne.prenom, ' ', personne.nom) AS nomPrenom_acteur
     FROM film
     INNER JOIN jouer ON jouer.id_film = film.id_film
     INNER JOIN acteur ON acteur.id_acteur = jouer.id_acteur
     INNER JOIN role ON role.id_role = jouer.id_role
     INNER JOIN personne ON personne.id_personne = acteur.id_personne
     WHERE role.id_role = :id");
        $requeteDetailRole->execute(["id" => $id]);
        require "view/detailRole.php";
    }

    // AJOUT ROLE
    public function addRole()
    {
        $nomRole = filter_input(INPUT_POST, 'nomRole', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($_POST['submit'])) {
            $pdo = connect::seConnecter();
            $requeteAddRole = $pdo->prepare("INSERT INTO role (personnage)
             VALUES (:nomRole)");
            $requeteAddRole->execute(['nomRole' => $nomRole]);
            $newId = $pdo->lastInsertId();
            header("Location:index.php?action=listRole&id=" . $newId);
        }
        require 'view/addRole.php';
    }
}
