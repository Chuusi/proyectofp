<?php

namespace App\Controllers;

//Requerimos el modelo antes de crear el controlador
use App\Models\Table;

class TableController
{
    private $tableModel;

    public function __construct()
    {
        $this->tableModel = new Table();
    }

    //Creación de nueva tabla según datos elegidos por el usuario
    // Tenemos 4 grupos musculares
    /*     Array
    (
    [name] => 
    [day] => Array
        (
            [0] => monday
            [1] => tuesday
            [2] => wednesday
        )

    [exercises_day] => 3
    [work_method] => same
    [action] => createTable
    ) */
    public function createPreviewTable($data)
    {
        try {
            $tableName = $data['name'] ?? null;
            $tableDay = $data['day'] ?? null;
            $exercisesDay = $data['exercises_day'] ?? null;
            $workMethod = $data['work_method'] ?? null;
            $table = [];

            //Nos traemos todos los ejercicios de la base de datos, los desordenamos y separamos por grupos musculares
            $allExercises = (new ExerciseController())->getAllExercises();
            $exercisesOrdered = [];
            $exercises = [];
            foreach ($allExercises as $exercise) {
                $exercise = json_decode(json_encode($exercise), true);
                $exercisesOrdered[] = $exercise;
            }
            usort($exercisesOrdered, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            $exercises = $exercisesOrdered;
            shuffle($exercises);
            $armExercises = array_values(array_filter($exercises, function ($ex) {
                return $ex['group'] == "1";
            }));
            $legExercises = array_values(array_filter($exercises, function ($ex) {
                return $ex['group'] == "2";
            }));
            $coreExercises = array_values(array_filter($exercises, function ($ex) {
                return $ex['group'] == "3";
            }));
            $multExercises = array_values(array_filter($exercises, function ($ex) {
                return $ex['group'] == "4";
            }));

            if ($workMethod === "same") {
                //Elegimos un grupo al azar, para que no siga siempre el mismo orden
                $starting_group = rand(1, 4);
                for ($day = 0; $day < count($tableDay); $day++) {
                    //Para la elección de grupo, que solo esté entre 1 y 4
                    $group = ($starting_group % 4) + 1;
                    $table[$tableDay[$day]] = [];
                    for ($ex_day = 0; $ex_day < $exercisesDay; $ex_day++) {
                        //Se comprueba en cada grupo que no sobrepase el array, en cuyo caso vuelve a iniciar la lista, mediante el módulo se hace fácil
                        switch ($group) {
                            case 1:
                                $table[$tableDay[$day]][] = $armExercises[$ex_day % count($armExercises)];
                                break;
                            case 2:
                                $table[$tableDay[$day]][] = $legExercises[$ex_day % count($legExercises)];
                                break;
                            case 3:
                                $table[$tableDay[$day]][] = $coreExercises[$ex_day % count($coreExercises)];
                                break;
                            case 4:
                                $table[$tableDay[$day]][] = $multExercises[$ex_day % count($multExercises)];
                                break;
                            default:
                                break;
                        }
                    }
                    $starting_group++;
                }
            } else {
                for ($day = 0; $day < count($tableDay); $day++) {
                    $table[$tableDay[$day]] = [];
                    for ($ex_day = 0; $ex_day < $exercisesDay; $ex_day++) {
                        $exercise = $exercises[($day * $exercisesDay + $ex_day) % count($exercises)];
                        $table[$tableDay[$day]][] = $exercise;
                    }
                }
            }
            return [
                "table" => $table,
                "allExercises" => $exercisesOrdered
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveTable($data)
    {
        try {
            if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para guardar una tabla'
                ];
                header("Location: login");
            } else {
                $tableData = [
                    "name" => $data['tableName'] ?? null,
                    "creator" => $_SESSION['user']['name'] ?? null,
                    "table" => $data['table'] ?? null,
                ];
                $this->tableModel->create($tableData);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Tabla guardada satisfactoriamente'
                ];
                header("Location: tables");
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
