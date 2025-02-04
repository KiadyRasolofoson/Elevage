<?php

namespace app\models;

use app\models\Etat;

use Flight;

class Mort
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAnimal() {}

    public function getAnimalPasMort()
    {
        // Récupérer les animaux qui ne sont pas dans la table ventes_animaux
        $stmt = $this->db->query('SELECT * FROM animaux WHERE id NOT IN (SELECT animal_id FROM ventes_animaux)');
        $animals = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $animals;    
    }

    public function mamono($id_animal, $date)
    {
        $stmt = $this->db->prepare('INSERT INTO mort (id_animal, date_vente) VALUES (?, ?)');
        $stmt->execute([$id_animal, $date]);
        Flight::json(["success" => true, "message" => "Vente de l'animal enregistrée avec succès."]);
    }
}
