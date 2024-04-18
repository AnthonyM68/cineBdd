<?php ob_start();?>

<div class="container">
    <div class="row">

        <form action="./index.php?action=addMovie" method="post">

            <div class="row mb-4 ">
                <div class="col">
                    <div class="input-group">

                        <label class="visually-hidden" for="newPerson">Personne</label>
                        <select id="newPerson" data-mdb-select-init class="select form-outline">
                            <?php foreach ($person->fetchAll() as $person) { ?>
                                <option value="<?= $person['id_person'] ?>"><?= $person['fullname'] ?></option>
                            <?php } ?>
                        </select>
                        <button id="addPerson" class="btn btn-outline-primary" type="button">+ Ajouter une nouvelle personne</button>

                    </div>
                </div>
            </div>

            <div class="mb-4 containerPerson">

                <h3 class="pridi-light">Réalisateur:</h3>

                <div class="row person">
                    <div class="col">
                        <div class=" mb-4">
                            <input name="firstName" class="form-control" type="text" placeholder="First name">
                        </div>
                        <label class="pridi-light" for="date">Date Anniverssaire</label>
                        <input name="birthday" class="form-control" type="date" />
                    </div>

                    <div class="col">
                        <div class="mb-4">
                            <input name="lastName" class="form-control" type="text" placeholder="Last name">
                        </div>
                        <select name="sex" class="form-select">
                            <option value="h">Homme</option>
                            <option value="f">Femme</option>
                        </select>
                    </div>
                    <div class="mb-4 mt-4">
                        <input name="image_url_profil" class="form-control" type="text" placeholder="Url Image profil">
                    </div>
                </div>

                <h3 class="pridi-light">Film:</h3>

                <div class="row">
                    <div class="col">
                        <div class=" mb-4">
                            <input name="title" class="form-control" type="text" placeholder="title movie">
                        </div>
                        <label class="pridi-light" for="date">Date de sortie</label>
                        <input name="releaseDate" class="form-control" type="date" />
                    </div>

                    <div class="col">
                        <div class="mb-4">
                            <input name="timeMovie" class="form-control" type="text" placeholder="time in minutes">
                        </div>
                        <select name="genre" class="form-select">
                            <option value="" disabled selected>Genre</option>
                            <?php foreach ($genres->fetchAll() as $genre) { ?>
                                <option value="<?= $genre['id_genre'] ?>"><?= $genre['nameGenre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-4 mt-4">
                        <input name="image_url_movie" class="form-control" type="text" placeholder="Url Image movie">
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="synopsis" class="form-label">Synopsis</label>
                        <textarea class="form-control" name="synopsis" rows="3"></textarea>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Soumettre</button>
        </form>

    </div>
</div>
<?php

$title = "Ajouter un film";
$second_title = "Ajouter un film";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
