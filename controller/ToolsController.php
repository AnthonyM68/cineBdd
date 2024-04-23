<?php

namespace Controller;

use PDOStatement;
use DateTime;

use Model\Connect;

abstract class ToolsController
{
    protected function convertToMinutes($timeString)
    {
        $parts = explode('H', mb_strtolower($timeString));
        $hours = intval($parts[0]);
        $minutes = 0;

        if (isset($parts[1])) {
            $minutesPart = explode('m', $parts[1]);
            $minutes = intval($minutesPart[0]);
        }
        $totalMinutes = $hours * 60 + $minutes;
        return $totalMinutes;
    }
    protected function convertToString(array $infos, string $typeLink): string
    {
        $html = '';
        $listElements = [];
        switch ($typeLink) {
            case 'detailsMovieLink':
                foreach ($infos as $movie) {
                    $listElements[] = "<a href='./index.php?action=showDetailsMovie&id=" . $movie['id_movie'] . "'>" . $movie['title'] . "</a>";
                }
                break;
            case 'casting':
                foreach ($infos as $casting) {
                  
                    $listElements[] = "<a href='./index.php?action=showDetailsPerson&id=" . $casting['id_person'] ."'>" . $casting['firstName'] . $casting['lastName'] ."</a>";
                }
                break;
            case 'genres':
                foreach ($infos as $genre) {
                    $listElements[] = "<span>" . $genre['nameGenre'] . "</span>";
                }
                break;
        }

        if (count($listElements) > 1) {
            $lastLink = array_pop($listElements);
            $titleString = implode(', ', $listElements) . ' et ' . $lastLink;
        } else {
            $titleString = implode(', ', $listElements);
        }

        $html = '<small>' . $titleString . '</small>';

        return $html;
    }
    protected function getMoviesAndRoleByActor($id_actor)
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

        $movies = $this->convertToString($movies, "detailsMovie");

        return $movies;
    }

    protected function getMoviesByDirector($id_person)
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

        $movies = $this->convertToString($movies, "detailsMovie");

        return $movies;
    }
}
