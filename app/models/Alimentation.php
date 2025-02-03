<?php

namespace app\models;

use Flight;

class Alimentation {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getAlimentaionById($alimentation_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM alimentations WHERE id = :id_alimentation');
        $stmt->execute(['id_alimentation' => $alimentation_id]);
        $alimentation = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($alimentation) {
            return $alimentation;
        }
        return null;   
    }
    public function getAllAlimentation()
    {
        $stmt = $this->db->query('SELECT * FROM alimentations');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}