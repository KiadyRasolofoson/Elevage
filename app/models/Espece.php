<?php

namespace app\models;

use Flight;

class Espece
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllEspece()
    {
        $stmt = $this->db->query('SELECT * FROM espece');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPrixParKg($id)
    {
        $stmt = $this->db->prepare('SELECT prix_kg FROM espece WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['prix_kg'] : null;
    }
}
