<?php
namespace Controller;

use PDOStatement;

abstract class ToolsController
{    
    /**
     * On crée un tableau de tous les genres à partir de PDOStatement
     * S'il y a plus d'un éléments,on convertir le tableau en chaine de caractère
     * de tous les genres avec un séparateur "," sauf le dernier
     *
     * @param [PDOStatement] $pdoStat genres
     * @return string HTML
     */
    /*private function makeStringFromFetch(PDOStatement $casting): string
    {

        $result = $casting->fetchAll();
        $nameGenre = array_column($result, 'nameGenre');

        if (count($nameGenre) > 1) {
            $lastGenre = array_pop($nameGenre);
            $genresString = implode(', ', $nameGenre) . ' et ' . $lastGenre;
        } else {
            $genresString = implode(', ', $nameGenre);
        }

        $html = '<small>' . $genresString . '</small>';

        return $html;
    }*/
    protected function makeStringFromFetchWithLink(PDOStatement $movies): string
    {
        $html = "";
        $listLinks = [];
        foreach ($movies->fetchAll() as $movie) {
            $id_movie = $movie["id_movie"];
            $listLinks[] = "<a href='./index.php?action=showDetailsMovie&id=$id_movie'>" . $movie["title"] . "</a>";
        }
        if (count($listLinks) > 1) {
            $lastLink = array_pop($listLinks);
            $titleString = implode(', ', $listLinks) . ' et ' . $lastLink;
        } else {
            $titleString = implode(', ', $listLinks);
        }
        $html = '<small>' . $titleString . '</small>';

        return $html;
    }
    protected function makeStringFromFetch(PDOStatement $pdoStat): string
    {
        $fullName = [];
        $nameString = null;
        // On recherche les résultats de PDOStatement      
        $result = $pdoStat->fetchAll();
        // On boucle sur les résultats
        foreach ($result as $per) {
            // On crée un lien vers les détails du profils a partir de l'id_person
            $per = "<a href='./index.php?action=showDetailsPerson&id="  . $per['id_person'] . "&table=actor' >" . $per['lastName'] . $per['firstName'] . "</a>";
            $fullName[] = $per;
        }
        // S'il y a plusieurs éléments au tableau
        if (count($fullName) > 1) {
            // On retire le derniers élément
            $lastFullName = array_pop($fullName);
            // On joinds les éléments avec un séparateur pour les affichés correctement
            $nameString = implode(', ', $fullName) . ' et ' . $lastFullName;
        } else {
            $nameString = implode(', ', $fullName);
        }
        // On retourne la chaine formater 
        return $nameString;
    }
}


