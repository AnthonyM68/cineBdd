<?php 
ob_start();

use Controller\PersonController;
use Controller\CinemaController;

$fullName = null;
$admin = true;

?>
<div class="container">
    <div class="row">
        <!-- loop from results -->
        <?php foreach ($persons as $per) {
            ?>
            <div class="col-md-6 mb-4">
                <div class="card card_profil">
                    <div class="row no-gutters">
                        <!-- card image -->
                        <div class="col-md-4">
                            <div class="card-image img_profil">
                                <!-- img person -->
                                <?php if ($per["image_url"] !== null) { ?>
                                    <img src='<?= $per["image_url"] ?>' class="border rounded" alt="Image de profil">
                                <?php } ?>
                            </div>
                        </div>
                        <!-- card content -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <!-- card title -->
                                <h5 class="card-title">
                                    <!-- display job -->
                                    <?php
                                    //$job = $ctrlPerson->getJobById_person($per['id_person'])->fetch();
                                    $fullName = $per["fullname"]; ?><a
                                        href="./index.php?action=showDetailsPerson&id=<?= $per['id_person'] ?>">
                                        <?= $fullName ?></a>
                                </h5>
                                <!-- display infos -->

                                <p class="card-text">Date de naissance: <?= $per['birthday'] ?></p>
                                <?php $sexe = $per["sex"] === "F" ? "Femme" : "Homme"; ?>
                                <p class="card-text"><?= $sexe ?></p>
                            
                                    <div class="footer_custom">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="./index.php?action=deletePerson&id=<?= isset($per['id_person']) && $per['id_person'] ? $per['id_person'] : "" ?>"
                                                    class="btn btn-custom btn-sm mr-2">
                                                    <i class="fa fa-minus-circle fa-lg mr-1" aria-hidden="true"></i>SUPPRIMER
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                             

                            </div>
                        </div>

                    </div>
                    <!-- display movies played  -->
                    <div class="row no-gutters">*
                        <div class="col-md-12">
                            <div class="footer_profil pridi-light text-align-left">
                                Films joués:
                                <?php
                                /*if (isset($per['id_actor'])) {
                                    echo $this->getMoviesAndRoleByActor($per['id_actor']);
                                } else {
                                    echo $this->getMoviesByDirector($per['id_person']);
                                }*/
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
$title = "Liste des Acteurs (" . count($persons) . ")";
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
