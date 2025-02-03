<?php

namespace app\models;

use Flight;

class Espece {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

  
    public function getAllEspece()
    {
        $stmt = $this->db->query('SELECT * FROM espece');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}