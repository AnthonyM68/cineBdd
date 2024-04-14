<?php ob_start();
// On recherche les infos du film
$details = $details->fetch();
// On recherche les infos du réalisateur
$director = $director->fetch();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= $details['image_url'] ?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">

                        <h5 class="card-title"><?= $details['title'] ?></h5>
                        <p class="card-text"><small>Date de sortie: <?= $details['releaseDate'] ?></small></p>
                        <p class="card-text"><small>Durée: <?= $details['timeMovie'] ?></small></p>
                        <p class="card-text"><small><?= $details['synopsis'] ?></small></p>

                        <div class="row">
                            <p class="card-text">Réalisateur: <small><a href="./index.php?action=showDetailsPerson&id=<?= $details['id_person'] ?>"><span><?= $director['firstName'] ?></span><span><?= $director['lastName'] ?></span></a></small></p>
                            <p class="card-text">Genre: <small><?= $genres ?></small></p>
                            <p class="card-text">Acteurs: <small><?= $casting ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    $title = "Détails du film";
    $second_title = "Détails du film";
    $content = ob_get_clean();
    require "view/templates/header/header.php";
