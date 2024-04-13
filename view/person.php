<?php ob_start();

// listDirectors
// listActors
$type;

if (isset($_GET['action'])) {
    $_GET['action'] == 'listActors' ? $type = 'Acteurs' : $type = 'Réalisateurs';
?>
    <div class="container">
        <div class="row">
            <?php foreach ($person->fetchAll() as $per) {
            ?>
                <div class="col-md-6 ">
                    <div class="card-wrapper">
                        <div class="card">
                            <!-- card image -->
                            <div class="card-image">
                                <!-- img movie -->
                                <?php
                                if ($per["image_url"] !== null) {
                                ?> <img src='<?= $per["image_url"] ?>' class="img_card" alt=""> <?php
                                                                                            } ?>
                            </div>
                            <!-- card content -->
                            <div class="card-body">
                                <p class="card-title">
                                    <!-- title and timeMovie -->
                                    <span class="left-span"><?= $per["lastName"] ?></span>
                                    <span class="right-span"><?= $per["firstName"] ?></span>
                                </p>
                                <p class="card-text"><?= $per["sex"] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>
<?php
} else { ?>
    <div class="container">
    <div class="row">
       <?php
       var_dump("Une personne");
       ?>
    </div>
</div>
<?php
}
?>
<?php

$title = "Liste des " . $type;
$second_title = "Liste des " . $type;
$content = ob_get_clean();
require "view/templates/header/header.php";
