<?php
//Config posee las variables globales de rutas a controladores y modelos
include('../app/config/config.php');
//Autoload se encarga de cargar automáticamente los controladores y modelos que existen
include('../app/utils/autoload.php');

//Muestra errores en pantalla
ini_set('display_errors', 1);
error_reporting(E_ALL);


//Si no hay una página definida en la url o si la página no existe como archivo en pages, nos lleva a home
$page = 'home';
if (isset($_GET['page']) && is_file('../app/pages/' . $_GET['page'] . '.php')) {
    $page = $_GET['page'];
}

//Vamos a definir la acción del usuario también a través de la url
$action = '';
if (isset($_GET['action'])) {
    $action = '/' . $_GET['action'] . '.php';
}

//Por orden, se requiere el header, la página correspondiente y el footer
include('../app/templates/header.php');
include(PAGES . "/" . $page . '.php' . $action);
include('../app/templates/footer.php');
