<?php

//Config posee las variables globales de rutas a controladores y modelos
include('../app/config/config.php');
//Autoload se encarga de cargar automáticamente los controladores y modelos que existen
include('../app/utils/autoload.php');

use App\Controllers\UserController;

//Corta el acceso si el método requerido no es POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die("Acceso no permitido");
}

$controller = new UserController();

//Llama a la acción del controller requerida dependiendo de la acción
switch ($_POST['action'] ?? "") {
    case 'register':
        $result = $controller->register($_POST);
        break;
    case 'login':
        $result = $controller->login($_POST);
        break;
    case 'logout':
        $result = $controller->logout();
        break;
    default:
        $result = "Acción no válida";
        break;
}

echo $result;
