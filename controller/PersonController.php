<?php

namespace Controller;

use Model\Connect;

class PersonController 
{
    public function index()
    {
        require "view/person.php";
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

        $result = $pdoStat->fetchAll();
        $fullName = [];
        $nameString = null;

        foreach($result as $person) {
            $person = "<a href='#'>" . $person['firstName'] . " " . $person['lastName'] . "</a>";
            $fullName[] = $person;
        }
        
        if (count($fullName) > 1 ) {
            $lastFullName = array_pop($fullName);
            $nameString = implode(', ', $fullName) . ' et ' . $lastFullName;
        } else {
            $nameString = implode(', ', $fullName);
        }
        return $nameString;
    }
    public function listActors()
    {
        $person = Connect::getPDO();
        $person = $person->query("SELECT p.lastName, p.firstName, 
        DATE_FORMAT(p.birthday, '%Y-%m-%d') AS birthday,
        p.sex,
        p.image_url
        FROM actor a
        INNER JOIN person p ON a.id_person = p.id_person ");

        require "view/person.php";
    }
    public function listDirectors()
    {
        $person = Connect::getPDO();
        $person = $person->query("SELECT p.lastName, p.firstName, 
        DATE_FORMAT(p.birthday, '%Y-%m-%d') AS birthday,
        p.sex,
        p.image_url
        FROM director d
        INNER JOIN person p ON d.id_person = p.id_person ");

        require "view/person.php";
    }
}
