<?php

// On utilise le controller (pour éviter de taper manuellement le chemin des différents fichiers)
use Controller\ReaController;
use Controller\ActeurController;
use Controller\FilmController;
use Controller\GenreController;
use Controller\RoleController;

// Autoload des fichiers
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

// New objet controller
$reaCinema = new ReaController();
$acteurCinema = new ActeurController();
$filmCinema = new FilmController();
$genreCinema = new GenreController();
$roleCinema = new RoleController();


$id = (isset($_GET["id"])) ? $_GET["id"] : null;
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
            // Accueil avec 4 derniers films
        case "accueil":
            $filmCinema->accueil();
            break;
            // Liste de films
        case "listFilms":
            $filmCinema->listFilms();
            break;
            // Détail d'un film
        case "detailFilm":
            $filmCinema->detailFilm($id);
            break;
            // Liste des acteurs
        case "listActeurs":
            $acteurCinema->listActeurs();
            break;
            // Détail d'un acteur
        case "detailActeur":
            $acteurCinema->detailActeur($id);
            break;
            // Liste des genres
        case "listGenre":
            $genreCinema->listGenre();
            break;
            // Détail d'un genre
        case "infoGenre":
            $genreCinema->infoGenre($id);
            break;
            // Liste des réalisateurs
        case "listRealisateur":
            $reaCinema->listRealisateur($id);
            break;
            // Détail d'un réalisateur
        case "detailRealisateur":
            $reaCinema->detailRealisateur($id);
            break;
            // Liste des rôles
        case "listRole":
            $roleCinema->listRole();
            break;
            // Détail d'un rôle
        case "detailRole":
            $roleCinema->detailRole($id);
            break;

            // ------------------------- AJOUT -------------------------- //

            // Ajout genre
        case "addGenre":
            $genreCinema->addGenre();
            break;
            // Ajout rôle
        case "addRole":
            $roleCinema->addRole();
            break;
            // Ajout réalisateur
        case "addRea":
            $reaCinema->addRea();
            break;
            // Ajout acteur
        case "addActeur":
            $acteurCinema->addActeur();
            break;
            // Ajout casting
        case "addCasting":
            $filmCinema->addCasting();
            break;
            // Ajout film
        case "addFilm":
            $filmCinema->addFilm();
            break;
    }
}
