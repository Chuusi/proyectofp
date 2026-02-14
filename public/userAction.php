<?php

//Config posee las variables globales de rutas a controladores y modelos
include('../app/config/config.php');
//Autoload se encarga de cargar automáticamente los controladores y modelos que existen
include('../app/utils/autoload.php');

use App\Controllers\UserController;
use App\Controllers\ExerciseController;

//Corta el acceso si el método requerido no es POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die("Acceso no permitido");
}

$userController = new UserController();
$exerciseController = new ExerciseController();

//Llama a la acción del controller requerida dependiendo de la acción
switch ($_POST['action'] ?? "") {
    case 'register':
        $userController->register($_POST);
        break;
    case 'login':
        $userController->login($_POST);
        break;
    case 'logout':
        $userController->logout();
        break;
    case 'createExercise':
        $exerciseController->createExercise($_POST);
        break;
    case 'editExercise':
        $exerciseController->editExercise($_POST);
        break;
    case 'deleteExercise':
        $exerciseController->deleteExercise($_POST);
        break;
    default:
        $result = "Acción no válida";
        header("Location: /index.php");
        break;
}
