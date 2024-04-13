<?php

namespace Controller;

use Model\Connect;

class HomeController
{
    /* On recherche les 4 prochains films par date de sortie ordre decroissant 
    et les affichons sur la page d'accueil*/

    public function index()
    {
        /* On fait appel a notre class Connect et sa méthode getPDO pour se connecter 
        à notre base de données*/
        $pdo = Connect::getPDO(); 
        /* On effectue la requête et stockons les résultat dans $movies */
        $movies = $pdo->query("SELECT title, 
            DATE_FORMAT(releaseDate, '%d %m %Y') AS releaseDate, 
            DATE_FORMAT(SEC_TO_TIME(timeMovie * 60), '%HH%imn') AS timeMovie, 
            synopsis, 
            m.image_url,
            d.id_director, 
            p.firstName, 
            p.lastName, 
            p.birthday, 
            p.sex
            FROM director d
            INNER JOIN movie m ON d.id_director = m.id_director
            INNER JOIN person p ON d.id_person = p.id_person
            ORDER BY releaseDate DESC
            LIMIT 4");
        $title = "Accueil";
        // On rends la vus du Home
        require "view/home.php";
    }
}
