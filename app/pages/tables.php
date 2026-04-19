<?php

use App\Controllers\TableController;

//Obtener tablas de la base de datos
$tableController = new TableController();
$tables = $tableController->getAllTables();

?>

<div class="container my-4">
    <h1 class="mb-4 text-center">Lista de tablas</h1>

    <?php if (empty($tables)): ?>
        <div class="alert alert-info">
            No hay tablas registradas aún.
        </div>
    <?php else: ?>
        <div class="row g-0 py-3 mb-3 border border-secondary-subtle text-center shadow-sm rounded" style="border-left: 4px solid #ffc107 !important;">
            <div class="col-4 d-flex justify-content-center align-items-center my-1">
                <h5 class="m-auto"> TABLA </h5>
            </div>
            <div class="col-3 d-flex justify-content-center align-items-center my-1">
                <h5 class="m-auto"> DÍAS | EJERCICIOS/DÍA </h5>
            </div>
            <div class="col-3 d-flex justify-content-center align-items-center my-1">
                <h5 class="m-auto"> CREADOR </h5>
            </div>
            <div class="col-2 d-flex justify-content-center my-1">
                <h5 class="m-auto"> ACCIONES </h5>
            </div>
        </div>
        <?php
        foreach ($tables as $table):
        ?>
            <div class="row g-0 mb-3 border border-secondary-subtle text-center shadow-sm rounded" style="border-left: 4px solid #007bff !important;">
                <div class="col-4 d-flex justify-content-center align-items-center my-1">
                    <p class="m-auto"><?= $table['name'] ?></p>
                </div>
                <div class="col-3 border-start border-primary-subtle d-flex justify-content-center align-items-center my-1">
                    <p class="m-auto"><?= count($table['table']) ?> días | <?= count(reset($table['table'])) ?> ejecicios/día</p>
                </div>
                <div class="col-3 border-start border-primary-subtle d-flex justify-content-center align-items-center my-1">
                    <p class="m-auto"><?= $table['creator'] ?></p>
                </div>
                <div class="col-2 border-start border-primary-subtle d-flex justify-content-center my-1 gap-2">
                    <a href="/proyectofp/public/showTable?id=<?= $table['_id']['$oid'] ?>" class="btn btn-sm btn-primary">Ver</a>
                    <a href="/proyectofp/public/editTable?id=<?= $table['_id']['$oid'] ?>" class="btn btn-sm btn-warning">Editar</a>
                </div>
            </div>
    <?php
        endforeach;
    endif;
    ?>
</div>