<?php ob_start(); ?>

<div class="container">
    <div class="row">
        <table>
            <thead>
                <tr>
                    <th>Genres</th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($genres->fetchAll() as $genre) {
                ?>
                    <tr>
                        <td><?= $genre["nameGenre"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php

$title = "Liste des genres";
$second_title = "Liste des genres";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
