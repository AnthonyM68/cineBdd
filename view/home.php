<?php ob_start(); ?>

<div class="container">
    <div class="row">
        <?php foreach ($movies->fetchAll() as $movie) {
        ?>
            <div class="col-md-6 ">
                <div class="card-wrapper card_movie">
                    <div class="card">
                        <!-- card image -->
                        <div class="card-image">
                            <!-- img movie -->
                            <img src='<?= isset($movie["image_url"]) && $movie["image_url"] ? $movie["image_url"] : '' ?>'class="img_card" alt="">
                        </div>
                        <!-- card content -->
                        <div class="card-body">
                            <p class="card-title">
                                <!-- title and timeMovie -->
                                <span class="left-span">
                                    <!-- link show details movie -->
                                    <a href="./index.php?action=showDetailsMovie&id=<?= isset($movie["id_movie"]) && $movie['id_movie'] ? $movie['id_movie'] : "" ?>">
                                    <?= isset($movie["title"]) && $movie["title"] ? $movie["title"] : "" ?>
                                    </a>
                                </span>
                                <span class="right-span"><?= isset($movie["timeMovie"]) && $movie["timeMovie"] ? $movie["timeMovie"] : "" ?></span>
                            </p>
                            <p class="card-text"><?= isset($movie["synopsis"]) && $movie["synopsis"] ? $movie["synopsis"] : "" ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>
<?php

$title = "CineBdd";
$second_title = "À la une";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
