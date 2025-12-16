<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;

class Database {
    private $client;
    private $db;

    //Crea la base de datos, conecta con la ip que tengamos en mongoDB compas y el nombre de la DB
    public function __construct() {
        $this->client = new Client("mongodb://localhost:27017");
        $this->db = $this->client->selectDatabase("proyecto");
    }

    public function getCollection($name) {
        return $this->db->selectCollection($name);
    }
}

?>