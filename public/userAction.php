<?php
//Este archivo sirve de puente entre el front y el back sin contener lógica de negocio
require_once __DIR__ . '/../app/controllers/UserController.php';

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
