<?php

namespace Controller;

use Model\Connect;

class FilmController
{

    // Accueil (LISTE DES 4 DERNIERS FILMS)
    public function accueil()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT id_film, titre, YEAR(dateSortie) AS annee,
            TIME_FORMAT(SEC_TO_TIME(film.duree * 60), '%H:%i') AS duree,
            film.noteFilm, id_film, film.afficheFilm
            FROM film
            ORDER BY YEAR(dateSortie) DESC
            LIMIT 1");
        $requete->execute();
        require "view/accueil.php";
    }



    // LISTE FILMS
    public function listFilms()
    {
        $pdo = connect::seConnecter();
        $requeteFilms = $pdo->prepare("
            SELECT id_film, titre, afficheFilm, YEAR(dateSortie) AS dateSortie
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
            SELECT film.afficheFilm AS affiche, film.titre AS titre, 
            DATE_FORMAT(film.dateSortie, '%d %M %Y') AS annee, 
            film.synopsis AS synopsis,
            TIME_FORMAT(SEC_TO_TIME(film.duree * 60), '%H:%i') AS dureeFilm,
            noteFilm AS note, 
            film.id_realisateur AS id_realisateur,
            CONCAT(p.prenom, ' ', p.nom) AS nomPrenom_realisateur
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
            INNER JOIN personne AS p ON p.id_personne = realisateur.id_personne
            WHERE film.id_film = :id");
        $requeteDetailFilm->execute(["id" => $id]);

        // AFFICHE LE GENRE D'UN FILM
        $requeteDetailGenre = $pdo->prepare("
            SELECT 
            genre.id_genre, genre.nom AS nomGenre
            FROM genre
            INNER JOIN genrer ON genre.id_genre = genrer.id_genre
            WHERE genrer.id_film = :id;");
        $requeteDetailGenre->execute(["id" => $id]);

        // AFFICHE LE CASTING D'UN FILM
        $requeteCasting = $pdo->prepare("
            SELECT acteur.id_acteur, role.id_role, role.personnage AS rolePersonnage, 
            CONCAT(personne.nom, ' ', personne.prenom) AS nomPrenom
            FROM acteur
            INNER JOIN personne ON personne.id_personne = acteur.id_personne
            INNER JOIN jouer ON acteur.id_acteur = jouer.id_acteur
            INNER JOIN film ON film.id_film = jouer.id_film
            INNER JOIN role ON role.id_role = jouer.id_role
            WHERE film.id_film = :id");
        $requeteCasting->execute(["id" => $id]);

        require "view/detailFilm.php";
    }

    
    
    
    // Ajout d'un film (avec son réalisateur, genre, l'affiche, synopsis... )
    public function addFilm()
    {
        $pdo = connect::seConnecter();
        
        $requeteAjouterRea = $pdo->prepare("
        SELECT id_realisateur, 
        CONCAT(personne.nom, ' ', personne.prenom) AS nomPrenom
        FROM realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne");
        
        // Ajouter un genre au film (a sélectionner dans une liste de genre)
        $requeteAjouterGenre = $pdo->prepare("SELECT id_genre, nom FROM genre");
        
        $requeteAjouterRea->execute();
        $requeteAjouterGenre->execute();

        if (isset($_POST['submit'])) {
            // Filtrage des différents input du formulaire
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $dateSortie = filter_input(INPUT_POST, 'dateSortie', FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = filter_input(INPUT_POST, 'duree', FILTER_SANITIZE_SPECIAL_CHARS);
            $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);
            $noteFilm = filter_input(INPUT_POST, 'noteFilm', FILTER_SANITIZE_SPECIAL_CHARS);
            $afficheFilm = filter_input(INPUT_POST, 'afficheFilm', FILTER_SANITIZE_SPECIAL_CHARS);
            $realisateur = filter_input(INPUT_POST, 'realisateur', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($titre && $dateSortie && $duree && $synopsis && $noteFilm && $afficheFilm && $realisateur) {
                $requeteAjouterFilm = $pdo->prepare("
                INSERT INTO film (titre, dateSortie, duree, synopsis, noteFilm, afficheFilm, id_realisateur) 
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
        }
        require 'view/addFilm.php';
    }

    // Ajout d'un casting de film 
    public function addCasting()
    {
        $pdo = connect::seConnecter();
        $requeteAllFilms = $pdo->prepare("SELECT id_film, titre FROM film");
        $requeteAllFilms->execute();

        $requeteAllActeurs = $pdo->prepare("
        SELECT personne.id_personne, acteur.id_acteur, 
        CONCAT(personne.nom, ' ', personne.prenom) AS nomPrenom FROM personne
        INNER JOIN acteur ON acteur.id_personne = personne.id_personne");
        $requeteAllActeurs->execute();

        $requeteAllRoles = $pdo->prepare("SELECT id_role, personnage FROM role");
        $requeteAllRoles->execute();

        // Si submit alors ajouter un acteur, film et role en filtrant les champs
        if (isset($_POST['submit'])) {
            // Filtrage des différents champs
            $acteur = filter_input(INPUT_POST, 'acteur', FILTER_SANITIZE_SPECIAL_CHARS);
            $film = filter_input(INPUT_POST, 'film', FILTER_SANITIZE_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($acteur && $film && $role) {
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
        }
        require 'view/addCasting.php';
    }
    
}

