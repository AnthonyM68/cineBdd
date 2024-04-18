<?php

use Controller\CinemaController;
use Controller\HomeController;
use Controller\PersonController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();
$ctrlHome = new HomeController();
$ctrlPerson = new PersonController();

if (isset($_GET["action"])) {

    // On filtre les input 
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $action = htmlspecialchars($_GET['action']);
    $table = null;
    if (isset($_GET['table'])) {
        $table = htmlspecialchars($_GET['table']);
    }
    if ($id === false) {
        // 'id' n'est pas présent ou n'est pas un entier valide.
        $ctrlNotfound->index();
    }
    switch ($action) {
        case "listGenres":
            $ctrlCinema->listGenres();
            break;

        case "listMovies":
            $ctrlCinema->listMovies();
            break;
        case "listMoviesAdmin":
            $ctrlCinema->listMoviesAdmin();
            break;

        case "insertMovieForm":
            $ctrlCinema->insertMovieForm();
            break;
        case "addMovie":
            $ctrlCinema->addMovie();
            break;
        case "insertCastingForm":
            $ctrlCinema->insertCastingForm($id);
            break;
        case "showDetailsMovie":
            $ctrlCinema->showDetailsMovie($id);
            break;
        case "modifyMovie":
            $ctrlCinema->modifyMovie($id);
            break;
        case "moviesUnder5Years":
            $ctrlCinema->moviesUnder5Years();
            break;
        case "moviesMoreThan2H15":
            $ctrlCinema->moviesMoreThan2H15();
            break;
        case "listActors":
            $ctrlPerson->listActors();
            break;
        case "listDirectors":
            $ctrlPerson->listDirectors();
            break;
        case "showDetailsPerson":
            $ctrlPerson->showDetailsPerson($id);
            break;
        case "actorsOver50Years":
            $ctrlPerson->actorsOver50Years();
            break;
        case "actorAndDirector":
            $ctrlPerson->actorAndDirector();
            break;
        case "searchEngine":
            $ctrlCinema->searchEngine();
            break;

        default:
            $ctrlCinema->notFound();
    }
} else {
    $ctrlHome->index();
}
