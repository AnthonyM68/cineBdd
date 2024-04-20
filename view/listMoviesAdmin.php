<?php ob_start();
?>
<?php foreach ($movies as $movie) { ?>
    <div class="col-lg-12 mb-4">
        <!-- card wrapper -->
        <div class="card-wrapper">
            <div class="card">
                <!-- no marge -->
                <div class="row no-gutters">
                    <!-- card image -->
                    <div class="col-md-4">
                        <div class="card-image">
                            <!-- img movie -->
                            <img src='<?= isset($movie["image_url"]) && $movie["image_url"] ? $movie["image_url"] : ''?>' class="img_card" alt="">
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
                                <!-- timeMovie -->
                                <span class="right-span"><?= $movie["timeMovie"] ?></span>
                            </p>
                            <p class="card-text"><?= $movie["synopsis"] ?></p>
                        </div>
                        <!-- card footer -->
                        <div class="card-footer" style="margin-top: -60px;">
                            <div class="d-flex justify-content-between w-100">
                                <a href="./index.php?action=insertMovieForm&id=<?= $movie['id_movie'] ?>" class="btn btn-success btn-sm mr-2"><i class="fa fa-edit fa-2x" aria-hidden="true"></i> Modifier</a>
                                <a class="btn btn-danger btn-sm mr-2"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i> Supprimer</a>
                                <a href="./index.php?action=insertCastingForm&id=<?= $movie['id_movie'] ?>" class="btn btn-warning btn-sm "><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i> Casting</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>









<?php

$title = "Liste des films";
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
