<?php

namespace app\models;

use Flight;

class Animal
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAnimal() {}

    public function estVendable($id_animal, $date)
    {
        // Récupérer le poids minimal requis pour la vente et le poids actuel de l'animal
        $query = "SELECT e.poids_minimal_vente, et.poids 
                  FROM animaux a
                  JOIN espece e ON a.id_espece = e.id
                  JOIN etat et ON et.id_animaux = a.id
                  WHERE a.id = :id_animal AND et.date_etat = :date";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date' => $date
        ]);
        $animal = $stmt->fetch();

        if (!$animal) {
            return false; // L'animal ou l'état à la date donnée n'existe pas
        }
        
        return $animal['poids'] >= $animal['poids_minimal_vente'];
    }
    public function getAllAnimal()
    {
        $stmt = $this->db->query('SELECT * FROM animaux');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
