<?php ob_start(); ?>
    <nav class="navbar">
        <ul>
            <li><a href="./index.php?action=listMovies" class="pridi-regular">FILMS</a></li>
            <li><a href="./index.php?action=listActors" class="pridi-regular">ACTEURS</a></li>
            <li><a href="./index.php?action=listDirectors" class="pridi-regular">REALISATEURS</a></li>
            <li><a href="./index.php?action=listGenres" class="pridi-regular">GENRES</a></li>
        </ul>
    </nav>
<?php
$header = ob_get_clean();
require "./view/templates/navAdmin/navAdmin.php";


