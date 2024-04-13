<?php ob_start(); 
$film = $movie->fetch();
?>
<h3><?= $film["title"] ?></h3>
<p class="uk-label uk-label-warning">Il y a <?= $casting->rowCount() ?> acteurs</p>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Sexe</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($casting->fetchAll() as $cast) {
        ?>
            <tr>
                <td><?= $cast["lastName"] ?></td>
                <td><?= $cast["firstName"] ?></td>
                <td><?= $cast["date_naissance"] ?></td>
                <td><?= $cast["sex"] ?></td>
                <td><?= $cast["nameRole"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$title = "Casting du film";
$second_title = "Casting du film";
$content = ob_get_clean();
require "view/template.php";
