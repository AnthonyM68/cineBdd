<?php ob_start();

use Controller\CinemaController;

$ctrlCinema = new CinemaController();
?>
<div class="container">
    <div class="row">
        <?php foreach ($movies as $movie) { ?>
            <div class="col-lg-12 mb-4">
                <div class="card-wrapper">
                    <div class="card border-0">
                        <div class="row no-gutters">
                            <!-- card image -->
                            <div class="col-md-4">
                                <div class="card-image">
                                    <!-- img movie -->
                                    <img src='<?= $movie["image_url"] ?>' class="img_card" alt="">
                                </div>
                            </div>
                            <!-- card content -->
                            <div class="col-md-8">

                                <div class="card-body h-100">
                                    <p class="card-title">
                                        <!-- title and timeMovie -->
                                        <span class="left-span">
                                            <!-- link show details movie -->
                                            <a href="./index.php?action=showDetailsMovie&id=<?= $movie["id_movie"] ?>"><?= $movie["title"] ?></a>
                                        </span>
                                        <span class="right-span"><?= $movie["timeMovie"] ?></span>
                                    </p>
                                    <p class="card-text"><?= $movie["synopsis"] ?></p>
                                     <!-- card footer -->
                                    <div class="card-footer h-100">
                                        <div class="row d-flex justify-content-between align-items-center">
                                            <a class="btn btn-success"><i class="fa fa-edit fa-2x" aria-hidden="true"></i> Modifier</a>
                                            <a class="btn btn-danger"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i> Supprimer</a>
                                            <a href="./index.php?action=insertCastingForm&id=<?= $movie['id_movie']?>" class="btn btn-warning"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i> Casting</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php

$title = "Liste des films";
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
