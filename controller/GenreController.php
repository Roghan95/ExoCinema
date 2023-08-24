<?php

namespace Controller;

use Model\Connect;

class GenreController
{
    // LIST GENRE
    public function listGenre()
    {
        $pdo = connect::seConnecter();
        $requeteListGenre = $pdo->prepare("
        SELECT * FROM genre");
        $requeteListGenre->execute();
        require "view/listGenre.php";
    }

    // DETAIL GENRE
    public function infoGenre($id)
    {
        $pdo = connect::seConnecter();
        $requeteInfoGenre = $pdo->prepare("
        SELECT film.id_film, DATE_FORMAT(film.dateSortie, '%Y') AS dateSortie, 
        duree, film.id_realisateur, film.afficheFilm, 
        personne.id_personne, CONCAT(personne.prenom, ' ', personne.nom) AS nomPrenom_realisateur, 
        genre.id_genre, genre.nom AS nomGenre, titre
        FROM film 
	    INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
        INNER JOIN personne ON personne.id_personne = realisateur.id_personne
	    INNER JOIN genrer ON genrer.id_film = film.id_film
	    INNER JOIN genre ON genre.id_genre = genrer.id_genre
        WHERE genre.id_genre = :id");
        $requeteInfoGenre->execute(["id" => $id]);
        require "view/infoGenre.php";
    }

    // AJOUT GENRE
    public function addGenre()
    {
        if (isset($_POST['submit'])) {
            $nomGenre = filter_input(INPUT_POST, 'nomGenre', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($nomGenre) {
            $pdo = connect::seConnecter();
            $requeteAjoutGenre = $pdo->prepare("INSERT INTO genre (nom)
            VALUES (:nomGenre)");
            $requeteAjoutGenre->execute(['nomGenre' => $nomGenre]);
            $newId = $pdo->lastInsertId();
            header("Location:index.php?action=listGenre&id=" . $newId);
            exit();
        }
        }


        require 'view/addGenre.php';
    }
}
