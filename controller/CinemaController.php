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
        $movies = $pdo->query("SELECT m.title, 
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie, 
        DATE_FORMAT(m.releaseDate, '%d %m %Y') AS releaseDate, 
        m.synopsis, 
        m.image_url,
        d.id_director,
        p.firstName, 
        p.lastName, 
        p.birthday, 
        p.sex
        FROM director d
        INNER JOIN movie m ON d.id_director = m.id_director
        INNER JOIN person p ON d.id_person = p.id_person");

        require "view/listMovies.php";
    }
    public function listGenres()
    {
        $pdo = Connect::getPDO();
        $genres = $pdo->query("SELECT g.id_genre, g.nameGenre
        FROM genre g");

        require "view/listGenres.php";
    }
}
