<?php ob_start();


?>
<div class="col-md-12 d-flex justify-content-center">
    <div class="row no-gutters">
        <div class="card-wrapper card_movie">
            <div class="card">
                <!-- card image -->
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne pour l'image -->
                        <div class="col-md-4">
                            <img src="<?= isset($movie["image_url"]) && $movie["image_url"] ? $movie["image_url"] : "" ?>" class="card-img" alt="...">
                        </div>
                        <!-- Colonne pour les informations -->
                        <div class="col-md-8">
                            <h5 class="card-title"><?= isset($movie["title"]) && $movie["title"] ? $movie["title"] : "" ?></h5>
                            <p class="card-text">
                                <small>Date de sortie:
                                    <?= isset($movie["releaseDate"]) && $movie["releaseDate"] ? $movie["releaseDate"] : "" ?>
                                </small>
                            </p>
                            <p class="card-text">
                                <small>Durée:
                                    <?= isset($movie["timeMovie"]) && $movie["timeMovie"] ? $movie["timeMovie"] : "" ?>
                                </small>
                            </p>
                            <p class="card-text">
                                <small>
                                    <?= isset($movie["synopsis"]) && $movie["synopsis"] ? $movie["synopsis"] : "" ?>
                                </small>
                            </p>
                            <div class="row">
                                <p class="card-text">Réalisateur:
                                    <?= $director ?>
                                </p>
                                <p class="card-text">Genre:
                                    <small><?= $genres ? $genres : "" ?></small>
                                </p>
                                <p class="card-text">Casting:</p>

                                <div class="card-group">
                                    <?php
                                    if (isset($casting) && !empty($casting)) {
                                        foreach ($casting as $actor) { ?>
                                            <div class="card casting-card-image h-90 d-flex align-items-center">
                                                <img class="card-img " src="<?= $actor['image_url'] ?>" alt="Card image casting">
                                                <div class="card-body w-100">
                                                    <h5 class="card-title"><a href="./index.php?action=showDetailsPerson&id=<?= $actor['id_person'] ?>"><?= $actor['firstName'] ." " . $actor['lastName'] ?></a></h5>
                                                    <p class="card-text">Genre: <?= $actor['sex'] ?></p>
                                                    <p class="card-text">Role: <small class="text-muted"><?= $actor['nameRole'] ?></small></p>
                                                </div>
                                            </div>
                                    <?php }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
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
require "view/templates/header/navbar.php";
