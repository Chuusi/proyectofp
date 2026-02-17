<?php

namespace App\Models;

use App\Config\Database;

class Exercise
{
    private $collection;

    //Conexión con la db
    public function __construct()
    {
        $db = new Database();
        $this->collection = $db->getCollection("exercices");
    }

    //Crea un nuevo ejercicio y lo añade a la db
    public function create($data)
    {
        return $this->collection->insertOne($data);
    }

    //Buscar ejercicio por nombre
    public function findByName($name)
    {
        return $this->collection->findOne(['name' => $name]);
    }

    //Buscar todos
    public function findAll()
    {
        return $this->collection->find();
    }

    public function update($name, $data)
    {
        return $this->collection->updateOne(
            ['name' => $name],
            ['$set' => $data]
        );
    }

    public function delete($name)
    {
        return $this->collection->deleteOne(['name' => $name]);
    }

    public function insertMany($data)
    {
        $this->collection->drop();
        return $this->collection->insertMany($data);
    }
}
