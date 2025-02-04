<?php

namespace app\models;


use Flight;
class Food {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllFoods() {
        $stmt = $this->db->query('
            SELECT * FROM alimentations 
            ORDER BY nom ASC
        ');
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare('
            INSERT INTO alimentations (nom, pourcentage_gain, prix) 
            VALUES (?, ?, ?)
        ');
        return $stmt->execute([
            $data['nom'],
            $data['pourcentage_gain'],
            $data['prix']
        ]);
    }

    public function getFoodStock() {
        $stmt = $this->db->query('
            SELECT 
                a.id,
                a.nom,
                COALESCE(SUM(n.quantite), 0) as stock_total
            FROM alimentations a
            LEFT JOIN nourritures n ON a.id = n.alimentation_id
            GROUP BY a.id, a.nom
        ');
        return $stmt->fetchAll();
    }
}