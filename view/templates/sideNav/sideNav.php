<?php ob_start(); ?>
<ul class="d-flex flex-column">
    <li><a href="./index.php"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a></li>
    <li><a href="./index.php?action=searchEngine"><i class="fa fa-search fa-2x" aria-hidden="true"></i></a></li>
    <li><a href="./index.php?action=listMovieAdmin"><i class="fa fa-list-ol fa-2x" aria-hidden="true"></i></a></li>
    <li><a href="./index.php?action=insertMovie"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a></li>
</ul>
<?php
$sideNav = ob_get_clean();
require "./view/templates/subNavbar/subNavbar.php";
