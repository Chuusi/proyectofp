<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">CTR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Crear tabla</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ver tablas</a>
                    </li>
                </ul>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="container">
                    <p class="text-end">Bienvenido, <?= $_SESSION['user']['name'] ?> </p>
                    <form action="userAction.php" method="post" class="text-end">
                        <button type="submit" name="action" value="logout" class="btn btn-link text-end">
                            Cerrar sesión
                        </button>
                    </form>

                </div>
            <?php else: ?>
                <a class="nav-link" href="index.php?page=login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>