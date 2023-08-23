<?php

namespace Controller;

use Model\Connect;

class CinemaController
{
    // Accueil
    public function accueil()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("SELECT titre, YEAR(dateSortie) AS annee, CONCAT(FLOOR(duree / 60), 'h', LPAD(MOD(duree, 60), 2, '0')) AS duree, noteFilm, id_film, afficheFilm
            FROM film
            ORDER BY YEAR(dateSortie) DESC
            LIMIT 3");
        $requete->execute();
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
        $nomGenre = filter_input(INPUT_POST, 'nomGenre', FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($_POST['submit'])) {
            $pdo = connect::seConnecter();
            $requeteAjoutGenre = $pdo->prepare("INSERT INTO genre (nom)
            VALUES (:nomGenre)");
            $requeteAjoutGenre->execute(['nomGenre' => $nomGenre]);
            $newId = $pdo->lastInsertId();
            header("Location:index.php?action=listGenre&id=" . $newId);
            die;
        }
        require 'view/addGenre.php';
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

    // AJOUT ACTEUR
    public function addActeur()
    {

        if (isset($_POST['submit'])) {
            $nomActeur = filter_input(INPUT_POST, 'nomActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenomActeur = filter_input(INPUT_POST, 'prenomActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $sexeActeur = filter_input(INPUT_POST, 'sexeActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $bdayActeur = filter_input(INPUT_POST, 'bdayActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $photoActeur = filter_input(INPUT_POST, 'photoActeur', FILTER_SANITIZE_SPECIAL_CHARS);
            $bioActeur = filter_input(INPUT_POST, 'bioActeur', FILTER_SANITIZE_SPECIAL_CHARS);

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
        }
        require "view/addActeur.php";
    }

    public function addCasting()
    {
        $pdo = connect::seConnecter();
        $requeteAllFilms = $pdo->prepare("SELECT id_film, titre FROM film");
        $requeteAllFilms->execute();

        $requeteAllActeurs = $pdo->prepare("SELECT personne.id_personne, acteur.id_acteur, CONCAT(personne.nom, ' ', personne.prenom) AS nomPrenom FROM personne
        INNER JOIN acteur ON acteur.id_personne = personne.id_personne");
        $requeteAllActeurs->execute();

        $requeteAllRoles = $pdo->prepare("SELECT id_role, personnage FROM role");
        $requeteAllRoles->execute();

        if (isset($_POST['submit'])) {
            $acteur = filter_input(INPUT_POST, 'acteur', FILTER_SANITIZE_SPECIAL_CHARS);
            $film = filter_input(INPUT_POST, 'film', FILTER_SANITIZE_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
            // var_dump($_POST);die;
            $requeteAddCasting = $pdo->prepare("INSERT INTO jouer (id_acteur, id_film, id_role) 
            VALUES (:acteur, :film, :role)");
            $requeteAddCasting->execute([
                'acteur' => $acteur,
                'film' => $film,
                'role' => $role
            ]);
            header("Location:index.php?action=addCasting");
        }
        require 'view/addCasting.php';
    }


    public function addFilm()
    {
        $pdo = connect::seConnecter();

        if (isset($_POST['submit'])) {

            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $dateSortie = filter_input(INPUT_POST, 'dateSortie', FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = filter_input(INPUT_POST, 'duree', FILTER_SANITIZE_SPECIAL_CHARS);
            $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);
            $noteFilm = filter_input(INPUT_POST, 'noteFilm', FILTER_SANITIZE_SPECIAL_CHARS);
            $afficheFilm = filter_input(INPUT_POST, 'afficheFilm', FILTER_SANITIZE_SPECIAL_CHARS);
            $realisateur = filter_input(INPUT_POST, 'realisateur', FILTER_SANITIZE_SPECIAL_CHARS);

            $requeteAjouterFilm = $pdo->prepare("INSERT INTO film 
                (titre, dateSortie, duree, synopsis, noteFilm, afficheFilm, id_realisateur) 
                VALUES (:titre, :dateSortie, :duree, :synopsis, :noteFilm, :afficheFilm, :realisateur)");
            $requeteAjouterFilm->execute([
                'titre' => $titre,
                'dateSortie' => $dateSortie,
                'duree' => $duree,
                'synopsis' => $synopsis,
                'noteFilm' => $noteFilm,
                'afficheFilm' => $afficheFilm,
                'realisateur' => $realisateur
            ]);

            $newIdFilm = $pdo->lastInsertId();

            foreach ($_POST['id_genre'] as $genre) {
                $requeteAttribuerGenres = $pdo->prepare("INSERT INTO genrer (id_film, id_genre) 
            VALUES (:id_film, :id_genre)");
                $requeteAttribuerGenres->execute([
                    'id_film' => $newIdFilm,
                    'id_genre' => $genre
                ]);
            }
            header("Location:index.php?action=addCasting&id=" . $newIdFilm);
            exit();
        }

        $requeteAjouterGenre = $pdo->prepare("SELECT id_genre, nom FROM genre");
        $requeteAjouterGenre->execute();

        $requeteAjouterRea = $pdo->prepare("SELECT id_realisateur, 
            CONCAT(personne.nom, ' ', personne.prenom) AS nomPrenom
            FROM realisateur
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");
        $requeteAjouterRea->execute();

        require 'view/addFilm.php';
    }
}
