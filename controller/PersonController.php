<?php

namespace Controller;

use Model\Connect;
use PDOStatement;

class PersonController
{
    public function showDetailsPerson(int $id_person): void
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

        $job->execute(["person_id" => $id_person]);
        // On recherche les résultats
        $results = $job->fetch();
        $tableName = $results['description'];
        // On l'utilise pour savoir quelle table utilisé pour
        // la requête suivante et obtenons les infos de la personne
        $pdo = Connect::getPDO();
        $person = $pdo->prepare("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        p.sex,
        p.image_url
        FROM person p
        INNER JOIN $tableName t ON t.id_person = p.id_person
        WHERE p.id_person = :person_id");
        $person->execute([
            "person_id" => $id_person
        ]);

        require "view/person.php";
    }
    public function listActors(): void
    {
        $pdo = Connect::getPDO();
        // Sélectionnez toutes les personnes
        $persons = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        p.sex,
        p.image_url,
        a.id_actor
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person 
        ORDER BY p.firstName ASC");

        $persons = $persons->fetchAll();
        /*if (isset($per['id_actor'])) {
            echo $this->getMoviesAndRoleByActor($per['id_actor']);
        } else {
            echo $this->getMoviesByDirector($per['id_person']);
        }*/

        require "view/person.php";
    }
    public function listDirectors(): void
    {

        $pdo = Connect::getPDO();
        $persons = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday,
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        p.sex,
        p.image_url
        FROM director d
        INNER JOIN person p ON d.id_person = p.id_person
        ORDER BY p.firstName ASC");

        require "view/person.php";
    }
    public function actorsOver50Years(): void
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday, 
        CONCAT(p.firstName,' ', p.lastName) AS fullname,
        p.id_person,
        YEAR(CURDATE()) - YEAR(birthday) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthday, '%m%d')) AS age_revolu,
        YEAR(CURDATE()) - YEAR(birthday) + IF(DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthday, '%m%d'), -1, 0) AS age_non_revolu,
        p.sex,
        p.image_url
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person
        WHERE YEAR(CURDATE()) - YEAR(birthday) > 50");

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
