<?php

namespace Controller;

use Model\Connect;

class CinemaController
{
    /**
     * Lister les films
     */
    public function listMovies()
    {
        $pdo = Connect::getPDO();
        $requete = $pdo->query("SELECT title, releaseDate FROM movie");
        require "view/listMovies.php";
    }
    public function listActors($id)
    {
        $pdo = Connect::getPDO();
        $casting = $pdo->prepare("SELECT movie.title, person.lastName, person.firstName, person.sex, role.nameRole, DATE_FORMAT(person.birthday, '%d %m %Y') AS date_naissance
        FROM casting 
        INNER JOIN movie ON casting.id_movie = movie.id_movie
        INNER JOIN role ON role.id_role = casting.id_role
        LEFT JOIN actor ON actor.id_actor = casting.id_actor
        LEFT JOIN person ON actor.id_person = person.id_person
        WHERE movie.id_movie = :id");
        $casting->execute(["id" => $id]);

        $movie = $pdo->prepare("SELECT title, DATE_FORMAT(releaseDate, '%d %m %Y'), DATE_FORMAT(SEC_TO_TIME(timeMovie * 60), '%HH%imn'), 
        synopsis, director.id_realisator, person.firstName, person.lastName, person.birthday, person.sex
        FROM director
        INNER JOIN movie ON director.id_realisator = movie.id_realisator
        INNER JOIN person ON director.id_person = person.id_person
        WHERE id_movie = :id");
        $movie->execute(["id" => $id]);

        require "view/castings.php";
    }
    public function index()
    {
        $pdo = Connect::getPDO();
        $movies = $pdo->query("SELECT title, 
        DATE_FORMAT(releaseDate, '%d %m %Y'), 
        DATE_FORMAT(SEC_TO_TIME(timeMovie * 60), '%HH%imn') AS timeMovie, 
        synopsis, 
        image_url,
        director.id_realisator, 
        person.firstName, 
        person.lastName, 
        person.birthday, 
        person.sex
        FROM director 
        INNER JOIN movie ON director.id_realisator = movie.id_realisator
        INNER JOIN person ON director.id_person = person.id_person
        ORDER BY releaseDate DESC
        LIMIT 4");
        $title = "Accueil";
        require "view/header.php";
    }
}
