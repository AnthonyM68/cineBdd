<?php ob_start(); ?>

<div class="container">
    <div class="row">
        <form action="./index.php?action=insertCastingForm&id=<?= $id ?>" method="post">
            <div class="row mb-4">

                <div class="col">
                    <select name="id_actor" class="form-select">
                        <option value="" disabled selected>Acteurs</option>
                        <?php foreach ($actors->fetchAll() as $actor) { ?>
                            <option value="<?= $actor['id_actor'] ?>"><?= $actor['fullname'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col">
                    <select name="id_role" class="form-select">
                        <option value="" disabled selected>Rôles</option>
                        <?php foreach ($roles->fetchAll() as $role) { ?>
                            <option value="<?= $role['id_role'] ?>"><?= $role['nameRole'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4">Soumettre</button>
        </form>
    </div>
</div>
<?php

$title = "Ajouter un casting";
$second_title = "Ajouter un casting";
$content = ob_get_clean();
require "view/templates/header/navbar.php";
