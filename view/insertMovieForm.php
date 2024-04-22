<?php ob_start();

isset($details)  ? $movie = $details->fetch() : $movie = null;
isset($_GET['id']) ? $id = $_GET['id'] : $movie = null;
?>

<form id="newFormMovie" action="./index.php?action=editMovie<?= isset($id) ? "&id=$id" : "" ?>" method="post" class="row gx-3 needs-validation" novalidate>
    <fieldset>
        <legend class="pridi-regular">
            <h3>Détails du Réalisateur</h3>
        </legend>
        <div class="col-12">
            <div class="card mb-3">
                <div class="row g-0">

                    <div class="col-md-2">
                        <div class="d-flex justify-content-center align-items-center card-img-container">
                            <img class="img-fluid rounded-start imgPreview" src="#" alt="image profil" />
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">

                            <h5 class="card-title pridi-light">Réalisateur</h5>
                            <small class="pridi-extralight disclamer">(Il est aussi possible d'ajouter un Acteur, un Réalisateur ou une personne, sans pour autant entrer les informations d'un film)</small>

                            <div class="mb-1 mt-1 row gx-5">
                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?= isset($movie) ? $movie['firstName'] : '' ?>" autocomplete="off"  />
                                        <label for="firstName" class="form-label pridi-regular">First Name</label>
                                        <div class="invalid-feedback">First name is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?= isset($movie) ? $movie['lastName'] : '' ?>" autocomplete="off"  />
                                        <label for="lastName" class="form-label pridi-regular">Last Name</label>
                                        <div class="invalid-feedback">Last name is required.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 gx-5">

                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input id="birthday" name="birthday" class="datepicker form-control pridi-light" type="date" value="<?= isset($movie) ? $movie['birthday'] : "" ?>"  />
                                        <label class="form-label pridi-light" for="birthday">Date Anniverssaire</label>
                                        <div class="invalid-feedback">Birthday date is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select name="sex" class="form-control">
                                        <option value="" disabled selected>Genre</option>
                                        <option value="M" <?= (isset($movie) && $movie['sex'] == 'M') ? 'selected' : '' ?>>Homme</option>
                                        <option value="F" <?= (isset($movie) && $movie['sex'] == 'F') ? 'selected' : '' ?>>Femme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4 gx-5">

                                <div class="col-md-6 text-center ">

                                    <label for="image_url_profil" class="custom-file-upload">
                                        <input class="inputImg" id="image_url_profil" name="image_url_profil" accept="image/webp,image/jpeg" type='file'  />
                                        <span class="pridi-regular">CHOOSE IMAGE PROFIL</span>
                                    </label>

                                </div>

                                <div class="col-md-6 text-center ">

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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-2">
                        <div class="d-flex justify-content-center align-items-center card-img-container">
                            <img class="img-fluid rounded-start imgPreview" src="#" alt="image profil" />
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">

                            <h5 class="card-title pridi-light">Informations du Film</h5>

                            <div class="row mt-4 gx-5">
                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" id="title" name="title" class="form-control pridi-light""  value=" <?= isset($movie) ? $movie['title'] : "" ?>" autocomplete="off" />
                                        <label for="title" class="form-label pridi-regular">Title</label>
                                        <div class="invalid-feedback">Title is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="date" id="releaseDate" name="releaseDate" class="datepicker form-control pridi-light" value="<?= isset($movie) ? $movie['releaseDate'] : "" ?>" />
                                        <label class="form-label pridi-light" for="releaseDate">Date de sortie</label>
                                        <div class="invalid-feedback">Release date is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 gx-5">
                                <div class="col-md-6">
                                    <div class=" form-outline" data-mdb-input-init>
                                        <input type="text" name="timeMovie" class="form-control" value="<?= isset($movie) ? $movie['timeMovie'] : "" ?>" placeholder="00H00">
                                        <label class="form-label pridi-light" for="timeMovie">Durée</label>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <label for="image_url_movie" class="form-label custom-file-upload mt-4">
                                            <input class="inputImg" id="image_url_movie" name="image_url_movie" accept="image/webp,image/jpeg" type='file' />
                                            <span class="pridi-regular">CHOOSE IMAGE MOVIE</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select name="genres[]" class="form-control" multiple>
                                        <option value="" disabled selected>Genre</option>
                                        <?php foreach ($genres->fetchAll() as $genre) { ?>
                                            <option value="<?= ($genre && $genre['id_genre']) ? $genre['id_genre'] : '' ?>" <?= ($genre && isset($genre['selected'])) ? 'selected' : '' ?>> <?= $genre['nameGenre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 mt-4">
                                <div class=" form-outline" data-mdb-input-init>
                                    
                                    <textarea class="form-control" id="synopsis" name="synopsis" rows="5"><?= isset($movie) ? $movie['synopsis'] : "" ?></textarea>
                                    <label for="synopsis" class="form-label pridi-light">Synopsis</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </fieldset>

    <div class="row mt-4 text-center">
        <div class="col-md-12 ">
            <button class="btn btn-custom pridi-regular" type="submit" data-mdb-ripple-init>Submit </button>
        </div>

    </div>
</form>
<?php
$title = "Ajouter un film";
$second_title = "Ajouter un film";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
