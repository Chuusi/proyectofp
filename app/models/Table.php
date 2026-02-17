<?php

namespace App\Models;

use App\Config\Database;

class Table
{
    private $collection;

    //Conexión con la db
    public function __construct()
    {
        $db = new Database();
        $this->collection = $db->getCollection("tables");
    }

    public function create($data)
    {
        return $this->collection->insertOne($data);
    }
}
