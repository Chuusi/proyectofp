<div class="container">
    <h1 class="text-center">Iniciar sesión</h1>
    <form action="userAction.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <button type="submit" name="action" value="login" class="btn btn-primary">Iniciar sesión</button>
    </form>
    <a href="/proyectofp/public/register">¿No tienes una cuenta? Regístrate aquí</a>
</div>