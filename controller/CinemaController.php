<?php

namespace Controller;

use Model\Connect;

use Controller\PersonController;

class CinemaController
{
    /**
     * Lister les films
     */
    public function listMovies()
    {
        $pdo = Connect::getPDO();
        $movies = $pdo->query("SELECT m.id_movie, m.title, 
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
    /**
     * lister les genres
     *
     * @return void
     */
    public function listGenres()
    {
        $pdo = Connect::getPDO();
        $genres = $pdo->query("SELECT g.id_genre, g.nameGenre
        FROM genre g");

        require "view/listGenres.php";
    }
    /**
     * On crée un tableau de tous les genres à partir de PDOStatement
     * S'il y a plus d'un éléments,on convertir le tableau en chaine de caractère
     * de tous les genres avec un séparateur "," sauf le dernier
     *
     * @param [PDOStatement] $pdoStat genres
     * @return string HTML
     */
    private function makeStringFromFetch($pdoStat): string
    {

        $result = $pdoStat->fetchAll();
        $nameGenre = array_column($result, 'nameGenre');

        if (count($nameGenre) > 1 ) {
            $lastGenre = array_pop($nameGenre);
            $genresString = implode(', ', $nameGenre) . ' et ' . $lastGenre;
        } else {
            $genresString = implode(', ', $nameGenre);
        }

        $html = '<small>' . $genresString . '</small>';

        return $html;
    }
    /**
     * détails d'un film
     */
    public function showDetailsMovie($movie_id)
    {
        $pdo = Connect::getPDO();
        $details = $pdo->prepare("SELECT m.title, 
        DATE_FORMAT(m.releaseDate, '%d %m %Y') AS releaseDate, 
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn')  AS timeMovie, 
        m.synopsis,
        m.image_url, 
        d.id_director, 
        p.firstName, 
        p.id_person,
        p.lastName, 
        p.birthday, 
        p.sex
        FROM director d
        INNER JOIN movie m ON d.id_director = m.id_director
        INNER JOIN person p ON d.id_person = p.id_person
        WHERE id_movie = :movie_id");
        $details->execute(["movie_id" => $movie_id]);

        $casting = $pdo->prepare("SELECT
        p.id_person,
        p.lastName, 
        p.firstName, 
        p.sex, 
        p.image_url,
        r.nameRole, 
        DATE_FORMAT(p.birthday, '%d %m %Y') AS birthday
        FROM casting c
        INNER JOIN movie m ON c.id_movie = m.id_movie
        INNER JOIN role r  ON r.id_role = c.id_role
        LEFT JOIN actor a  ON a.id_actor = c.id_actor
        LEFT JOIN person p ON a.id_person = p.id_person
        WHERE m.id_movie = :movie_id");
        $casting->execute(["movie_id" => $movie_id]);

        $ctrlPerson = new PersonController();

        $casting = $ctrlPerson->makeStringFromFetch($casting);

        $genres = $pdo->prepare("SELECT gm.id_genre,
        nameGenre
        FROM genre_movie gm
        INNER JOIN genre g ON gm.id_genre = g.id_genre
        WHERE	gm.id_movie = :movie_id");
        $genres->execute(["movie_id" => $movie_id]);

        // Convert array genres to string with separator
        $genres = $this->makeStringFromFetch($genres);

        $director = $pdo->prepare("SELECT p.firstName, lastName
        FROM person p
        INNER	JOIN director d ON d.id_person = p.id_person
        INNER JOIN movie m ON m.id_director = d.id_director
        WHERE m.id_movie = :movie_id");
        $director->execute(["movie_id" => $movie_id]);

        require "view/detailsMovie.php";
    }
}
