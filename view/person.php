<?php
ob_start();

use Controller\PersonController;
use Controller\CinemaController;

?>

<!-- loop from results -->
<?php foreach ($dataPersonMovie as $person) {
?>
    <div class="col-md-4 mb-3 d-flex justify-content-center">

        <div class="card">
            <div class="row no-gutters">
                <!-- card image -->
                <div class="col-md-5">
                    <div class="card-image">
                        <!-- img person -->
                        <?php if ($person["image_url"] !== null) { ?>
                            <img src='<?= $person["image_url"] ?>' class="border rounded img-fluid" alt="Image de profil">
                        <?php } ?>
                    </div>
                </div>
                <!-- card content -->
                <div class="col-md-7  align-items-center">
                    <div class="card-body d-flex flex-column justify-content-center h-100">
                        <!-- card title -->
                        <h5 class="card-title">
                            <a href="./index.php?action=showDetailsPerson&id=<?= $person['id_person'] ?>"><?= $person["fullname"] ?></a>
                        </h5>
                        <!-- display infos -->
                        <p class="card-text">Date de naissance: <?= $person['birthday'] ?></p>
                        <?php $sexe = $person["sex"] === "F" ? "Femme" : "Homme"; ?>
                        <p class="card-text"><?= $sexe ?></p>
                    </div>
                </div>
                <div class="col-md-12 mt-1">
                    <div class="footer_profil pridi-light text-align-left">
                        Films joués: <?= isset($person['movies']) && $person['movies'] ? $person['movies'] : "" ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php }

$title = "Liste des Acteurs (" . (is_countable($dataPersonMovie) ? count($dataPersonMovie) : "") . ")";

$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
