<?php ob_start();

isset($details)  ? $movie = $details->fetch() : $movie = null;
isset($_GET['id']) ? $id = $_GET['id'] : $movie = null;

var_dump($movie);

?>
<div class="container">
    <div class="row">

        <form action="./index.php?action=addMovie<?= isset($id) ? "&id=$id" : "" ?>" method="post">
            <div class="mb-4">

                <h3 class="pridi-light">Réalisateur</h3>

                <div class="row person">
                    <div class="col">
                        <div class=" mb-4">
                            <input name="firstName" class="form-control" type="text" value="<?= isset($movie) ? $movie['firstName'] : "" ?>" placeholder="First name">
                        </div>
                        <label class="pridi-light" for="birthday">Date Anniverssaire</label>
                        <input name="birthday" class="form-control" type="date" value="<?= isset($movie) ? $movie['birthday'] : "" ?>" />
                    </div>

                    <div class="col">
                        <div class="mb-4">
                            <input name="lastName" class="form-control" type="text" value="<?= isset($movie) ? $movie['lastName'] : "" ?>" placeholder="Last name">
                        </div>
                        <label class="pridi-light" for="sex">Genre</label>
                        <select name="sex" class="form-select">
                            <option value="M" <?= (isset($movie) && $movie['sex'] == 'M') ? 'selected' : '' ?>>Homme </option>
                            <option value="F" <?= (isset($movie) && $movie['sex'] == 'F') ? 'selected' : '' ?>>Femme</option>
                        </select>
                    </div>

                    <div class="text-center mb-4 mt-4">
                        <div class="form-check form-check-inline">
                            <input name="director" class="form-check-input" type="checkbox" value="<?= (isset($movie) && $movie['id_director'] ? $movie['id_director'] : '') ?>" <?= (isset($movie) && $movie['id_director']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="director">
                                Réalisateur
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="actor" class="form-check-input" type="checkbox" value="">
                            <label class="form-check-label" for="actor">
                                Acteur
                            </label>
                        </div>
                    </div>
                    <div class=" mb-4 mt-4">
                        <label class="pridi-light" for="image_url_profil">Image Profil</label>
                        <input name="image_url_profil" class="form-control" type="text" value="<?= isset($movie) ? $movie['image_url_profil'] : "" ?>" placeholder="http://localhost/">
                    </div>
                </div>

                <div class=" row">
                    <div class="col">
                        <h3 class="pridi-light">Film:</h3>
                        <div class=" mb-4">
                            <label class="pridi-light" for="title">Titre du Film</label>
                            <input name="title" class="form-control" type="text" value="<?= isset($movie) ? $movie['title'] : "" ?>" placeholder="title movie">
                        </div>
                        <label class="pridi-light" for="releaseDate">Date de sortie</label>
                        <input name="releaseDate" class="form-control" type="date" value="<?= isset($movie) ? $movie['releaseDate'] : "" ?>" />
                    </div>

                    <div class="col">
                        <div class="mb-4">
                            <label class="pridi-light" for="timeMovie">Durée</label>
                            <input name="timeMovie" class="form-control" type="text" value="<?= isset($movie) ? $movie['timeMovie'] : "" ?>" placeholder="00H00">
                        </div>
                        <label class="pridi-light" for="genres[]">Genre</label>
                        <select name="genres[]" class="form-select" multiple>
                            <option value="" disabled selected>Genre</option>
                            <?php foreach ($genres->fetchAll() as $genre) { ?>
                                <option value="<?= ($genre && $genre['id_genre']) ? $genre['id_genre'] : '' ?>" <?= ($genre && isset($genre['selected'])) ? 'selected' : '' ?>> <?= $genre['nameGenre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-4 mt-4">
                        <label class="pridi-light" for="image_url_movie">Cover</label>
                        <input name="image_url_movie" class="form-control" type="text" value="<?= isset($movie) ? $movie['image_url_movie'] : "" ?>" placeholder="http://localhost/">
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="synopsis" class="pridi-light">Synopsis</label>
                        <textarea class="form-control" name="synopsis" rows="5"><?= isset($movie) ? $movie['synopsis'] : "" ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mb-4">Soumettre</button>
        </form>

    </div>
</div>
<?php

$title = "Ajouter un film";
$second_title = "Ajouter un film";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
