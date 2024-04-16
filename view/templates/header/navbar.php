<?php ob_start(); ?>
    <nav class="navbar">
        <ul class="d-flex justify-content-center" >
            <li><a href="./index.php?action=listMovies" class="pridi-regular">FILMS</a></li>
            <li><a href="./index.php?action=listActors&table=actor" class="pridi-regular">ACTEURS</a></li>
            <li><a href="./index.php?action=listDirectors&table=director" class="pridi-regular">REALISATEURS</a></li>
            <li><a href="./index.php?action=listGenres" class="pridi-regular">GENRES</a></li>
        </ul>
    </nav>
<?php
$navbar = ob_get_clean();
require "./view/templates/navAdmin/navAdmin.php";


