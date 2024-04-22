<?php ob_start();

use Controller\PersonController;
use Controller\CinemaController;

$ctrlPerson = new PersonController();
$ctrlCinema = new CinemaController();

$fullName = null;

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
                                    $fullName = $per["fullname"]; ?><a href="./index.php?action=showDetailsPerson&id=<?= $per['id_person'] ?>">
                                        <?= $fullName ?></a>
                                </h5>
                                <!-- display infos -->

                                <p class="card-text">Date de naissance: <?= $per['birthday'] ?></p>
                                <?php $sexe = $per["sex"] === "F" ? "Femme" : "Homme"; ?>
                                <p class="card-text"><?= $sexe ?></p>
                            </div>
                        </div>

                    </div>
                    <!-- display movies played  -->
                    <div class="row no-gutters">*
                        <div class="col-md-12">
                            <div class="footer_profil pridi-light text-align-left">
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
$title = "Liste des Acteurs (" . $person->rowCount() . ")";
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
