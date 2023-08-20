<?php

namespace Controller;

use Model\Connect;

class CinemaController
{
    // Accueil
    public function accueil()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT titre, YEAR(dateSortie) AS annee, CONCAT(FLOOR(duree / 60), 'h', LPAD(MOD(duree, 60), 2, '0')) AS duree, noteFilm, id_film, afficheFilm
            FROM film
            ORDER BY YEAR(dateSortie) DESC
            LIMIT 3");
        require "view/accueil.php";
    }

    // LISTE FILMS
    public function listFilms()
    {
        $pdo = connect::seConnecter();
        $requeteFilms = $pdo->prepare("
        SELECT id_film, titre, afficheFilm, DATE_FORMAT(dateSortie, '%Y') AS dateSortie
        FROM film
        INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
        INNER JOIN personne ON personne.id_personne = realisateur.id_personne");
        $requeteFilms->execute();
        require "view/listFilms.php";
    }

    // DETAIL FILM
    public function detailFilm($id)
    {
        $pdo = connect::seConnecter();
        $requeteDetailFilm = $pdo->prepare("
        SELECT 
        film.afficheFilm AS affiche, 
        film.titre AS titre, 
        DATE_FORMAT(film.dateSortie, '%d %M %Y') AS annee, 
        film.synopsis AS synopsis,
        CONCAT(film.duree DIV 60,'h', film.duree MOD 60) AS dureeFilm,
        noteFilm AS note, 
        CONCAT(personne.prenom, ' ', personne.nom) AS nomPrenom_acteur,
        film.id_realisateur AS id_realisateur,
        acteur.id_acteur AS id_acteur,
        CONCAT(p.prenom, ' ', p.nom) AS nomPrenom_realisateur,
        role.personnage AS rolePersonnage,
        role.id_role
        FROM film
        INNER JOIN jouer ON jouer.id_film = film.id_film
        INNER JOIN acteur ON acteur.id_acteur = jouer.id_acteur
        INNER JOIN personne ON personne.id_personne = acteur.id_personne
        INNER JOIN role ON role.id_role = jouer.id_role
        INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
        INNER JOIN personne AS p ON p.id_personne = realisateur.id_personne
        WHERE film.id_film = :id
         ");
        $requeteDetailFilm->execute(["id" => $id]);

        // AFFICHE LE GENRE D'UN FILM
        $requeteDetailGenre = $pdo->prepare("
        SELECT 
        genre.id_genre, genre.nom AS nomGenre
        FROM genre
        INNER JOIN genrer ON genre.id_genre = genrer.id_genre
        WHERE genrer.id_film = :id;");
        $requeteDetailGenre->execute(["id" => $id]);
        require "view/detailFilm.php";
    }

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
        require "view/detailActeur.php";
    }

    // LIST GENRE
    public function listGenre()
    {
        $pdo = connect::seConnecter();
        $requeteListGenre = $pdo->query("
        SELECT * FROM genre");
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
        require "view/detailRealisateur.php";
    }
    // ------------ AJOUT --------------------------------------

    // AJOUT GENRE
    public function addGenre()
    {
        if (isset($_POST['submit'])) {
            $pdo = connect::seConnecter();
            $requeteAjoutGenre = $pdo->prepare("INSERT INTO genre (nom)
            VALUES (:nomGenre)");
            $requeteAjoutGenre->execute(['nomGenre' => $_POST['nomGenre']]);
            $newId = $pdo->lastInsertId();
            header("Location:index.php?action=listGenre&id=" . $newId);
            die;
        }
        require "view/ajoutGenre.php";
    }

    // AJOUT REALISATEUR
    public function addRea()
    {
        $pdo = connect::seConnecter();
        $requeteAddRea1 = $pdo->prepare("INSERT INTO personne (nom, prenom, sexe, dateNaissance, photoAR, biographie)
        VALUES (:nomRea, :prenomRea, :sexeRea, :bdayRea, :photoRea, :bioRea)");
        $requeteAddRea2 = $pdo->prepare("INSERT INTO realisateur (id_personne)
        SELECT id_personne FROM personne WHERE personne.nom = :nomRea AND personne.prenom = :prenomRea");
        $requeteAddRea1->execute([
            'nomRea' => $_POST['nomRea'],
            'prenomRea' => $_POST['prenomRea'],
            'sexeRea' => $_POST['sexeRea'],
            'bdayRea' => $_POST['bdayRea'],
            'photoRea' => $_POST['photoRea'],
            'bioRea' => $_POST['bioRea']
        ]);
        $newId = $pdo->lastInsertId();
        $requeteAddRea2->execute(
            ['prenomRea' => $_POST['prenomRea']]
        );
        require "view/addRea.php";
        header("Location:index.php?action=addRea&id=" . $newId);
    }
}
