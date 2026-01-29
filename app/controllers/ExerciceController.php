<?php

namespace App\Controllers;

//Requerimos el modelo antes de crear el controlador
use App\Models\Exercice;

class ExerciceController
{
    private $exerciceModel;

    public function __construct()
    {
        $this->exerciceModel = new Exercice();
    }

    //Añadir nuevo ejercicio a la DB
    public function createExercice($data)
    {
        try {
            //Comprobamos si el ejercicio ya existe
            $exerciceExist = $this->exerciceModel->findByName($data['name']);
            if ($exerciceExist) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'El ejercicio ya existe',
                    'text' => 'No se puede crear un ejercicio con el mismo nombre'
                ];
                header("Location: createExercice");
            } else if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para crear un ejercicio'
                ];
                header("Location: login");
            } else {
                //Reestructuramos los datos según queramos.
                $exerciceData = [
                    'name' => $data['name'] ?? null,
                    'description' => $data['description'] ?? null,
                    'reps' => $data['reps'] ?? null,
                    'series' => $data['series'] ?? null,
                    'group' => $data['group'] ?? null,
                    'creator' => $_SESSION['user']['name'] ?? null,
                ];
                $this->exerciceModel->create($exerciceData);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Ejercicio creado satisfactoriamente'
                ];
                header("Location: createExercice");
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAllExercises()
    {
        return $this->exerciceModel->findAll();
    }
}
