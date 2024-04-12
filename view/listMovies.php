<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Il y a <?= $requete->rowCount() ?> films</p>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>ANNEE SORTIE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($requete->fetchAll() as $movie) {
        ?>
            <tr>
                <td><?= $movie["title"] ?></td>
                <td><?= $movie["releaseDate"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$title = "Liste des films";
$second_title = "Liste des films";
$content = ob_get_clean();
require "view/template.php";