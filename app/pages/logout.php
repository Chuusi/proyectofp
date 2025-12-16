<?php
session_start();
$_SESSION['contentAlert'] = [
    'icon' => 'success',
    'title' => '¡Hasta la próxima!',
    'text' => 'Sesión cerrada correctamente'
];
session_unset();
session_destroy();
header("Location: index.php");
exit;
