<?php

use App\Controllers\TableController;
use Dom\Document;

?>

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
        <label for="name" class="form-label">Nombre de la tabla</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="E.g.: Pierna Lunes y Miércoles">
    </div>
    <!-- Elección de los días de la semana que se quieren añadir a la tabla -->
    <div class="mb-3">
        <fieldset>
            <legend>Días de la semana</legend>
            <div class="form-check form-check-inline">
                <input
                    checked
                    class="form-check-input"
                    type="checkbox"
                    id="monday"
                    name="day[]"
                    value="monday">
                <label class="form-check-label" for="monday">Lunes</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    checked
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
    <!-- Elección de la cantidad de ejercicios que se quiere hacer por día -->
    <div class="mb-3">
        <fieldset>
            <legend>Ejercicios al día</legend>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    id="1"
                    name="exercises_day"
                    value="1">
                <label class="form-check-label" for="1">1</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    checked
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
    <button type="submit" name="action" class="btn btn-primary" value="createPreviewTable">Crear</button>
</form>
<div id="previewDiv">

</div>
<script>
    //Vamos a traer datos esta vez mediante fetch, para así poder manejar la tabla resultante y no
    //modificar el DOM desde el controlador ni hacer redirección a userAction.php
    const form = document.getElementById('createTableForm');
    const previewDiv = document.getElementById('previewDiv');
    //Usaremos este objeto para normalizar los nombres, pues vienen en inglés del form
    const weekDays = {
        'monday': 'Lunes',
        'tuesday': 'Martes',
        'wednesday': 'Miércoles',
        'thursday': 'Jueves',
        'friday': 'Viernes',
        'saturday': 'Sábado',
        'sunday': 'Domingo'
    }
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
                previewDiv.innerHTML = "";

                //Recorremos cada día de la tabla creada, para añadir primero el título y luego un select por cada ejercicio
                const form = document.createElement("form");
                form.action = "userAction.php";
                form.method = "post";

                //Añadimos título a la tabla, el que ha introducido el usuario o, sino, uno por defecto que sea irrepetible
                const tableName = document.createElement("h3");
                tableName.textContent = formData.get("name");
                if (tableName.textContent) {
                    form.appendChild(tableName);
                } else {
                    var date = new Date();
                    tableName.textContent = "Tabla: " + date.getTime();
                    form.appendChild(tableName);
                }

                //Añadimos input hidden para mandar el nombre de la tabla también
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "tableName";
                hiddenInput.value = tableName.textContent;
                form.appendChild(hiddenInput);

                //Recorremos cada día
                for (const day in table) {
                    const exercises = table[day];

                    const card = document.createElement("div");
                    card.classList = "card p-3 mb-3 mt-3";

                    const cardBody = document.createElement("div");
                    cardBody.classList = "card-body";

                    //Título con el nombre del día
                    const title = document.createElement("h5");
                    title.classList = "card-title";
                    title.textContent = weekDays[day];
                    cardBody.appendChild(title);
                    card.appendChild(cardBody);

                    // Por cada ejercicio asignado al día, creamos un <select> con todas las opciones
                    exercises.forEach((exercise, index) => {

                        const exerciseName = exercise['name'];
                        console.log(exerciseName);

                        const label = document.createElement("label");
                        label.className = "form-label";
                        label.textContent = "Ejercicio " + (index + 1);

                        const select = document.createElement("select");
                        select.className = "form-select mb-2";
                        select.name = `table[${day}][]`;

                        //Recorremos todos los ejercicios para añadirlos al select y dejamos como seleccionado el traido de la tabla
                        allExercises.forEach(ex => {
                            const option = document.createElement("option");
                            if (ex.name === exerciseName) {
                                option.selected = true;
                            }
                            option.value = ex.name;
                            option.textContent = ex.name;
                            select.appendChild(option);
                        });

                        cardBody.appendChild(label);
                        cardBody.appendChild(select);
                    });
                    form.appendChild(card);
                }
                const submitButton = document.createElement("button");
                submitButton.type = "submit";
                submitButton.name = "action";
                submitButton.value = "saveTable";
                submitButton.className = "btn btn-success";
                submitButton.textContent = "Guardar tabla";
                form.appendChild(submitButton);
                previewDiv.appendChild(form);


            })

    })
</script>