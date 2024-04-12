<?php ob_start(); ?>
    <nav class="navbar">
        <ul>
            <li><a href="#" class="pridi-regular">FILMS</a></li>
            <li><a href="#" class="pridi-regular">ACTEURS</a></li>
            <li><a href="#" class="pridi-regular">REALISATEURS</a></li>
            <li><a href="#" class="pridi-regular">GENRES</a></li>
        </ul>
    </nav>
<?php
$header = ob_get_clean();
require "view/subNavbar.php";
