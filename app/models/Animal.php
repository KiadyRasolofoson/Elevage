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
              WHERE a.id = :id_animal AND et.date_etat = :date
              ORDER BY et.id_etat DESC LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date' => $date
        ]);

        $animal = $stmt->fetch();

        // Vérifier si la requête a retourné des résultats
        if (!$animal) {
            // Si aucun résultat n'est trouvé, retourner false
            return false;
        }

        // Si l'animal existe, vérifier s'il est vendable
        return $animal['poids'] >= $animal['poids_minimal_vente'];
    }

    public function getAllAnimal()
    {
        $stmt = $this->db->query('SELECT * FROM animaux');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
