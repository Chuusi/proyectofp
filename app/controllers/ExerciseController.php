<?php

namespace App\Controllers;

//Requerimos el modelo antes de crear el controlador
use App\Models\Exercise;

class ExerciseController
{
    private $exerciseModel;

    public function __construct()
    {
        $this->exerciseModel = new Exercise();
    }

    //Añadir nuevo ejercicio a la DB
    public function createExercise($data)
    {
        try {
            //Comprobamos si el ejercicio ya existe
            $exerciseExist = $this->exerciseModel->findByName($data['name']);
            if ($exerciseExist) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'El ejercicio ya existe',
                    'text' => 'No se puede crear un ejercicio con el mismo nombre'
                ];
                header("Location: createExercise");
            } else if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para crear un ejercicio'
                ];
                header("Location: login");
                exit;
            } else {
                //Reestructuramos los datos según queramos.
                $exerciseData = [
                    'name' => $data['name'] ?? null,
                    'description' => $data['description'] ?? null,
                    'reps' => $data['reps'] ?? null,
                    'series' => $data['series'] ?? null,
                    'group' => $data['group'] ?? null,
                    'creator' => $_SESSION['user']['name'] ?? null,
                ];
                $this->exerciseModel->create($exerciseData);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Ejercicio creado satisfactoriamente'
                ];
                header("Location: exercises");
                exit;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAllExercises()
    {
        $exercises = $this->exerciseModel->findAll();
        $data = [];
        foreach ($exercises as $ex) {
            $data[] = json_decode(json_encode($ex), true);
        }
        return $data;
    }

    public function getExerciseByName($name)
    {
        $exercise_to_edit_json = $this->exerciseModel->findByName($name);
        if ($exercise_to_edit_json) {
            $exercise_to_edit = json_decode(json_encode($exercise_to_edit_json), true);
        }
        return $exercise_to_edit ?? null;
    }

    public function editExercise($data)
    {
        try {
            //Comprobamos si el ejercicio existe
            $exerciseExist = $this->exerciseModel->findByName($data['nameid']);
            if (!$exerciseExist) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'El ejercicio no existe',
                    'text' => 'No se puede editar un ejercicio que no existe'
                ];
                header("Location: exercises");
            } else if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para editar un ejercicio'
                ];
                header("Location: login");
                exit;
            } else {
                //Reestructuramos los datos según queramos.
                $exerciseData = [
                    'name' => $data['name'] ?? null,
                    'description' => $data['description'] ?? null,
                    'reps' => $data['reps'] ?? null,
                    'series' => $data['series'] ?? null,
                    'group' => $data['group'] ?? null,
                ];
                $this->exerciseModel->update($data['nameid'], $exerciseData);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Ejercicio editado satisfactoriamente'
                ];
                header("Location: exercises");
                exit;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deleteExercise($data)
    {
        try {
            //Comprobamos si el ejercicio existe
            $exerciseExist = $this->exerciseModel->findByName($data['name']);
            if (!$exerciseExist) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'El ejercicio no existe',
                    'text' => 'No se puede eliminar un ejercicio que no existe'
                ];
                header("Location: exercises");
            } else if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para eliminar un ejercicio'
                ];
                header("Location: login");
                exit;
            } else {
                $this->exerciseModel->delete($data['name']);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Ejercicio eliminado satisfactoriamente',
                ];
                header("Location: exercises");
                exit;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
