<?php

namespace Controller;

use COM;
use Model\Connect;

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
    public function siwtchTitlePage()
    {
        $title = null;
        switch ($_GET['action']) {
            case "listActors":
                $title = "Liste Acteurs";
                break;
            case "listDirectors":
                $title = "Réalisateurs";
                break;
            default:
            $title = "";
        };
        return $title;
    }
    /**
     * On crée un tableau de tous les nom, prénom des personnes à partir de PDOStatement
     * S'il y a plus d'un éléments,on convertir le tableau en chaine de caractère
     * de tous les genres avec un séparateur "," sauf le dernier
     *
     * @param [PDOStatement] $pdoStat person
     * @return string HTML
     */
    public function makeStringFromFetch($pdoStat): string
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
    public function showDetailsPerson($id_person)
    {
        $pdo = Connect::getPDO();
        $person = $pdo->prepare("SELECT 
        p.id_person,
        p.lastName,
        p.firstName,
        p.birthday,
        p.sex,
        p.image_url
        FROM person p
        WHERE p.id_person = :person_id");
        $person->execute(["person_id" => $id_person]);

        $this->siwtchTitlePage();

        require "view/person.php";
    }
    public function listActors()
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT p.lastName, p.firstName, 
        DATE_FORMAT(p.birthday, '%Y-%m-%d') AS birthday,
        p.sex,
        p.image_url
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person ");

        $this->siwtchTitlePage();

        require "view/person.php";
    }
    public function listDirectors()
    {
        $pdo = Connect::getPDO();
        $person = $pdo->query("SELECT p.lastName, p.firstName, 
        DATE_FORMAT(p.birthday, '%Y-%m-%d') AS birthday,
        p.sex,
        p.image_url
        FROM director d
        INNER JOIN person p ON d.id_person = p.id_person ");

        $this->siwtchTitlePage();

        require "view/person.php";
    }
}
