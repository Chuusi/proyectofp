<form>
    <div class="mb-3">
        <label for="exerciceName" class="form-label">Nombre del ejercicio</label>
        <input type="text" class="form-control" id="exerciceName" placeholder="E.g.: Sentadillas">
    </div>
    <div class="mb-3">
        <label for="exerciceDescription" class="form-label">Descripción del ejercicio</label>
        <textarea class="form-control" id="exerciceDescription" placeholder="E.g.: De pie, piernas ligeramente separadas, doblar piernas con la espalda recta, inclinando el tronco ligeramente hacia delante y los glúteos hacia atrás, como si fuésemos a sentarnos."></textarea>
    </div>
    <div class="mb-3">
        <label for="exerciceReps" class="form-label">Repeticiones</label>
        <input type="number" class="form-control" id="exerciceReps" placeholder="E.g.: 15">
    </div>
    <div class="mb-3">
        <label for="exerciceSeries" class="form-label">Series</label>
        <input type="number" class="form-control" id="exerciceSeries" placeholder="E.g.: 2">
    </div>
    <select class="form-select form-select mb-3" aria-label=".form-select">
        <option selected>Grupo muscular</option>
        <option value="1">Pierna</option>
        <option value="2">Brazo</option>
        <option value="3">Core</option>
        <option value="4">Varios</option>
    </select>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>