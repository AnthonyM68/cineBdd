<?php ob_start(); ?>

<div class="list-group">
    <?php foreach ($genres as $genre) : ?>
        <a href="#" class="list-group-item list-group-item-action"><?= $genre["nameGenre"] ?></a>
    <?php endforeach; ?>
</div>

<?php

$title = "Liste des genres";
$second_title = "Liste des genres";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
