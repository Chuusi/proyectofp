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

?>
<div class="container my-4">
    <h1 class="mb-4 text-center">Editando tabla</h1>
    <div id="editDiv">

    </div>
    <script src="/proyectofp/app/utils/tableBuilder.js"></script>
    <script>
        const table = <?php echo json_encode($table ?? []); ?>;
        const allExercises = <?php echo json_encode($allExercises ?? []); ?>;
        const editDiv = document.getElementById('editDiv');
        editDiv.appendChild(buildTableForm(table, allExercises, <?= json_encode($tableName) ?>, 'updateTable'));
    </script>
</div>