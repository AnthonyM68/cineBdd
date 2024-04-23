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
                                    <small>
                                        <a href="./index.php?action=showDetailsPerson&id=<?= isset($movie["id_person"]) && $movie["id_person"] ? $movie["id_person"] : "" ?>">
                                            <span>
                                                <?= isset($director["firstName"]) && $director["firstName"] ? $director["firstName"] : "" ?>
                                            </span>
                                            <span>
                                                <?= isset($director["lastName"]) && $director["lastName"] ? $director["lastName"] : "" ?>
                                            </span>
                                        </a>
                                    </small>
                                </p>
                                <p class="card-text">Genre:
                                    <small><?= $genres ?></small>
                                </p>
                                <p class="card-text">Acteurs:
                                    <small><? $casting ?></small>
                                </p>
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
