<?php ob_start();

$fullName = null;
use Controller\PersonController;
$ctrlPerson = new PersonController();

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
                        ?> <img src='<?= $per["image_url"] ?>' class="img_card" alt=""> 
                        <?php } ?>
                    </div>
                    <!-- card content -->
                    <div class="card-body">
                        <p class="card-title">
                        <div class="row">
                            <div class="col">
                                <a href="./index.php?action=showDetailsPerson&id=<?= $per['id_person'] ?>"><?= $fullName = $per["firstName"] . " " . $per["lastName"]; ?></a>
                                <p>
                                <?php 
                                $job = $ctrlPerson->getJobById_person($per['id_person']);
                                $job = $job->fetch();
                                $description = $job['description'];
                                ?>
                                <p><?= $description ?></p>
                            </div>
                            <div class="col">
                                <p>Date de naissance: <?= $per['birthday'] ?></p>
                            </div>
                            <div class="col">
                                <?php
                                $sexe = "Femme";
                                $per["sex"] === "F" ? $sexe = $sexe : $sexe = "Homme";
                                ?>
                                <p><?= $sexe ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php }
        ?>
    </div>
</div>

<?php

$switch = $ctrlPerson->switchTitlePage();
// Si nous présentons une personne nous affichons lastName et firstName comme un titre de page
$switch === "" ? $title = $fullName : $title = $switch;
$second_title = $title;

$content = ob_get_clean();
require "view/templates/header/navbar.php";
