<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Crea tu rutina</title>
</head>

<body>
    <?php include "../app/templates/header.php" ?>
    <main class="container">
        <?php

        if (!empty($_SESSION['contentAlert'])) {
            $msg = $_SESSION['contentAlert'];
            echo "
                <script>
                    Swal.fire({
                        icon: '{$msg['icon']}',
                        title: '{$msg['title']}',
                        text: '{$msg['text']}'
                    });
                </script>
                ";
            unset($_SESSION['contentAlert']);
            //Aquí comprobamos si se ha marcado el valor de logout como true
            //En caso positivo cerramos la sesión
            //Nos permite mostrar el mensaje de sweetalert antes de cerrar sesión
            if (!empty($_SESSION['logout'])) {
                session_unset();
                session_destroy();
            }
        }
        //Requerimos config para el punto de entrada 
        require "../app/config/config.php";
        $page = "home";
        //Comprueba si hay un page en la url y, además, comprueba si existe ese archivo en el directorio
        //Esto hará que si se intenta navegar a otra page que no tenemos, nos rediriga a "home"
        if (isset($_REQUEST['page']) && is_file('../app/pages/' . $_REQUEST['page'] . ".php")) {
            $page = $_REQUEST['page'];
        } else {
            //De no existir, nos devuelve a home
            $page = "home";
        }
        require "../app/pages/" . $page . ".php";
        ?>
    </main>
</body>

</html>