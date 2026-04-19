<?php

use App\Controllers\TableController;

$tableController = new TableController();
$id = $_GET['id'];
$info = $tableController->getTableById($id) ?? [];
$table = $info['table'] ?? null;
$tableName = $info['name'] ?? null;
$creator = $info['creator'] ?? null;

?>
<div class="container my-4 w-75 mx-auto">
    <h5 class="mb-4 text-center">Creador: <?= $creator ?></h5>

    <?php if (empty($table)) { ?>
        <div class="alert alert-info">
            No se ha podido cargar la tabla.
        </div>
    <?php } else { ?>
        <div class="row g-0 py-3 border border-secondary text-center shadow-sm rounded" style="border-left: 4px solid #ffc107 !important;">
            <h1 class="text-center">Tabla: <?= $tableName ?></h1>
        </div>
        <?php foreach ($table as $day => $exercises) { ?>
            <div class="row g-0 border border-secondary text-center shadow-sm rounded" style="border-left: 4px solid #007bff !important;">
                <div class="col-2 d-flex justify-content-center align-items-center my-1">
                    <h5 class="m-auto"><?= DOW_TO_SP[$day] ?></h5>
                </div>
                <div class="col-10 border-start border-secondary d-flex justify-content-center align-items-center my-1">
                    <ul class="list-group list-group-flush w-100">
                        <li class="list-group-item d-flex justify-content-between">
                            <div class="col-8">
                                <b>Ejercicio</b>
                            </div>
                            <div class="col-2">
                                <b>Series</b>
                            </div>
                            <div class="col-2">
                                <b>Repeticiones</b>
                            </div>
                        </li>
                        <?php foreach ($exercises as $exercise) { ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="col-8 d-flex flex-column">
                                    <span><?= $exercise['name'] ?></span>
                                    <p class="mb-0 small text-muted fst-italic"><?= $exercise['description'] ?></p>
                                </div>
                                <div class="col-2 m-auto">
                                    <span><?= $exercise['series'] ?></span>
                                </div>
                                <div class="col-2 m-auto">
                                    <span><?= $exercise['reps'] ?></span>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <a class="btn btn-primary my-4" href="/proyectofp/public/print?id=<?= $id ?>" target="_blank">Imprimir</a>
</div>