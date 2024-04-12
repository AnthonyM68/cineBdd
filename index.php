<?php

use Controller\CinemaController;
use Controller\HomeController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();


if (isset($_GET["action"])) {
    switch ($_GET["action"]) {

        case "listMovies":
            $ctrlCinema->listMovies();
            break;

        case "listActors":
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if ($id === false || !ctype_digit($id)) { // 'id' n'est pas présent ou n'est pas un entier valide.
                echo "url not found";
            } else {
                $ctrlCinema->listActors($id);
            }
            break;
    }
} else {
    $ctrlCinema->index();
}
