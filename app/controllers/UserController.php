<?php
//Iniciamos la sesión y requerimos el modelo antes de crear el controlador
session_start();
require_once __DIR__ . '/../models/User.php';
class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    //Registro de nuevos usuarios
    public function register($data)
    {
        try {
            $userExist = $this->userModel->findByName($data['name']);
            if ($userExist) {
                return "El usuario con ese nombre ya existe";
            } else {
                //Reestructuramos los datos según queramos.
                //Aquí podemos hacer las comprobaciones o modificaciones deseadas

                //Encriptamos la contraseña antes de mandarla a la db
                if ($data['password'] === $data['passwordCheck']) {
                    $pass_protected = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    //Modificamos el mensaje a mostrar con sweetalert
                    $_SESSION['contentAlert'] = [
                        'icon' => 'error',
                        'title' => 'Fallo',
                        'text' => 'Las contraseñas no coinciden'
                    ];
                    //Mandamos a la ruta para interrumpir la acción de guardar el usuario
                    header("Location: index.php?page=registerUser");
                    exit;
                }
                $userData = [
                    'name' => $data['name'] ?? null,
                    'password' => $pass_protected ?? null,
                ];
            }
            $this->userModel->create($userData);
            //Modificamos el mensaje a mostrar con sweetalert
            $_SESSION['contentAlert'] = [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Usuario creado satisfactoriamente'
            ];
            header("Location: index.php");
            exit;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //Inicio de sesión
    public function login($data)
    {
        try {
            //Comprueba que existe un usuario con ese nombre en la base de datos
            $userExist = $this->userModel->findByName($data['name']);
            if ($userExist) {
                //Comprueba si la contraseña coincide con la almacenada de manera segura
                if (password_verify($data['password'], $userExist['password'])) {
                    session_start();
                    $_SESSION['user'] = [
                        'id' => (string) $userExist['_id'],
                        'name' => $userExist['name']
                    ];
                    $_SESSION['contentAlert'] = [
                        'icon' => 'success',
                        'title' => 'Bienvenid@ ' . $userExist['name'],
                        'text' => 'Sesión iniciada correctamente'
                    ];
                    header("Location: index.php");
                    exit;
                } else {
                    session_start();
                    $_SESSION['contentAlert'] = [
                        'icon' => 'error',
                        'title' => 'Contraseña',
                        'text' => 'La contraseña es incorrecta'
                    ];
                    header("Location: index.php?page=login");
                    exit;
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //Cerrar sesión
    public function logout()
    {
        try {
            //Quita la variable "user" de la sesión.
            unset($_SESSION['user']);

            //Alerta por sweetalert
            $_SESSION['contentAlert'] = [
                'icon' => 'warning',
                'title' => '¡Hasta la próxima!',
                'text' => 'Sesión cerrada correctamente'
            ];

            //Indica que se cierre la sesión al index, para que, primero, muestre la alerta
            $_SESSION['logout'] = true;
            header("Location: index.php");
            exit;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
