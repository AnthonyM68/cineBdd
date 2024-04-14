<?php ob_start();

use Controller\PersonController;

$ctrlPerson = new PersonController();
// listDirectors
// listActors
$fullName = null;
?>

<div class="container">
    <div class="row">
        <?php foreach ($person->fetchAll() as $per) {
        ?>
            <div class="col-md-6 d-flex justify-content-center">

                <div class="card">
                    <!-- card image -->
                    <div class="card-image">
                        <!-- img movie -->
                        <?php
                        if ($per["image_url"] !== null) {
                        ?> <img src='<?= $per["image_url"] ?>' class="img_card" alt=""> <?php
                                                                                        } ?>
                    </div>
                    <!-- card content -->
                    <div class="card-body">
                        <p class="card-title">
                            <!-- title and timeMovie -->
                            <span class="left-span"><?= $per["lastName"] ?></span>
                            <span class="right-span"><?= $per["firstName"] ?></span>

                            <?= $fullName = $per["lastName"] . " " . $per["firstName"]; ?>
                        </p>
                        <p class="card-text"><?= $per["sex"] ?></p>
                    </div>
                </div>

            </div>
        <?php }
        ?>
    </div>
</div>

<?php

$title = $ctrlPerson->siwtchTitlePage();
// Si nous présentons une personne nous affichons lastName et firstName comme un titre de page
$title === "" ? $title = $fullName : $title = "Liste des " . $title;
$title = $title;
$second_title = $title;

$content = ob_get_clean();
require "view/templates/header/header.php";
