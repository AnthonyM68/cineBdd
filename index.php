<?php

use Controller\CinemaController;
use Controller\HomeController;
use Controller\CastingController;
use Controller\PersonController;
use Controller\NotFoundController;


spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();
$ctrlHome = new HomeController();
$ctrlCasting = new CastingController();
$ctrlPerson = new PersonController();
$ctrlNotfound = new NotFoundController();


if (isset($_GET["action"])) {

    // On filtre les input 
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $action = htmlspecialchars($_GET['action']);

    if ($id === false) {
        // 'id' n'est pas présent ou n'est pas un entier valide.
        $ctrlNotfound->index();
    }
    switch ($action) {
        case "showDetailsPerson":
            $ctrlPerson->showDetailsPerson($id);
            break;
        case "showDetailsMovie":
            $ctrlCinema->showDetailsMovie($id);
            break;
        case "listMovies":
            $ctrlCinema->listMovies();
            break;
        case "listActors":
            $ctrlPerson->listActors();
            break;
        case "listDirectors":
            $ctrlPerson->listDirectors();
            break;
        case "listGenres":
            $ctrlCinema->listGenres();
            break;

        default :
       
        $ctrlNotfound->index();
    }
} else {
    $ctrlHome->index();
}
