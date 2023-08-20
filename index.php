<?php

use Controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null;
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {

        case "accueil":
            $ctrlCinema->accueil();
            break;

        case "listFilms":
            $ctrlCinema->listFilms();
            break;

        case "detailFilm":
            $ctrlCinema->detailFilm($id);
            break;

        case "listActeurs":
            $ctrlCinema->listActeurs();
            break;

        case "detailActeur":
            $ctrlCinema->detailActeur($id);
            break;


        case "listGenre":
            $ctrlCinema->listGenre();
            break;

        case "listRealisateur":
            $ctrlCinema->listRealisateur($id);
            break;

        case "detailRealisateur":
            $ctrlCinema->detailRealisateur($id);
            break;

        case "listRole":
            $ctrlCinema->listRole();
            break;

        case "detailRole":
            $ctrlCinema->detailRole($id);
            break;

        case "infoGenre":
            $ctrlCinema->infoGenre($id);
            break;
            // ------------------------- AJOUT -------------------------- //

            // Ajout genre
        case "addGenre":
            $ctrlCinema->addGenre();
            break;

            // Ajout réalisateur
        case "addRea":
            $ctrlCinema->addRea();
            break;
    }
}
