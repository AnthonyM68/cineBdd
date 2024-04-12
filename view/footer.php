<?php ob_start(); ?>
<div class="container-fluid footer-content">
    <div class="row">
        <!-- Galery social -->
        <div class="col-md-6">
            <h4>Rejoignez-nous</h4>
            <div id="galery-social">
                <figure>
                    <img src="./public/img/social/facebook.png" alt="logo social network facebook">
                </figure>
                <figure>
                    <img src="./public/img/social/in.png" alt="logo social network in">
                </figure>
                <figure>
                    <img src="./public/img/social/instagram.png" alt="logo social network instagram">
                </figure>
                <figure>
                    <img src="./public/img/social/x.png" alt="logo social network x tweeter">
                </figure>

            </div>
        </div>
        <!-- Newsletter -->
        <div class="col-md-6">
            <h4>Newsletter</h4>
            <div id="newsletter">
                <form class="content-form">
                    <div class="form-group">
                        <label for="newsletter-name" class="hidden">Name</label>
                        <input type="name" class="form-control" id="newsletter-name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="newsletter-email" class="hidden">Email address</label>
                        <input type="email" class="form-control" id="newsletter-email" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-default btn-block btn-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$footer = ob_get_clean();
require "view/template.php";
