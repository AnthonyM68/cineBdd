<?php ob_start(); ?>

<div class="wrapper">
            <div class="container d-flex justify-content-center">
                <div class="jumbotron p-3 m-3 bg-white border">

                    <h1 class="display-1 mb-4 text-center">
                        <span class="font">
                            4
                        </span>

                        <i class="fa fa-spin fa-cog fa-3x"></i>
                        <span class="font">
                            4
                        </span>

                    </h1>
                    <h2 class="display-3 mb-4 text-center">
                        ERREUR
                    </h2>
                    <p class="lower-case font-weight-bold">
                        Aw !! page Web introuvable, veuillez essayer de rafraîchir
                    </p>
                    <p class="lower-case font-weight-bold">
                        Peut-être que la page n'existe pas
                    </p>
                </div>
            </div>
        </div>

<?php
$title = "404";
$second_title = "404";
$content = ob_get_clean();
require "view/templates/header/header.php";
