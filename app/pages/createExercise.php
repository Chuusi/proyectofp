<div class="my-4 w-75 mx-auto">
    <h1 class="text-center">Añadir nuevo ejercicio</h1>
    <?php
    //Avisamos que es necesario estar logueado para crear un ejercicio
    if (!isset($_SESSION['user'])):

    ?>
        <div class="d-flex justify-content-center">
            <span>⚠ --</span>
            <p class="text-center fst-italic"> Es necesario estar logueado para crear un ejercicio </p>
            <span>-- ⚠</span>
        </div>
    <?php
    endif;

    ?>
    <form action="userAction.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">
                <legend>Nombre del ejercicio</legend>
            </label>
            <input type="text" name="name" class="form-control" id="name" placeholder="E.g.: Sentadillas">
        </div>
        <hr>
        <div class="mb-3">
            <label for="description" class="form-label">
                <legend>Descripción del ejercicio</legend>
            </label>
            <textarea name="description" class="form-control" id="description" placeholder="E.g.: De pie, piernas ligeramente separadas, doblar piernas con la espalda recta, inclinando el tronco ligeramente hacia delante y los glúteos hacia atrás, como si fuésemos a sentarnos."></textarea>
        </div>
        <hr>
        <div class="mb-3">
            <label for="reps" class="form-label">
                <legend>Repeticiones</legend>
            </label>
            <input type="number" name="reps" class="form-control" id="reps" placeholder="E.g.: 15">
        </div>
        <hr>
        <div class="mb-3">
            <label for="series" class="form-label">
                <legend>Series</legend>
            </label>
            <input type="number" name="series" class="form-control" id="series" placeholder="E.g.: 2">
        </div>
        <div class="mb-3">
            <label for="group" class="form-label">
                <legend>Grupo muscular</legend>
            </label>
            <select name="group" class="form-select form-select mb-3" aria-label=".form-select" id="group">
                <option value="1">Pierna</option>
                <option value="2">Brazo</option>
                <option value="3">Core</option>
                <option value="4">Varios</option>
            </select>
        </div>
        <hr>
        <button type="submit" name="action" class="btn btn-primary" value="createExercise">Crear</button>
    </form>
</div>