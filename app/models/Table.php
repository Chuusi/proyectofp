<?php

namespace App\Models;

use App\Config\Database;
use MongoDB\BSON\ObjectId;

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

    public function findAll()
    {
        return $this->collection->find();
    }

    public function getById($id)
    {
        $objectId = new ObjectId($id);
        return $this->collection->findOne(['_id' => $objectId]);
    }

    public function update($id, $data)
    {
        if (!$id) {
            throw new \Exception("ID de tabla no proporcionado");
        }
        $objectId = new ObjectId($id);
        return $this->collection->updateOne(
            ['_id' => $objectId],
            ['$set' => $data]
        );
    }

    public function delete($id)
    {
        if (!$id) {
            throw new \Exception("ID de tabla no proporcionado");
        }
        $objectId = new ObjectId($id);
        return $this->collection->deleteOne(['_id' => $objectId]);
    }
}
