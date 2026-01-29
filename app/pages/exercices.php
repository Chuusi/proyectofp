<?php

use App\Controllers\ExerciceController;

// Verificar autenticación
if (!isset($_SESSION['user'])) {
    header('Location: login');
    exit;
}

// Obtener ejercicios de la base de datos
$exerciseController = new ExerciceController();
$exercises = $exerciseController->getAllExercises();
?>



<div class="container mt-4">
    <h1 class="mb-4">Lista de Ejercicios</h1>

    <?php if (empty($exercises)): ?>
        <div class="alert alert-info">
            No hay ejercicios registrados aún.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($exercises as $exercise): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="h-100 d-flex flex-column justify-content-between">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($exercise['name']) ?>
                                </h5>
                                <p class="card-text">
                                    <?= htmlspecialchars($exercise['description']) ?>
                                </p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Series</span>
                                        <span class="fw-bold">
                                            <?= htmlspecialchars($exercise['series']) ?>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Repeticiones</span>
                                        <span class="fw-bold">
                                            <?= htmlspecialchars($exercise['reps']) ?>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Grupo</span>
                                        <span class="badge bg-secondary">
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

                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>