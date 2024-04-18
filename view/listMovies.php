<?php ob_start(); 

?>
<div class="container">
    <div class="row">
        <?php foreach ($movies->fetchAll() as $movie) {
        ?>
            <div class="col-md-6 ">
                <div class="card-wrapper">
                    <div class="card">
                        <!-- card image -->
                        <div class="card-image">
                           <!-- img movie --> 
                            <img src='<?= $movie["image_url"] ?>' class="img_card" alt="">
                        </div>
                        <!-- card content -->
                        <div class="card-body">
                            <p class="card-title">
                                <!-- title and timeMovie -->
                                <span class="left-span">
                                    <!-- link show details movie -->
                                    <a href="./index.php?action=showDetailsMovie&id=<?= $movie["id_movie"] ?>"><?= $movie["title"] ?></a>
                                </span>
                                <span class="right-span"><?= $movie["timeMovie"] ?></span>
                            </p>
                            <p class="card-text"><?= $movie["synopsis"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>
<?php
$title = "Liste des films (" . $movies->rowCount() .")";
$second_title = $title;
$content = ob_get_clean();
require "view/templates/header/navbar.php";