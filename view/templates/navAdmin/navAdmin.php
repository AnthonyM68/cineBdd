<?php ob_start(); ?>
<nav id="navAdmin">
    <ul>
        <li><i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></li>
        <li><i class="fa fa-user fa-2x" aria-hidden="true"></i></li>
        <li><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></li>
    </ul>
</nav>
<?php
$navAdmin = ob_get_clean();
require "./view/templates/sideNav/sideNav.php";

