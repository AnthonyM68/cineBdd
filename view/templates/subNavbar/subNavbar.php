<?php ob_start(); ?>
    <nav class="navbar">
        <ul>
            <li><a href="#" class="pridi-regular">NOUVEAUX FILMS</a></li>
            <li><a href="#" class="pridi-regular">NOUVEAUX ACTEURS</a></li>
            <li><a href="#" class="pridi-regular">NOUVEAUX REALISATEURS</a></li>
        </ul>
    </nav>
<?php
$subNavbar = ob_get_clean();
require "./view/templates/footer/footer.php";
