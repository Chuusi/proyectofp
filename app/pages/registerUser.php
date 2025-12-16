<div class="container-sm">
    <h1 class="text-center">Registrarse</h1>
    <!-- En el botón, indicamos el nombre acción y el valor que queremos mandarle al userAction.php para decirle
    la acción que tiene que llevar a cabo de entre todas las definidas -->
    <form action="userAction.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Sólo debe incluir caracteres o números</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3">
            <label for="passwordCheck" class="form-label">Repite la contraseña</label>
            <input type="password" class="form-control" name="passwordCheck" id="passwordCheck">
        </div>
        <button type="submit" name="action" value="register" class="btn btn-primary">Registrarse</button>
    </form>
</div>