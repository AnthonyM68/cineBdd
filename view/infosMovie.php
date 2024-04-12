<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Il y a <?= $requete->rowCount() ?> films</p>
<table>
    <thead>
        <tr>
            <th>Titre du film</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Sexe</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($requete->fetchAll() as $casting) {
        ?>
            <tr>
                <td><?= $casting["title"] ?></td>
                <td><?= $casting["lastName"] ?></td>
                <td><?= $casting["firstName"] ?></td>
                <td><?= $casting["date_naissance"] ?></td>
                <td><?= $casting["sex"] ?></td>
                <td><?= $casting["nameRole"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$title = "Casting du film";
$second_title = "Casting du film";
$content = ob_get_clean();
require "view/template.php";
