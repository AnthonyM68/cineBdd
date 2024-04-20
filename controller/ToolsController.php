<?php

namespace Controller;

use PDOStatement;
use DateTime;

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
    protected function convertToString(PDOStatement $requestFetch, string $typeLink): string
    {
        $html = '';
        $listElements = [];
        switch ($typeLink) {
            case 'person':
                foreach ($requestFetch->fetchAll() as $person) {
                    $listElements[] = "<a href='./index.php?action=showDetailsPerson&id="
                        . $person['id_person'] . "&table=actor' >"
                        . $person['lastName'] . $person['firstName'] . "</a>";
                }
                break;
            case 'detailsMovie':
                foreach ($requestFetch->fetchAll() as $movie) {
                    $id_movie = $movie["id_movie"];
                    $listElements[] = "<a href='./index.php?action=showDetailsMovie&id=$id_movie'>"
                        . $movie["title"] . "</a>";
                }
                break;
            case 'genres':
                foreach ($requestFetch->fetchAll() as $genre) {
                    $listElements[] = "<span>" . $genre['nameGenre'] . "</span>";
                }
                break;
            default:
                return $html = '';
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
}
