<?php

namespace Controller;

use Model\Connect;
use PDOStatement;
use Controller\ToolsController;

class PersonController extends ToolsController
{
    public function showDetailsPerson(): void
    {
        // On recherche si l'id_person est un acteur ou réalisateur
        $pdo = Connect::getPDO();
        $job = $pdo->prepare("SELECT 
        COALESCE(d.id_director, a.id_actor) AS id_job,
        CASE 
            WHEN d.id_director IS NOT NULL AND a.id_actor IS NOT NULL THEN 'director, actor'
            WHEN d.id_director IS NOT NULL THEN 'director' 
            WHEN a.id_actor IS NOT NULL THEN 'actor' 
            ELSE 'undefined' 
        END AS description
        FROM 
            person p
        LEFT JOIN 
            director d ON d.id_person = p.id_person
        LEFT JOIN 
            actor a ON a.id_person = p.id_person
        WHERE 
            p.id_person = :person_id");

        $job->execute(["person_id" => $_GET['id']]);
        // On recherche les résultats
        $results = $job->fetch();
        $tableName = $results['description'];

        // On l'utilise pour savoir quelle table utilisé pour
        // la requête suivante et obtenons les infos de la personne
        if ($tableName === "director, actor") {
            $tableName = "actor";
        }
        $dataPersonMovie = $pdo->prepare("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        p.sex,
        p.image_url
        FROM person p
        INNER JOIN $tableName t ON t.id_person = p.id_person
        WHERE p.id_person = :person_id");

        $dataPersonMovie->execute([
            "person_id" => $_GET['id']
        ]);
        $dataPersonMovie = $dataPersonMovie->fetchAll();

        require "view/person.php";
    }
    public function listActors(): void
    {
        $pdo = Connect::getPDO();

        $actors = $pdo->query("SELECT 
            p.id_person,
            DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
            CONCAT(p.firstName,' ', p.lastName) AS fullname,
            p.sex,
            p.image_url,
            m.id_movie,
            m.title AS title
            FROM actor a
            INNER JOIN person p ON a.id_person = p.id_person 
            LEFT JOIN casting c ON a.id_actor = c.id_actor
            LEFT JOIN movie m ON c.id_movie = m.id_movie
            ORDER BY p.firstName ASC
        ");

        $actors = $actors->fetchAll();

        // on crée un tableau vide pour chacun de nos acteurs
        $dataPersonMovie = [];
        foreach ($actors as $actor) {
            // Si l'acteur n'existe pas, on le pousse dans notre nouveau tableau
            // indice unique
            if (!isset($dataPersonMovie[$actor['id_person']])) {
                $dataPersonMovie[$actor['id_person']] = [
                    'id_person' => $actor['id_person'],
                    'birthday' => $actor['birthday'],
                    'fullname' => $actor['fullname'],
                    'sex' => $actor['sex'],
                    'image_url' => $actor['image_url'],
                    'movies' => [] // Initialisez une chaîne vide pour les films joués
                ];
            }
            $dataPersonMovie[$actor['id_person']]['movies'][] = [
                'id_movie' => $actor['id_movie'],
                'title' => $actor['title']
            ];
        }
        // on utilise un pointeur pour remplacer la valeur directement dans le tableau
        // $dataPersonMovie
        foreach ($dataPersonMovie as &$actor) {
            $actor['movies'] = $this->convertToString($actor['movies'], "detailsMovieLink");
        }
        require "view/person.php";
    }
    public function listDirectors(): void
    {
        $pdo = Connect::getPDO();

        $directors = $pdo->query("SELECT 
            p.id_person,
            DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
            CONCAT(p.firstName,' ', p.lastName) AS fullname,
            p.sex,
            p.image_url,
            m.id_movie,
            m.title AS title
        FROM director d
        INNER JOIN person p ON d.id_person = p.id_person 
        LEFT JOIN movie m ON m.id_director = d.id_director
        ORDER BY p.firstName ASC
    ");

        $directors = $directors->fetchAll();
        // on crée un tableau vide pour chaque réalisateur
        $dataPersonMovie = [];
        foreach ($directors as $director) {
            // Si le réalisateur n'existe pas, on le pousse dans notre nouveau tableau
            if (!isset($dataPersonMovie[$director['id_person']])) {
                $dataPersonMovie[$director['id_person']] = [
                    'id_person' => $director['id_person'],
                    'birthday' => $director['birthday'],
                    'fullname' => $director['fullname'],
                    'sex' => $director['sex'],
                    'image_url' => $director['image_url'],
                    'movies' => [] // Initialisez une chaîne vide pour les films réalisés
                ];
            }
            $dataPersonMovie[$director['id_person']]['movies'][] = [
                'id_movie' => $director['id_movie'],
                'title' => $director['title']
            ];
        }
        foreach ($dataPersonMovie as &$director) {
            // on convertis le tableau de movies en une chaine de caractère 
            // avec les liens detailsMovie et ponctuation
            $director['movies'] = $this->convertToString($director['movies'], "detailsMovieLink");
        }
        require "view/person.php";
    }

    public function actorsOver50Years(): void
    {
        $pdo = Connect::getPDO();
        $actors = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday, 
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        YEAR(CURDATE()) - YEAR(birthday) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthday, '%m%d')) AS age_revolu,
        YEAR(CURDATE()) - YEAR(birthday) + IF(DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthday, '%m%d'), -1, 0) AS age_non_revolu,
        p.sex,
        p.image_url,
        m.id_movie,
        m.title AS title
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person
        LEFT JOIN casting c ON a.id_actor = c.id_actor
        LEFT JOIN movie m ON c.id_movie = m.id_movie
        WHERE YEAR(CURDATE()) - YEAR(birthday) > 50");

        $actors = $actors->fetchAll();

        // on crée un tableau vide pour chacun de nos acteurs
        $infosActor = [];
        foreach ($actors as $actor) {
            // Si l'acteur n'existe pas, on le pousse dans notre nouveau tableau
            // indice unique
            if (!isset($infosActor[$actor['id_person']])) {
                $dataPersonMovie[$actor['id_person']] = [
                    'id_person' => $actor['id_person'],
                    'birthday' => $actor['birthday'],
                    'fullname' => $actor['fullname'],
                    'sex' => $actor['sex'],
                    'image_url' => $actor['image_url'],
                    'movies' => [] // Initialisez une chaîne vide pour les films joués
                ];
            }
            $dataPersonMovie[$actor['id_person']]['movies'][] = [
                'id_movie' => $actor['id_movie'],
                'title' => $actor['title']
            ];
        }
        // on utilise un pointeur pour remplacer la valeur directement dans le tableau
        // $dataPersonMovie
        foreach ($dataPersonMovie as &$actor) {
            $actor['movies'] = $this->convertToString($actor['movies'], "detailsMovieLink");
        }

        require "view/person.php";
    }
    public function actorAndDirector(): void
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person, 
        p.sex,
        p.image_url
        FROM person p
        INNER JOIN director d ON d.id_person = p.id_person
        INNER JOIN actor a ON a.id_person = p.id_person");

        $dataPersonMovie = $person->fetchAll();
        require "view/person.php";
    }
    public function deletePerson()
    {
        $id_person = $_GET['id'];
        $pdo = Connect::getPDO();

        $job = $pdo->prepare("SELECT 
        COALESCE(d.id_director, a.id_actor) AS id_job,
        CASE 
            WHEN d.id_director IS NOT NULL AND a.id_actor IS NOT NULL THEN 'director, actor'
            WHEN d.id_director IS NOT NULL THEN 'director' 
            WHEN a.id_actor IS NOT NULL THEN 'actor' 
            ELSE 'undefined' 
        END AS job
        FROM 
            person p
        LEFT JOIN 
            director d ON d.id_person = p.id_person
        LEFT JOIN 
            actor a ON a.id_person = p.id_person
        WHERE 
            p.id_person = :id_person");

        $job->execute(["id_person" => $id_person]);
        $job = $job->fetch();

        if ($job) {
            if ($job['job'] === 'actor') {
                $id_actor = $job["id_job"];
                // delete actor by id
                $actor = $pdo->prepare("DELETE FROM
                casting c
                WHERE c.id_actor = :actor_id");
                $actor->execute(["actor_id" => $id_actor]);
                $actor->fetch();

                $actor = $pdo->prepare("DELETE FROM
                actor 
                WHERE id_person = :person_id");
                $actor->execute(["person_id" => $id_actor]);
                $actor->fetch();
            }
            if ($job['job'] === 'director') {
                // Supprimer film avant tout
                $id_director = $job["id_job"];
                $director = $pdo->prepare("DELETE FROM
                director d
                WHERE d.id_director = :director_id");
                $director->execute(["director_id" => $id_director]);
                $director->fetch();
            }
        }

        $person = $pdo->prepare("DELETE FROM
        person p
        WHERE p.id_person = :id_person");
        $person->execute(["id_person" => $id_person]);
    }
}
