<?php ob_start();

   
$title = "404";
$second_title = "404 Oup's, page introuvable!";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
