<?php

use Controller\ReaController;
use Controller\ActeurController;
use Controller\FilmController;
use Controller\GenreController;
use Controller\RoleController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$reaCinema = new ReaController();
$acteurCinema = new ActeurController();
$filmCinema = new FilmController();
$genreCinema = new GenreController();
$roleCinema = new RoleController();


$id = (isset($_GET["id"])) ? $_GET["id"] : null;
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {

        case "accueil":
            $filmCinema->accueil();
            break;

        case "listFilms":
            $filmCinema->listFilms();
            break;

        case "detailFilm":
            $filmCinema->detailFilm($id);
            break;

        case "listActeurs":
            $acteurCinema->listActeurs();
            break;

        case "detailActeur":
            $acteurCinema->detailActeur($id);
            break;


        case "listGenre":
            $genreCinema->listGenre();
            break;

        case "listRealisateur":
            $reaCinema->listRealisateur($id);
            break;

        case "detailRealisateur":
            $reaCinema->detailRealisateur($id);
            break;

        case "listRole":
            $roleCinema->listRole();
            break;

        case "detailRole":
            $roleCinema->detailRole($id);
            break;

        case "infoGenre":
            $genreCinema->infoGenre($id);
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

        case "addCasting":
            $filmCinema->addCasting();
            break;

        case "addFilm":
            $filmCinema->addFilm();
            break;
    }
}
