<?php

namespace App\Models;

use App\Config\Database;

//require_once __DIR__ . '/../config/database.php';

class User
{
    private $collection;

    //Conexión con la db
    public function __construct()
    {
        $db = new Database();
        $this->collection = $db->getCollection("users");
    }

    //Crea un nuevo usuario y lo añade a la db
    public function create($data)
    {
        return $this->collection->insertOne($data);
    }

    //Buscar usuario por nombre
    public function findByName($name)
    {
        return $this->collection->findOne(['name' => $name]);
    }

    //Buscar todos
    public function findAll()
    {
        return $this->collection->find();
    }
}
