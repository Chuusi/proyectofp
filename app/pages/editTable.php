<?php

use App\Controllers\TableController;

$tableController = new TableController();
$id = $_GET['id'];
$info = $tableController->getTableWithExercises($id) ?? [];

$table = $info['table'] ?? null;
$allExercises = $info['allExercises'] ?? [];
$tableData = $info['data'] ?? null;
$tableName = $tableData['name'] ?? null;
$creator = $tableData['creator'] ?? null;

$params = [
    'tableData' => $table,
    'allExercises' => $allExercises,
    'tableName' => $tableName,
    'action' => 'updateTable',
    'id' => $id,
];

?>
<div class="container my-4">
    <h1 class="mb-4 text-center">Editando tabla</h1>

    <?php
    //Avisamos que es necesario estar logueado para crear un ejercicio
    if (!isset($_SESSION['user'])):

    ?>
        <div class="d-flex justify-content-center">
            <span>⚠ --</span>
            <p class="text-center fst-italic"> Es necesario estar logueado para editar una tabla </p>
            <span>-- ⚠</span>
        </div>
    <?php
    endif;
    ?>
    <div id="editDiv"></div>
    <script src="/proyectofp/app/utils/tableBuilder.js"></script>
    <script>
        const table = <?php echo json_encode($table ?? []); ?>;
        const allExercises = <?php echo json_encode($allExercises ?? []); ?>;
        const editDiv = document.getElementById('editDiv');
        editDiv.appendChild(buildTableForm(<?php echo json_encode($params ?? []); ?>));
    </script>
    <form action="userAction.php?id=<?php echo $id; ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tabla?');">
        <input type="hidden" name="action" value="deleteTable">
        <button type="submit" class="btn btn-danger my-3">Eliminar tabla</button>
    </form>
</div>