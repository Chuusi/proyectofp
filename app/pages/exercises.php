<?php

use App\Controllers\ExerciseController;

// Obtener ejercicios de la base de datos
$exerciseController = new ExerciseController();
$exercises = [];
$exercises_json = $exerciseController->getAllExercises();
foreach ($exercises_json as $ex) {
    $exercises[] = json_decode(json_encode($ex), true);
}

usort($exercises, function ($a, $b) {
    return strcmp($a['name'], $b['name']);
});

// Función para asignar estilos según el grupo muscular
function styleFromGroup($group)
{
    switch ($group) {
        case '1':
            return 'style="border-left: 4px solid #007bff;"';
        case '2':
            return 'style="border-left: 4px solid #28a745;"';
        case '3':
            return 'style="border-left: 4px solid #ffc107;"';
        case '4':
            return 'style="border-left: 4px solid #6c757d;"';
        default:
            return '';
    }
}

?>



<div class="container mt-4">
    <h1 class="mb-4 text-center">Lista de Ejercicios</h1>

    <?php if (empty($exercises)): ?>
        <div class="alert alert-info">
            No hay ejercicios registrados aún.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($exercises as $exercise): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm"
                        <?php
                        // Asigna colores al borde según el grupo muscular
                        echo styleFromGroup($exercise['group']);
                        ?>>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="h-100 d-flex flex-column justify-content-between">
                                <h5 class="card-title">
                                    <?= $exercise['name'] ?>
                                </h5>
                                <p class="card-text">
                                    <?= $exercise['description'] ?>
                                </p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Series</span>
                                        <span class="fw-bold">
                                            <?= $exercise['series'] ?>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Repeticiones</span>
                                        <span class="fw-bold">
                                            <?= $exercise['reps'] ?>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Grupo</span>
                                        <span class="badge bg-secondary"
                                            <?php

                                            echo styleFromGroup($exercise['group']);

                                            ?>>
                                            <?php
                                            switch ($exercise['group']) {
                                                case '1':
                                                    echo 'Pierna';
                                                    break;
                                                case '2':
                                                    echo 'Brazo';
                                                    break;
                                                case '3':
                                                    echo 'Core';
                                                    break;
                                                case '4':
                                                    echo 'Varios';
                                                    break;
                                                default:
                                                    echo 'Desconocido';
                                            }
                                            ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            if (isset($_SESSION['user'])): ?>
                                <div class="d-flex gap-2">
                                    <a href="/proyectofp/public/editExercise?name=<?= $exercise['name'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="userAction.php" method="post" class="d-inline">
                                        <input type="hidden" name="name" value="<?= $exercise['name'] ?>">
                                        <button
                                            type="submit"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este ejercicio? Se eliminará de la base de datos.')"
                                            class="btn btn-sm btn-outline-danger"
                                            name="action"
                                            value="deleteExercise">Eliminar</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>