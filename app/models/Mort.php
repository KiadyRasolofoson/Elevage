<?php

namespace app\models;

use Flight;

class Mort
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAnimalPasMort()
    {
        $stmt = $this->db->query('SELECT * FROM animaux WHERE id NOT IN (SELECT animal_id FROM ventes_animaux) AND id NOT IN (SELECT id_animal FROM mort)');
        $animals = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $animals;
    }

    public function mamono($id_animal, $date)
    {
        $stmt = $this->db->prepare('INSERT INTO mort (id_animal, date_vente) VALUES (?, ?)');
        $stmt->execute([$id_animal, $date]);
        return [
            "success" => true,
            "message" => "Vente de l'animal enregistrée avec succès."
        ];
    }
}
