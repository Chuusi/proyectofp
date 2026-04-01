<?php

use App\Controllers\TableController;

//Obtener tablas de la base de datos
$tableController = new TableController();
$tables = [];
$tables_json = $tableController->getAllTables();

foreach ($tables_json as $tb) {
    $tables[] = json_decode(json_encode($tb), true);
}

?>

<div class="container my-4">
    <h1 class="mb-4 text-center">Lista de tablas</h1>

    <?php if (empty($tables)): ?>
        <div class="alert alert-info">
            No hay tablas registradas aún.
        </div>
        <?php else:
        foreach ($tables as $table):
        ?>
            <div class="row g-0 mb-3 border border-primary text-center">
                <div class="col-4 d-flex justify-content-center align-items-center my-1">
                    <p class="m-auto"><?= $table['name'] ?></p>
                </div>
                <div class="col-3 border-start border-primary-subtle d-flex justify-content-center align-items-center my-1">
                    <p class="m-auto"><?= count($table['table']) ?> días | <?= count(reset($table['table'])) ?> ejecicios/día</p>
                </div>
                <div class="col-3 border-start border-primary-subtle d-flex justify-content-center align-items-center my-1">
                    <p class="m-auto"><?= $table['creator'] ?></p>
                </div>
                <div class="col-2 border-start border-primary-subtle d-flex justify-content-center my-1">
                    <a href="/proyectofp/public/editTable?id=<?= $table['_id']['$oid'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                </div>
            </div>
    <?php
        endforeach;
    endif;
    ?>
</div>