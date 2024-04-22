<?php ob_start(); ?>

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
                            <img src='<?= isset($movie["image_url"]) && $movie["image_url"] ? $movie["image_url"] : '' ?>' class="img_card" alt="">
                        </div>
                    </div>
                    <!-- card content -->
                    <div class="col-md-8">
                        <div class="card-body h-100">
                            <p class="card-title">
                                <!-- title and timeMovie -->
                                <span class="left-span">

                                    <!-- link show details movie -->
                                    <a href="./index.php?action=showDetailsMovie&id=
                                        <?= isset($movie["id_movie"]) && $movie['id_movie'] ? $movie['id_movie'] : "" ?>" class="pridi-light">

                                        <?= isset($movie["title"]) && $movie["title"] ? $movie["title"] : "" ?>
                                    </a>
                                </span>
                                <!-- timeMovie -->
                                <span class="right-span"><small class="pridi-light"><?= isset($movie["timeMovie"]) && $movie["timeMovie"] ? $movie["timeMovie"] : "" ?></small></span>
                            </p>
                            
                            <p class="card-text pridi-extralight "><?= isset($movie["synopsis"]) && $movie["synopsis"] ? $movie["synopsis"] : "" ?></p>
                        </div>
                        <!-- card footer -->
                        <div class="footer_custom" style="margin-top: -60px;">

                            <div class="d-flex justify-content-between w-100">
                                <!-- Url modify détails movie -->
                                <a href="./index.php?action=insertMovieForm&id=<?= $movie['id_movie'] ? $movie['id_movie'] : "" ?>" 
                                    class="btn btn-custom btn-sm mr-2">
                                    <i class="fa fa-edit fa-lg mr-1" aria-hidden="true"></i> Modifier
                                </a>
                                <!-- Url delete movie -->
                                <a href="./index.php?action=deleteMovie&id=<?= isset($movie['id_movie']) && $movie['id_movie'] ? $movie['id_movie'] : "" ?>" 
                                    class="btn btn-custom btn-sm mr-2">
                                    <i class="fa fa-minus-circle fa-lg mr-1" aria-hidden="true"></i> Supprimer
                                </a>
                                <!-- url add casting to movie -->
                                <a href="./index.php?action=insertCastingForm&id=<?= isset($movie['id_movie']) && $movie['id_movie'] ? $movie['id_movie'] : "" ?>" 
                                    class="btn btn-custom btn-sm ">
                                    <i class="fa fa-plus-circle fa-lg mr-1" aria-hidden="true"></i> Casting
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } 

$title = "Liste des films";
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";
