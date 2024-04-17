<?php

namespace Controller;

use Model\Connect;

use Controller\PersonController;
use Controller\ToolsController;

class CinemaController extends ToolsController
{
    /**
     * list genre
     *
     * @return void
     */
    public function listGenres(): void
    {
        $pdo = Connect::getPDO();
        $genres = $pdo->query("SELECT g.id_genre, g.nameGenre
        FROM genre g");

        require "view/listGenres.php";
    }
    public function getListMovies()
    {
        $pdo = Connect::getPDO();
        $movies = $pdo->query("SELECT m.id_movie, m.title, 
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie, 
        DATE_FORMAT(m.releaseDate, '%d/%m/%Y') AS releaseDate, 
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
        return $movies;
    }
    public function getMoviesByDirector($id_person)
    {
        $movies = null;
        $pdo = Connect::getPDO();
        $movies = $pdo->prepare("SELECT
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie,
        DATE_FORMAT(m.releaseDate, '%d/%m/%Y') AS releaseDate,
        m.id_movie,
        m.title,
        m.synopsis,
        m.image_url
    FROM movie m
    INNER JOIN
        director d ON m.id_director = d.id_director
    INNER JOIN
        person p ON p.id_person = d.id_person
    WHERE
        p.id_person = :person_id

    ORDER BY m.releaseDate ASC");

        $movies->execute(["person_id" => $id_person]);

        $movies = $this->makeStringFromFetchWithLink($movies);

        return $movies;
    }
    public function getMoviesAndRoleByActor($id_actor)
    {
        $movies = null;
        $pdo = Connect::getPDO();
        $movies = $pdo->prepare("SELECT
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie,
        DATE_FORMAT(m.releaseDate, '%d/%m/%Y') AS releaseDate,
        m.id_movie,
        m.title,
        m.synopsis,
        m.id_director,
        m.image_url,
        r.nameRole
    FROM
        casting c
    INNER JOIN
        role r ON c.id_role = r.id_role
    INNER JOIN
        movie m ON c.id_movie = m.id_movie
    INNER JOIN
        person p ON c.id_actor = p.id_person
    WHERE
        p.id_person = :actor_id
    ORDER BY
        m.releaseDate ASC");

        $movies->execute(["actor_id" => $id_actor]);

        $movies = $this->makeStringFromFetchWithLink($movies);

        return $movies;
    }
    public function moviesUnder5Years()
    {
        $pdo = Connect::getPDO();
        $movies = $pdo->query("SELECT 
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie, 
        DATE_FORMAT(m.releaseDate, '%d/%m/%Y') AS releaseDate,        
        m.id_movie,
        m.title, 
        m.synopsis,
        m.id_director,
        m.image_url
        FROM director d
        INNER JOIN movie m ON d.id_director = m.id_director
        INNER JOIN person p ON d.id_person = p.id_person
        WHERE DATEDIFF(CURDATE(), m.releaseDate) < 365 * 5
        ORDER BY m.releaseDate ASC;");

        require "view/listMovies.php";
    }
    public function moviesMoreThan2H15()
    {
        $pdo = Connect::getPDO();
        $movies = $pdo->query("SELECT
        DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie,
        DATE_FORMAT(m.releaseDate, '%d/%m/%Y') AS releaseDate,        
        m.id_movie,
        m.title, 
        m.synopsis,
        m.id_director,
        m.image_url
        FROM director d
        INNER JOIN movie m ON d.id_director = m.id_director
        INNER JOIN person p ON d.id_person = p.id_person
        WHERE timeMovie > 135
        ORDER BY title ASC");

        require "view/listMovies.php";
    }
    /**
     * details of a movie
     */
    public function showDetailsMovie(int $movie_id)
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
        // Convert array person to string with separator
        $casting = $this->makeStringFromFetch($casting);

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
    /**
     * display all movies
     */
    public function listMovies(): void
    {
        $movies = $this->getListMovies();
        require "view/listMovies.php";
    }
    /**
     * displays movie management
     *
     * @return void
     */
    public function listMoviesAdmin()
    {
        $movies = $this->getListMovies();
        require "view/listMoviesAdmin.php";
    }
    /**
     * add movie in database
     *
     * @return void
     */
    public function insertMovie()
    {
        require "view/insertMovie.php";
    }
    /**
     * Search Engine (not development)
     *
     * @return void
     */
    public function searchEngine()
    {
        require "view/searchEngine.php";
    }
    /**
     * 404
     *
     * @return void
     */
    public function notFound()
    {
        require "view/notFound.php";
    }
}
