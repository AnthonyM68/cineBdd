<?php

namespace Controller;

use COM;
use Model\Connect;
use PDOStatement;

class PersonController
{
    public function index()
    {
        require "view/person.php";
    }
    /**
     * On crée un titre personnalisé de la page visitée
     * - Si c'est un acteur
     * - Si c'est un réalisateur
     * - Si c'est une liste de personnes
     *
     * @return string
     */
    public function switchTitlePage()
    {
        switch ($_GET['action']) {
            case "actorsOver50Years":
                return "Les Acteurs de plus de 50 ans";
            case "listActors":
                return "Tous les Acteurs";
                break;
            case "listDirectors":
                return "Tous les Réalisateurs";
                break;
            case "actorAndDirector":
                return "Les acteurs à la fois réalisateur";
                break;
            default:
                return "";
        };
    }
    /**
     * Recherche dans les tables actor et director si l'id_person 
     * est présent, si c'est le cas
     *
     * @param integer $id_person
     * @return PDOStatement
     */
    public function getJobById_person(int $id_person): PDOStatement
    {
        $pdo = Connect::getPDO();
        $job = $pdo->prepare("SELECT 
        COALESCE(d.id_director, a.id_actor) AS id_job,
        CASE 
            WHEN d.id_director IS NOT NULL AND a.id_actor IS NOT NULL THEN 'Réalisateur, Acteur'
            WHEN d.id_director IS NOT NULL THEN 'Réalisateur' 
            WHEN a.id_actor IS NOT NULL THEN 'Acteur' 
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

        return $job;
    }
    /**
     * On crée un tableau de tous les nom, prénom des personnes à partir de PDOStatement
     * S'il y a plus d'un éléments,on convertir le tableau en chaine de caractère
     * de tous les genres avec un séparateur "," sauf le dernier
     *
     * @param [PDOStatement] $pdoStat person
     * @return string HTML
     */
    public function makeStringFromFetch(PDOStatement $pdoStat): string
    {
        $fullName = [];
        $nameString = null;
        // On recherche les résultats de PDOStatement      
        $result = $pdoStat->fetchAll();
        // On bucle sur les résultats
        foreach ($result as $per) {
            // On crée un lien vers les détails du profils a partir de l'id_person
            $per = "<a href='./index.php?action=showDetailsPerson&id="  . $per['id_person'] . "' >" . $per['lastName'] . $per['firstName'] . "</a>";
            $fullName[] = $per;
        }
        // S'il y a plusieurs éléments au tableau
        if (count($fullName) > 1) {
            // On retir le derniers élément
            $lastFullName = array_pop($fullName);
            // On joinds les éléments avec un séparateur pour les affichés correctement
            $nameString = implode(', ', $fullName) . ' et ' . $lastFullName;
        } else {
            $nameString = implode(', ', $fullName);
        }
        // On retourne la chaine formater 
        return $nameString;
    }
    public function showDetailsPerson($id_person): void
    {
        $pdo = Connect::getPDO();
        $person = $pdo->prepare("SELECT 
        DATE_FORMAT(p.birthday, '%Y/%m/%d') AS birthday,
        p.id_person,
        p.lastName,
        p.firstName,
        p.sex,
        p.image_url
        FROM person p
        WHERE p.id_person = :person_id");
        $person->execute(["person_id" => $id_person]);

        $this->getJobById_person($id_person);

        require "view/person.php";
    }
    public function listActors(): void
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%Y/%m/%d') AS birthday,
        p.id_person,
        p.lastName, 
        p.firstName, 
        p.sex,
        p.image_url
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person 
        ORDER BY p.lastName ASC");

        require "view/person.php";
    }
    public function listDirectors(): void
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%Y/%m/%d') AS birthday,
        p.id_person,
        p.lastName, 
        p.firstName, 
        p.sex,
        p.image_url
        FROM director d
        INNER JOIN person p ON d.id_person = p.id_person
        ORDER BY p.lastName ASC");

        require "view/person.php";
    }
    public function actorsOver50Years()
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%d/%m/%Y') AS birthday, 
        p.id_person,
        p.lastName, 
        p.firstName, 
        YEAR(CURDATE()) - YEAR(birthday) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthday, '%m%d')) AS age_revolu,
        YEAR(CURDATE()) - YEAR(birthday) + IF(DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthday, '%m%d'), -1, 0) AS age_non_revolu,
        p.sex,
        p.image_url
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person
        WHERE YEAR(CURDATE()) - YEAR(birthday) > 50");

        require "view/person.php";
    }
    public function actorAndDirector()
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT 
        DATE_FORMAT(p.birthday, '%Y/%m/%d') AS birthday,
        p.id_person,
        p.lastName, 
        p.firstName, 
        p.sex,
        p.image_url
        FROM person p
        INNER JOIN director d ON d.id_person = p.id_person
        INNER JOIN actor a ON a.id_person = p.id_person");

        require "view/person.php";
    }
}
