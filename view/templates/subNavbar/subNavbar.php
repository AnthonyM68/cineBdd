<?php ob_start(); ?>
    <nav class="navbar">
        <ul>
            <li><a href="./index.php?action=moviesUnder5Years" class="pridi-regular">FILMS MOINS DE 5 ANS</a></li>
            <li><a href="./index.php?action=moviesMoreThan2H15" class="pridi-regular">FILMS + de 2H15 min</a></li>
            <li><a href="#" class="pridi-regular">ACTEURS + 50 ANS</a></li>
        </ul>
    </nav>
<?php
$subNavbar = ob_get_clean();
require "./view/templates/footer/footer.php";
