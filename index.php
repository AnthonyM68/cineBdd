<?php

use Controller\CinemaController;
use Controller\HomeController;
use Controller\CastingController;
use Controller\PersonController;
use Cotnroller\NotFoundController;


spl_autoload_register(function ($class_name) {
    var_dump($class_name);
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();
$ctrlHome = new HomeController();
$ctrlCasting = new CastingController();
$ctrlPerson = new PersonController();

/* WARNING plus possible d'instancier d'autres class après git */
//$ctrlNotfound = new NotFoundController();


if (isset($_GET["action"])) {

    // On filtre l'url pour vérifier si l'entrée est un entier valide
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false) {
        // 'id' n'est pas présent ou n'est pas un entier valide.

        echo "Prévoir erreur 404";
        //$ctrlNotfound->index();
    }
    switch ($_GET["action"]) {
        case "listMovies":
            $ctrlCinema->listMovies();
            break;

        case "listActors":
            $ctrlPerson->listActors();
            break;

        case "listDirectors":
            $ctrlPerson->listDirector();
            break;

        case "listGenres":
            $ctrlCinema->listGenres();
            break;
    }
} else {
    $ctrlHome->index();
}
