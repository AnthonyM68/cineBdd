<?php

namespace Controller;

use Model\Connect;

class HomeController
{
    // on affiche les 4 prochaines sortie en salle sur le Home
    public function index()
    {
        $pdo = Connect::getPDO();
        $movies = $pdo->query("SELECT 
        DATE_FORMAT(m.releaseDate, '%d %m %Y') AS releaseDate, 
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie,         
        m.id_movie,
        m.title, 
        m.synopsis, 
        m.image_url,
        d.id_director, 
        p.firstName, 
        p.lastName, 
        p.birthday, 
        p.sex
        FROM director d
        INNER JOIN movie m ON d.id_director = m.id_director
        INNER JOIN person p ON d.id_person = p.id_person
        ORDER BY m.releaseDate DESC
        LIMIT 4");
        $title = "Accueil";

        require "view/home.php";
    }
}
