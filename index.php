<?php

use Controller\CinemaController;
use Controller\HomeController;
use Controller\PersonController;

// autoload class files by name Class
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
// instances Class
$ctrlCinema = new CinemaController();
$ctrlHome = new HomeController();
$ctrlPerson = new PersonController();

if (isset($_GET["action"])) {
    $id = null;
    // filtres input
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = null;
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === "") {
            // 'id' n'est pas présent ou n'est pas un entier valide.
            return $ctrlCinema->notFound();
            ;
        }
    }
    // switch of action
    switch ($action) {
        // MOVIE
        case "listGenres":
            $ctrlCinema->listGenres();
            break;
        case "listMovies":
            $ctrlCinema->listMovies();
            break;
        case "listMoviesAdmin":
            $ctrlCinema->listMoviesAdmin();
            break;
        case "showDetailsMovie":
            $ctrlCinema->showDetailsMovie($id);
            break;
        case "moviesUnder5Years":
            $ctrlCinema->moviesUnder5Years();
            break;
        case "moviesMoreThan2H15":
            $ctrlCinema->moviesMoreThan2H15();
            break;
        case "insertMovieForm":
            $ctrlCinema->insertMovieForm($id);
            break;
        case "addMovie":
            $ctrlCinema->addMovie($id);
            break;
        case "deleteMovie":
            $ctrlCinema->deleteMovie($id);
            break;
        case "editMovie":
            $ctrlCinema->editMovie();
            break;
        case "insertCastingForm":
            $ctrlCinema->insertCastingForm($id);
            break;
        // PERSON ACTORS/DIRECTORS
        case "listActors":
            $ctrlPerson->listActors();
            break;
        case "listDirectors":
            $ctrlPerson->listDirectors();
            break;
        case "deletePerson":
            $ctrlPerson->deletePerson();
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
        // Search Engine (next step)
        case "searchEngine":
            $ctrlCinema->searchEngine();
            break;
        // si aucune action n'est trouvée
        default:
            $ctrlCinema->notFound();
    }
} else {
    // on rends la vue du HOME
    $ctrlHome->index();
}
