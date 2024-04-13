<?php

namespace Controller;

use Model\Connect;

class PersonController
{
    public function index()
    {
        require "view/person.php";
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
    public function listDirector()
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
