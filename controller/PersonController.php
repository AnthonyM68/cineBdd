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

        require "view/person.php";
    }
    public function listDirectors(): void
    {

        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
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
}
