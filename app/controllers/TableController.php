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

    /**
     * Crea una vista previa de la tabla de ejercicios según los datos del usuario.
     * @param array $data Array con claves:
     *                    - name (string|null) Nombre de la tabla
     *                    - day (array|null) Días seleccionados (ej. ['monday','tuesday'])
     *                    - exercises_day (int|null) Número de ejercicios por día
     *                    - work_method (string|null) 'same' para agrupar por grupo muscular o otro para distribuir
     * @return array Devuelve un array con:
     *               - 'table' => array asociativo con días y ejercicios asignados
     *               - 'allExercises' => array con todos los ejercicios ordenados por nombre
     * @throws \Throwable Propaga excepciones en caso de error
     */
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

    /**
     * Guarda la tabla de ejercicios en la base de datos
     * @param array $data Array con claves:
     *                    - name (string|null) Nombre de la tabla
     *                    - day (array|null) Días seleccionados (ej. ['monday','tuesday'])
     *                    - exercises_day (int|null) Número de ejercicios por día
     *                    - work_method (string|null) 'same' para agrupar por grupo muscular o otro para distribuir
     */
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
                foreach ($data['table'] as $day => $exercises) {
                    foreach ($exercises as $index => $exercise) {
                        $exerciseData = json_decode($exercise, true);
                        $data['table'][$day][$index] = $exerciseData;
                    }
                }
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
            throw $th;
        }
    }

    /**
     * Devuelve todas las tablas almacenadas en la base de datos
     */
    public function getAllTables()
    {
        $data = $this->tableModel->findAll();
        $tables = [];
        foreach ($data as $tb) {
            $tables[] = json_decode(json_encode($tb), true);
        }
        return $tables;
    }

    public function getTableById($id)
    {
        $table = $this->tableModel->getById($id);
        if (!$table) {
            return null;
        }
        return json_decode(json_encode($table), true);
    }

    /**
     * Devuelve la información de una tabla específica, así como la lista con todos los ejercicios.
     */
    public function getTableWithExercises($id)
    {
        $table = $this->tableModel->getById($id);
        if (!$table) {
            return null;
        }

        $table = json_decode(json_encode($table), true);
        return [
            "table" => $table['table'] ?? [],
            "allExercises" => (new ExerciseController())->getAllExercises(),
            "data" => [
                "id" => $table['_id']['$oid'] ?? null,
                "name" => $table['name'] ?? null,
                "creator" => $table['creator'] ?? null,
            ]
        ];
    }

    /**
     * Actualiza una tabla existente con los datos recibidos del usuario
     * @param string $id ID de la tabla a actualizar
     * @param array $data Array con datos necesarios para la actualización.
     */
    public function updateTable($id, $data)
    {
        try {
            if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para actualizar una tabla'
                ];
                header("Location: login");
            } else {
                foreach ($data['table'] as $day => $exercises) {
                    foreach ($exercises as $index => $exercise) {
                        $exerciseData = json_decode($exercise, true);
                        $data['table'][$day][$index] = $exerciseData;
                    };
                };
                $dataToUpdate = [
                    "name" => $data['tableName'] ?? null,
                    "creator" => $_SESSION['user']['name'] ?? null,
                    "table" => $data['table'] ?? null,
                ];
                $this->tableModel->update($id, $dataToUpdate);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Tabla actualizada satisfactoriamente'
                ];
                header("Location: tables");
            }
        } catch (\Throwable $th) {
            $_SESSION['contentAlert'] = [
                'icon' => 'error',
                'title' => 'Fallo',
                'text' => 'Error al actualizar la tabla'
            ];
            throw $th;
        }
    }

    public function deleteTable($id)
    {
        try {
            if ($_SESSION['user'] == null) {
                $_SESSION['contentAlert'] = [
                    'icon' => 'error',
                    'title' => 'Fallo',
                    'text' => 'Debes iniciar sesión para eliminar una tabla'
                ];
                header("Location: login");
            } else {
                $this->tableModel->delete($id);
                $_SESSION['contentAlert'] = [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Tabla eliminada satisfactoriamente'
                ];
                header("Location: tables");
            }
        } catch (\Throwable $th) {
            $_SESSION['contentAlert'] = [
                'icon' => 'error',
                'title' => 'Fallo',
                'text' => 'Error al eliminar la tabla'
            ];
            throw $th;
        }
    }
}
