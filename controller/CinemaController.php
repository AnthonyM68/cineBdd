<?php

namespace Controller;

use Model\Connect;

use Controller\PersonController;
use Controller\ToolsController;

use DateTime;

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

        require "view/listMovies.php";
    }
    /**
     * displays movie management
     *
     * @return void
     */
    public function listMoviesAdmin()
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

        require "view/listMoviesAdmin.php";
    }

    /**
     * add movie in database
     *
     * @return void
     */
    public function insertMovieForm()
    {
        //tous les director
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        p.sex,
        p.image_url,
        a.id_actor
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person 
        ORDER BY p.firstName ASC");

        //tous les genres
        $genres = $pdo->query("SELECT g.id_genre, g.nameGenre
        FROM genre g");

        require "view/insertMovieForm.php";
    }
    public function addMovie()
    {
        if (isset($_POST)) {
            $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
            $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_SPECIAL_CHARS);
            $image_url_profil = filter_input(INPUT_POST, 'image_url_profil', FILTER_SANITIZE_SPECIAL_CHARS);
            $birthday = DateTime::createFromFormat('Y-m-d', $birthday);

            $pdo = Connect::getPDO();
            $person = $pdo->prepare("INSERT  INTO 
            person (firstName, lastName, birthday, sex, image_url)
            VALUE(:firstName, :lastName, :birthday, :sex, :image_url)
            ");
            $person->execute([
                "firstName" => $firstName,
                "lastName" => $lastName,
                "birthday" => $birthday->format('Y-m-d'),
                "sex" => $sex,
                "image_url" => $image_url_profil
            ]);

            $lastInsertedId = $pdo->lastInsertId();

            $director = $pdo->prepare("INSERT INTO 
            director (id_person)
            VALUE(:person_id)
            ");

            $director->execute([
                "person_id" => $lastInsertedId
            ]);
            $lastInsertedIdDirector = $pdo->lastInsertId();

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $releaseDate = filter_input(INPUT_POST, 'releaseDate', FILTER_SANITIZE_SPECIAL_CHARS);
            $timeMovie = filter_input(INPUT_POST, 'timeMovie', FILTER_VALIDATE_INT);
            $id_genre = filter_input(INPUT_POST, 'genre', FILTER_VALIDATE_INT);
            $image_url_movie = filter_input(INPUT_POST, 'image_url_movie', FILTER_SANITIZE_SPECIAL_CHARS);
            $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);

            $releaseDate = DateTime::createFromFormat('Y-m-d', $releaseDate);

            $movie = $pdo->prepare("INSERT INTO 
            movie (title, releaseDate, timeMovie, synopsis, id_director, image_url)
            VALUE(:title, :releaseDate, :timeMovie, :synopsis, :id_director, :image_url)
            ");
            $movie->execute([
                "title" => $title,
                "releaseDate" => $releaseDate->format('Y-m-d'),
                "timeMovie" => $timeMovie,
                "synopsis" => $synopsis,
                "id_director" => $lastInsertedIdDirector,
                "image_url" => $image_url_movie
            ]);

            $lastInsertedIdMovie = $pdo->lastInsertId();

            $genre = $pdo->prepare("INSERT INTO 
            genre_movie (id_genre, id_movie)
            VALUE(:genre_id, :movie_id)
            ");
            $genre->execute([
                "genre_id" => $id_genre,
                "movie_id" => $lastInsertedIdMovie
            ]);
        }
        header("Location: ./index.php");
    }
    public function insertCastingForm($id)
    {
        if (isset($_POST["id_actor"])) {
            $id_movie = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $id_actor = filter_input(INPUT_POST, 'id_actor', FILTER_VALIDATE_INT);
            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);

            $pdo = Connect::getPDO();
            $casting = $pdo->prepare("INSERT INTO
            casting (id_movie, id_actor, id_role)
            VALUE(:id_movie, :id_actor, :id_role)
            ");

            $casting->execute([
                "id_movie" => $id_movie,
                "id_actor" => $id_actor,
                "id_role" => $id_role
            ]);
            header("Location: ./index.php?insertCastingForm.php");
        }
        $pdo = Connect::getPDO();
        $actors = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        p.sex,
        p.image_url,
        a.id_actor
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person 
        ORDER BY p.firstName ASC");

        $roles = $pdo->query("SELECT 
        id_role, nameRole
        FROM role");

        require "view/insertCastingForm.php";
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
