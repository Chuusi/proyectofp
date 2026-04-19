<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="height: 80px;">
        <div class=" container-fluid">
            <a class="navbar-brand" href="/proyectofp/public/home" style="font-size: 32px;">CTR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['page'] ?? 'home') === 'home' ? 'active' : '' ?>" href="/proyectofp/public/home" style="white-space: nowrap;">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['page'] ?? 'home') === 'createExercise' ? 'active' : '' ?>" href="/proyectofp/public/createExercise" style="white-space: nowrap;">Crear ejercicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['page'] ?? 'home') === 'exercises' ? 'active' : '' ?>" href="/proyectofp/public/exercises" style="white-space: nowrap;">Ver ejercicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['page'] ?? 'home') === 'createTables' ? 'active' : '' ?>" href="/proyectofp/public/createTables" style="white-space: nowrap;">Crear tabla</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['page'] ?? 'home') === 'tables' ? 'active' : '' ?>" href="/proyectofp/public/tables" style="white-space: nowrap;">Ver tablas</a>
                    </li>
                </ul>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <p class="badge bg-secondary mb-0 p-2">Bienvenid@, <?= $_SESSION['user']['name'] ?> </p>
                    <form action="userAction.php" method="post" class="text-end">
                        <button type="submit" name="action" value="logout" class="btn btn-warning text-end">
                            Cerrar sesión
                        </button>
                    </form>

                </div>
            <?php else: ?>
                <a class="btn btn-warning text-end" href="/proyectofp/public/login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>