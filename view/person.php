<?php ob_start();

$fullName = null;

use Controller\PersonController;
use Controller\CinemaController;

$ctrlPerson = new PersonController();
$ctrlCinema = new CinemaController();

?>
<div class="container">
    <div class="row">
        <!-- loop from results -->
        <?php foreach ($person->fetchAll() as $per) {
        ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="row no-gutters">
                        <!-- card image -->
                        <div class="col-md-6">
                            <div class="card-image img_profil">
                                <!-- img person -->
                                <?php if ($per["image_url"] !== null) { ?>
                                    <img src='<?= $per["image_url"] ?>' class="border rounded" alt="Image de profil">
                                <?php } ?>
                            </div>
                        </div>
                        <!-- card content -->
                        <div class="col-md-6">
                            <div class="card-body">
                                <!-- card title -->
                                <h5 class="card-title">
                                    <!-- display job -->
                                    <?php
                                    $job = $ctrlPerson->getJobById_person($per['id_person'])->fetch();
                                    $description = $job['description'];?>
                                    <a href="./index.php?action=showDetailsPerson&id=<?= $per['id_person'] ?>&table=<?= $description ?> "> <?= $fullName = $per["firstName"] . " " . $per["lastName"] . "</a>" ?>
                                </h5>
                                <?php $description === "actor" ? $description = "Acteur" : $description = "Réalisateur"?>
                                <!-- display infos -->
                                <p class="card-text"><?= $description ?></p>
                                <p class="card-text">Date de naissance: <?= $per['birthday'] ?></p>
                                <?php $sexe = $per["sex"] === "F" ? "Femme" : "Homme"; ?>
                                <p class="card-text"><?= $sexe ?></p>
                            </div>
                        </div>
                        <!-- display movies played  -->
                        <div class="row">
                            <div class="footer_profil border text-align-left">
                                Films joués:
                                <?php
                                if (isset($per['id_actor'])) {
                                    echo $ctrlCinema->getMoviesAndRoleByActor($per['id_actor']);
                                } else {
                                    echo $ctrlCinema->getMoviesByDirector($per['id_person']);
                                }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php

$switch = $ctrlPerson->switchTitlePage();
// If we present a person we display lastName and firstName as a page title
$switch === "" ? $title = $fullName : $title = $switch;
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
