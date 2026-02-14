<?php

use App\Controllers\ExerciseController;

$exerciseController = new ExerciseController();
$exercise_to_edit = null;

$exercise_to_edit_json = $exerciseController->getExerciseByName($_GET['name'] ?? null);
if ($exercise_to_edit_json) {
    $exercise_to_edit = json_decode(json_encode($exercise_to_edit_json), true);
}

?>

<style>
    .input-unchanged {
        border: 2px solid #28a745 !important;
        background-color: #f0fff4;
    }

    .input-changed {
        border: 2px solid #ffc107 !important;
        background-color: #fffbf0;
    }
</style>

<div class="container mt-4">
    <h1 class="text-center">Editando ejercicio "<span class="fw-bold"><?= $exercise_to_edit['name'] ?></span>"</h1>

    <form action="userAction.php" method="post" id="editForm">
        <input style="display: none" name="nameid" value="<?= $exercise_to_edit['name'] ?>"></label>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del ejercicio</label>
            <input type="text" name="name" class="form-control trackable-input input-unchanged" id="name"
                value="<?= $exercise_to_edit['name'] ?>" data-original="<?= htmlspecialchars($exercise_to_edit['name']) ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción del ejercicio</label>
            <textarea name="description" class="form-control trackable-input input-unchanged" id="description"
                data-original="<?= htmlspecialchars($exercise_to_edit['description']) ?>"><?= $exercise_to_edit['description'] ?></textarea>
        </div>
        <div class=" mb-3">
            <label for="reps" class="form-label">Repeticiones</label>
            <input type="number" name="reps" class="form-control trackable-input input-unchanged" id="reps"
                value="<?= $exercise_to_edit['reps'] ?>" data-original="<?= $exercise_to_edit['reps'] ?>">
        </div>
        <div class="mb-3">
            <label for="series" class="form-label">Series</label>
            <input type="number" name="series" class="form-control trackable-input input-unchanged" id="series"
                value="<?= $exercise_to_edit['series'] ?>" data-original="<?= $exercise_to_edit['series'] ?>">
        </div>
        <select name="group" class="form-select form-select mb-3 trackable-input input-unchanged" aria-label=".form-select" id="group"
            data-original="<?= $exercise_to_edit['group'] ?>">

            <option value="1" <?= $exercise_to_edit['group'] == 1 ? 'selected' : '' ?>>Pierna</option>
            <option value="2" <?= $exercise_to_edit['group'] == 2 ? 'selected' : '' ?>>Brazo</option>
            <option value="3" <?= $exercise_to_edit['group'] == 3 ? 'selected' : '' ?>>Core</option>
            <option value="4" <?= $exercise_to_edit['group'] == 4 ? 'selected' : '' ?>>Varios</option>
        </select>
        <button type="submit" name="action" class="btn btn-primary" value="editExercise">Editar</button>
    </form>
</div>

<script>
    //Añado script para que los inputs aparezcan en verde si coinciden con el valor que tenían
    document.addEventListener('DOMContentLoaded', function() {
        const trackableInputs = document.querySelectorAll('.trackable-input');

        trackableInputs.forEach(input => {
            // Inicializar con verde
            checkInputChange(input);

            // Cambios en tiempo real
            input.addEventListener('input', function() {
                checkInputChange(this);
            });

            input.addEventListener('change', function() {
                checkInputChange(this);
            });
        });

        function checkInputChange(input) {
            const originalValue = input.getAttribute('data-original');
            const currentValue = input.value;

            if (currentValue === originalValue) {
                input.classList.remove('input-changed');
                input.classList.add('input-unchanged');
            } else {
                input.classList.remove('input-unchanged');
                input.classList.add('input-changed');
            }
        }
    });
</script>