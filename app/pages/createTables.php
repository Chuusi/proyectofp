<?php

use App\Controllers\TableController;
use Dom\Document;

?>
<div class="my-4 w-75 mx-auto">
    <h1 class="text-center">Añadir nueva tabla</h1>
    <?php
    //Avisamos que es necesario estar logueado para crear un ejercicio
    if (!isset($_SESSION['user'])):

    ?>
        <div class="d-flex justify-content-center">
            <span>⚠ --</span>
            <p class="text-center fst-italic"> Es necesario estar logueado para crear una tabla </p>
            <span>-- ⚠</span>
        </div>
    <?php
    endif;

    /* $previewTable = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'createTable') {
    $controller = new TableController();
    $previewTable = $controller->createTable($_POST); // Devuelve array de tabla
} */


    ?>
    <form id="createTableForm" action="" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">
                <legend>Nombre de la tabla</legend>
            </label>
            <input type="text" name="name" class="form-control" id="name" placeholder="E.g.: Pierna Lunes y Miércoles">
        </div>
        <hr>
        <!-- Elección de los días de la semana que se quieren añadir a la tabla -->
        <div class="mb-3">
            <fieldset>
                <legend>Días de la semana</legend>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="monday"
                        name="day[]"
                        value="monday">
                    <label class="form-check-label" for="monday">Lunes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="tuesday"
                        name="day[]"
                        value="tuesday">
                    <label class="form-check-label" for="tuesday">Martes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="wednesday"
                        name="day[]"
                        value="wednesday">
                    <label class="form-check-label" for="wednesday">Miércoles</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="thursday"
                        name="day[]"
                        value="thursday">
                    <label class="form-check-label" for="thursday">Jueves</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="friday"
                        name="day[]"
                        value="friday">
                    <label class="form-check-label" for="friday">Viernes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="saturday"
                        name="day[]"
                        value="saturday">
                    <label class="form-check-label" for="saturday">Sábado</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="sunday"
                        name="day[]"
                        value="sunday">
                    <label class="form-check-label" for="sunday">Domingo</label>
                </div>
            </fieldset>
        </div>
        <hr>
        <!-- Elección de la cantidad de ejercicios que se quiere hacer por día -->
        <div class="mb-3">
            <fieldset>
                <legend>Ejercicios al día</legend>
                <div class="form-check form-check-inline">
                    <input
                        checked
                        class="form-check-input"
                        type="radio"
                        id="1"
                        name="exercises_day"
                        value="1">
                    <label class="form-check-label" for="1">1</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="2"
                        name="exercises_day"
                        value="2">
                    <label class="form-check-label" for="2">2</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="3"
                        name="exercises_day"
                        value="3">
                    <label class="form-check-label" for="3">3</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="4"
                        name="exercises_day"
                        value="4">
                    <label class="form-check-label" for="4">4</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="5"
                        name="exercises_day"
                        value="5">
                    <label class="form-check-label" for="5">5</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="6"
                        name="exercises_day"
                        value="6">
                    <label class="form-check-label" for="6">6</label>
                </div>
            </fieldset>
        </div>
        <hr>
        <!-- Elección de la forma de trabajo, bien mismo día diferentes grupos musculares o bien cada día un grupo muscular diferente -->
        <div class="mb-3">
            <fieldset>
                <legend>Forma de trabajo</legend>
                <div class="form-check form-check-inline">
                    <input
                        checked
                        class="form-check-input"
                        type="radio"
                        id="same"
                        name="work_method"
                        value="same">
                    <label class="form-check-label" for="same">Cada día un grupo muscular diferente</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="different"
                        name="work_method"
                        value="different">
                    <label class="form-check-label" for="different">Diferentes grupos musculares en un mismo día</label>
                </div>
            </fieldset>
        </div>
        <hr>
        <button type="submit" name="action" class="btn btn-primary mb-3" value="createPreviewTable">Crear</button>
    </form>
    <div id="previewDiv">

    </div>
    <script src="/proyectofp/app/utils/tableBuilder.js"></script>
    <script>
        //Vamos a traer datos esta vez mediante fetch, para así poder manejar la tabla resultante y no
        //modificar el DOM desde el controlador ni hacer redirección a userAction.php

        //Como es la misma lógica que en editExercise, metemos la lógica de creación de formulario y guardado en un js
        const form = document.getElementById('createTableForm');
        const previewDiv = document.getElementById('previewDiv');
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            formData.append('action', 'createPreviewTable');
            fetch('userAction.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
                .then(response => {
                    //De la respuesta, traemos la tabla y todos los ejercicios
                    const table = response.table ?? response;
                    const allExercises = response.allExercises ?? [];
                    const tableName = formData.get("name") || "Tabla - " + Date.now();
                    const params = {
                        tableData: table,
                        allExercises: allExercises,
                        tableName: tableName,
                        action: 'saveTable',
                    };
                    previewDiv.innerHTML = "";
                    previewDiv.appendChild(buildTableForm(params));

                })

        })
    </script>
</div>