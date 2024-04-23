<?php

namespace Controller;

use Model\Connect;

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
    public function deleteMovie($id)
    {


        $pdo = Connect::getPDO();
        $casting = $pdo->prepare("DELETE FROM
        casting c
        WHERE c.id_movie = :id");

        $casting->execute(["id" => $id]);

        $genres = $pdo->prepare("DELETE FROM
        genre_movie gm
        WHERE gm.id_movie = :id");

        $genres->execute(["id" => $id]);

        $movie = $pdo->prepare("DELETE FROM
        movie m
        WHERE m.id_movie = :id");

        $movie->execute(["id" => $id]);

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
            // Récupérer les détails du film
            $movie = $pdo->prepare("SELECT 
                    m.title, 
                    DATE_FORMAT(m.releaseDate, '%d %m %Y') AS releaseDate, 
                    DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie, 
                    m.synopsis,
                    m.image_url
                FROM movie m
                WHERE m.id_movie = :movie_id
            ");
            $movie->execute(["movie_id" => $movie_id]);
            $movie = $movie->fetch();

        
            // Récupérer les détails du casting
            $casting = $pdo->prepare("SELECT
                     p.id_person,
                    p.firstName, 
                    p.lastName, 
                    r.nameRole
                FROM casting c
                INNER JOIN role r ON c.id_role = r.id_role
                LEFT JOIN actor a ON c.id_actor = a.id_actor
                LEFT JOIN person p ON a.id_person = p.id_person
                WHERE c.id_movie = :movie_id
            ");
            $casting->execute(["movie_id" => $movie_id]);
            $castingDetails = $casting->fetchAll();
            $casting = $this->convertToString($castingDetails, "casting");
        
            // Récupérer les genres du film
            $genres = $pdo->prepare("SELECT g.nameGenre
                FROM genre_movie gm
                INNER JOIN genre g ON gm.id_genre = g.id_genre
                WHERE gm.id_movie = :movie_id
             
            ");
            $genres->execute(["movie_id" => $movie_id]);

            $genres = $genres->fetchAll();

            $genres = $this->convertToString($genres, "genres");
          
            // Récupérer les informations sur le réalisateur
            $director = $pdo->prepare("SELECT p.firstName, p.lastName
                FROM person p
                INNER JOIN director d ON d.id_person = p.id_person
                WHERE d.id_director IN (
                    SELECT id_director FROM movie WHERE id_movie = :movie_id
                )
            ");
            $director->execute(["movie_id" => $movie_id]);
            $director = $director->fetch();
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
     * added form add Movie
     *
     * @return void
     */
    public function insertMovieForm()
    {

        $pdo = Connect::getPDO();
        // S'il y a un id dans l'url GET nous recherchons et affichons 
        // les informations du film à modifier
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $details = $pdo->prepare("SELECT m.title, 
                DATE_FORMAT(m.releaseDate, '%Y-%m-%d') AS releaseDate, 
                DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn')  AS timeMovie, 
                m.synopsis,
                m.image_url AS image_url_movie,
                p.image_url AS image_url_profil,
                p.firstName, 
                p.id_person,
                p.lastName, 
                d.id_director,        
                DATE_FORMAT(p.birthday, '%Y-%m-%d') AS birthday, 
                p.sex
                FROM director d
                INNER JOIN movie m ON d.id_director = m.id_director
                INNER JOIN person p ON d.id_person = p.id_person
                WHERE id_movie = :movie_id");
            $details->execute(["movie_id" => $id]);
            // tous les genres du film par $id_movie, colonne selected en +.
            // pour les select HTML
            $genres = $pdo->prepare("SELECT g.nameGenre, g.id_genre,
            CASE WHEN gm.id_genre IS NOT NULL THEN 1 ELSE 0 END AS selected
            FROM genre g
            
            LEFT JOIN (
                SELECT DISTINCT id_genre
                FROM genre_movie
                WHERE id_movie = :movie_id
            ) gm ON g.id_genre = gm.id_genre");

            $genres->execute(["movie_id" => $id]);

            require "view/insertMovieForm.php";
        } else {
            // Nous affichons un formulaire nouveau
            // avec pour seule recherche tous les genres
            $genres = $pdo->query("SELECT 
            nameGenre, id_genre
            FROM genre");
            require "view/insertMovieForm.php";
        }
    }
    public function editMovie()
    {
        $pdo = Connect::getPDO();
        if (isset($_GET["id"]) && !empty($_GET["id"])) {

            $id = $_GET['id'];
            $id_director = filter_input(INPUT_POST, 'director', FILTER_VALIDATE_INT);

            // nous mettons a jour le film et son réalisateur
            // filtrage des input
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $releaseDate = filter_input(INPUT_POST, 'releaseDate', FILTER_SANITIZE_SPECIAL_CHARS);
            $image_url_movie = filter_input(INPUT_POST, 'image_url_movie', FILTER_SANITIZE_SPECIAL_CHARS);
            $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($image_url_movie) {
                $image_url_movie = "./index.html/public/img/films/$image_url_movie";
            }
            
            $timeMovie = null;
            // convertion du format HTML vers datetime
            if (isset($_POST['timeMovie'])) {
                $timeMovie = filter_input(INPUT_POST, 'timeMovie', FILTER_SANITIZE_SPECIAL_CHARS);
                $timeMovie = $this->convertToMinutes($_POST['timeMovie']);
                
            }

            // on prépare la requête
            $movie = $pdo->prepare("UPDATE
            movie
            SET 
            title = :title, 
            releaseDate = :releaseDate, 
            timeMovie = :timeMovie, 
            synopsis = :synopsis, 
            image_url = :image_url
            WHERE id_movie = :movie_id");

            $movie->execute([
                "title" => $title,
                "releaseDate" => $releaseDate,
                "timeMovie" => $timeMovie,
                "synopsis" => $synopsis,
                "image_url" => $image_url_movie,
                "movie_id" => $id
            ]);

            // Traitement des genres du film
            $genres = $_POST['genres'];
            $id_genreChecked = [];

            foreach ($genres as $key => $id_genre) {
                // On valider chaque id_genre 
                $id_genre = filter_var($id_genre, FILTER_VALIDATE_INT);
                if ($id_genre) {
                    $id_genreChecked[] = $id_genre;
                }
            }
            // mis à jour des genres (suppression plutôt que update!)
            // On supprime les anciennes associations de tel sorte que si dans la nouvelle saisie du form,
            // on retire un genre par exemple
            $deleteGenres = $pdo->prepare("DELETE FROM genre_movie WHERE id_movie = :movie_id");
            $deleteGenres->execute(["movie_id" => $id]);

            $genres = $pdo->prepare("INSERT INTO genre_movie (id_genre, id_movie) VALUES (:genre_id, :movie_id)");
            // On insère les nouveaux genres a partir de id_genreChecked[]
            foreach ($id_genreChecked as $genre_id) {
                $genres->execute(["genre_id" => $genre_id, "movie_id" => $id]);
            }

            // on filtre les INPUT
            $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
            $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_SPECIAL_CHARS);
            $image_url_profil = filter_input(INPUT_POST, 'image_url_profil', FILTER_SANITIZE_SPECIAL_CHARS);

            $person = $pdo->prepare("UPDATE 
            person p 
            INNER JOIN director d ON d.id_person = p.id_person
            SET 
            p.firstName = :firstName, 
            p.lastName = :lastName, 
            p.birthday = :birthday, 
            p.sex = :sex,
            p.image_url = :image_url
            WHERE d.id_director= :director_id
            ");
            $person->execute([
                "firstName" => $firstName,
                "lastName" => $lastName,
                "birthday" => $birthday,
                "sex" => $sex,
                "image_url" => $image_url_profil,
                "director_id" => $id_director
            ]);
        }
        // nous affichons un formulaire nouveau
        // avec pour seule recherche tous les genres disponibles
        $genres = $pdo->query("SELECT 
        nameGenre, id_genre
        FROM genre");

        require "view/insertMovieForm.php";
    }
    /**
     * Insert movie in database
     *
     * @return void
     */
    public function addMovie($id)
    {
        $pdo = Connect::getPDO();

        $id_director = null;
        // si firstName existe et qu'il est renseigné, nous vérifions les infos saisie
        if (
            isset($_POST["firstName"]) && !empty($_POST["firstName"])
            && isset($_POST["lastName"]) && !empty($_POST["lastName"])
            && isset($_POST["birthday"]) && !empty($_POST["birthday"])
            && isset($_POST["sex"]) && !empty($_POST["sex"])
            && isset($_POST["image_url_profil"]) && !empty($_POST["image_url_profil"])
        ) {

            $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
            $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_SPECIAL_CHARS);
            $image_url_profil = filter_input(INPUT_POST, 'image_url_profil', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($image_url_profil) {
                $image_url_profil = "./index.html/public/img/persons/$image_url_profil";
            }

            // on prépare la requête pour la table person
            $person = $pdo->prepare("INSERT INTO 
                person (firstName, lastName, birthday, sex, image_url) 
                VALUES (:firstName, :lastName, :birthday, :sex, :image_url)");
            // on lui passe les infos du form 
            $person->execute([
                "firstName" => $firstName,
                "lastName" => $lastName,
                "birthday" => $birthday,
                "sex" => $sex,
                "image_url" => $image_url_profil
            ]);
            // on récupère l'ID de la ligne insérer
            $personId = $pdo->lastInsertId();

            // on vérifie si la clé director existe
            $directorChecked = isset($_POST['director']);

            // si la checkbox est cochée
            if ($directorChecked) {
                // si ça valeur est vide dans ce cas nous créons un nouveau director
                if ($_POST['director'] === "") {
                    $person = $pdo->prepare(
                        "INSERT INTO 
                            director (id_person) 
                            VALUES (:id_person)"
                    );
                    $person->execute(["id_person" => $personId]);

                    $id_director = $pdo->lastInsertId();
                } else if ($directorChecked) {
                    // update director
                }
            }
            $actorChecked = isset($_POST['actor']);
            // si la checkbox est cochée
            if ($actorChecked) {
                // si ça valeur est vide dans ce cas nous créons un nouveau actor
                if ($_POST['actor'] === "") {
                    $person = $pdo->prepare(
                        "INSERT INTO 
                            actor (id_person) 
                            VALUES (:id_person)"
                    );
                    $person->execute(["id_person" => $personId]);

                    $id_director = $pdo->lastInsertId();
                } else if ($directorChecked) {
                    // update actor
                }
            }
        }
        // si title existe et qu'il est renseigné, nous vérifions les infos saisie
        if (
            isset($_POST["title"]) && !empty($_POST["title"])
            && isset($_POST["releaseDate"]) && !empty($_POST["releaseDate"])
            && isset($_POST["timeMovie"]) && !empty($_POST["timeMovie"])
            && isset($_POST["synopsis"]) && !empty($_POST["birthday"])
            && isset($_POST["timeMovie"]) && !empty($_POST["timeMovie"])
            && isset($_POST["id_director"]) && !empty($_POST["id_director"])
            && isset($_POST["image_url_movie"]) && !empty($_POST["image_url_movie"])
        ) {
            // filtrage des input
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $releaseDate = filter_input(INPUT_POST, 'releaseDate', FILTER_SANITIZE_SPECIAL_CHARS);
            $image_url_movie = filter_input(INPUT_POST, 'image_url_movie', FILTER_SANITIZE_SPECIAL_CHARS);
            $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);

            // convertion du format HTML vers datetime
            if (isset($_POST['timeMovie'])) {
                $timeMovie = filter_input(INPUT_POST, 'timeMovie', FILTER_SANITIZE_SPECIAL_CHARS);
                $timeMovie = $this->convertToMinutes($_POST['timeMovie']);
            }
            // on prépare la requête
            $movie = $pdo->prepare("INSERT INTO 
                movie (title, releaseDate, timeMovie, synopsis, id_director, image_url)
                VALUE(:title, :releaseDate, :timeMovie, :synopsis, :id_director, :image_url)
                ");

            // ajouter verification if(!$id_director) notifier a l'utilisateur avec feedback 
            // le checkbox Réalisateur obligatoire pour insérer un nouveau film
            if ($id_director) {
                $movie->execute([
                    "title" => $title,
                    "releaseDate" => $releaseDate,
                    "timeMovie" => $timeMovie,
                    "synopsis" => $synopsis,
                    "id_director" => $id_director,
                    "image_url" => $image_url_movie
                ]);
                $id_movie = $pdo->lastInsertId();

                // on traite tous les genres sélectionnés
                if (isset($_POST['genres'])) {
                    // Traitement des genres du film
                    $id_genreChecked = [];
                    foreach ($_POST['genres'] as $key => $id_genre) {
                        // On valider chaque id_genre 
                        $id_genre = filter_var($id_genre, FILTER_VALIDATE_INT);
                        if ($id_genre) {
                            $id_genreChecked[] = $id_genre;
                        }
                    }
                    $genres = $pdo->prepare("INSERT INTO genre_movie (id_genre, id_movie) VALUES (:genre_id, :movie_id)");
                    // On insère les nouveaux genres a partir de id_genreChecked[]
                    foreach ($id_genreChecked as $genre_id) {
                        $genres->execute(["genre_id" => $genre_id, "movie_id" => $id_movie]);
                    }
                }
            }
        }

        // nous affichons un formulaire nouveau
        // avec pour seule recherche tous les genres disponibles
        $genres = $pdo->query("SELECT 
        nameGenre, id_genre
        FROM genre");

        require "view/insertMovieForm.php";
    }
    public function insertCastingForm($id)
    {
        $pdo = Connect::getPDO();

        if (isset($_POST["id_actor"])) {

            $id_movie = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $id_actor = filter_input(INPUT_POST, 'id_actor', FILTER_VALIDATE_INT);
            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);

            $casting = $pdo->prepare("INSERT INTO
            casting (id_movie, id_actor, id_role)
            VALUE(:id_movie, :id_actor, :id_role)
            ");

            $casting->execute([
                "id_movie" => $id_movie,
                "id_actor" => $id_actor,
                "id_role" => $id_role
            ]);
        }

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
        FROM role
        ORDER BY nameRole ASC");

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
