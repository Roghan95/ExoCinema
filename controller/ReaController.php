<?php

namespace Controller;

use Model\Connect;

class ReaController
{

    // LIST REALISATEUR
    public function listRealisateur()
    {
        $pdo = connect::seConnecter();
        $requeteRealisateur = $pdo->query("
        SELECT id_realisateur, CONCAT(personne.prenom, ' ', personne.nom) AS  nomPrenom
        FROM realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne");
        require "view/listRealisateur.php";
    }

    // DETAIL REALISATEUR
    public function detailRealisateur($id)
    {
        $pdo = connect::seConnecter();
        $requeteDetailRealisateur = $pdo->prepare("
        SELECT id_realisateur, photoAR, biographie, CONCAT(personne.prenom, ' ', personne.nom) AS nomPrenom , personne.sexe, DATE_FORMAT(personne.dateNaissance, '%d/%m/%Y') AS bday
        FROM realisateur
        INNER JOIN personne ON personne.id_personne = realisateur.id_personne
        WHERE realisateur.id_realisateur = :id");
        $requeteDetailRealisateur->execute(["id" => $id]);

        $requeteFilmsRea = $pdo->prepare
        ("
        SELECT realisateur.id_realisateur, realisateur.id_personne, film.titre AS titre, 
        YEAR(film.dateSortie) AS dateSortie, film.afficheFilm AS afficheFilm,
        TIME_FORMAT(SEC_TO_TIME(film.duree * 60), '%H:%i') AS dureeFilm,
        film.id_film
        FROM realisateur
        INNER JOIN film ON film.id_realisateur = realisateur.id_realisateur
        WHERE film.id_realisateur = :id");
        $requeteFilmsRea->execute(["id" => $id]);
        require "view/detailRealisateur.php";
    }
    // -------------------------------- AJOUT --------------------------------------

    // AJOUT REALISATEUR
    public function addRea()
    {
        $nomRea = filter_input(INPUT_POST, 'nomRea', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenomRea = filter_input(INPUT_POST, 'prenomRea', FILTER_SANITIZE_SPECIAL_CHARS);
        $sexeRea = filter_input(INPUT_POST, 'sexeRea', FILTER_SANITIZE_SPECIAL_CHARS);
        $bdayRea = filter_input(INPUT_POST, 'bdayRea', FILTER_SANITIZE_SPECIAL_CHARS);
        $photoRea = filter_input(INPUT_POST, 'photoRea', FILTER_SANITIZE_SPECIAL_CHARS);
        $bioRea = filter_input(INPUT_POST, 'bioRea', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($_POST['submit'])) {
            $pdo = connect::seConnecter();
            $requeteAddRea1 = $pdo->prepare("INSERT INTO personne (nom, prenom, sexe, dateNaissance, photoAR, biographie)
            VALUES (:nomRea, :prenomRea, :sexeRea, :bdayRea, :photoRea, :bioRea)");
            $requeteAddRea1->execute([
                'nomRea' => $nomRea,
                'prenomRea' => $prenomRea,
                'sexeRea' => $sexeRea,
                'bdayRea' => $bdayRea,
                'photoRea' => $photoRea,
                'bioRea' => $bioRea
            ]);
            $newIdPersonne = $pdo->lastInsertId();

            $requeteAddRea2 = $pdo->prepare("INSERT INTO realisateur (id_personne)
            VALUES (:idPersonne)");
            $requeteAddRea2->execute([
                'idPersonne' => $newIdPersonne
            ]);
            header("Location:index.php?action=listRealisateur&id=" . $newIdPersonne);
        }
        require "view/addRea.php";
    }
}