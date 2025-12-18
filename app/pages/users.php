<?php
//Prueba para comprobar que se traen bien las cosas de la db
use App\Controllers\UserController;

$controller = new UserController();

$users = $controller->showAllUsers();

if ($users) {
    foreach ($users as $user) {
        echo '<pre>';
        print_r($user);
        echo '</pre>';
    }
}
