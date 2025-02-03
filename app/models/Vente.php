<?php

namespace app\models;

use app\models\Fonction;
use Flight;

class Vente
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $fonction = new Fonction($this->db);
        return $fonction->getAll('ventes_animaux');
    }

    public function vendre($id_animal, $date_ventes)
    {
        // Vérifier si l'animal est vendable
        $animalModel = new Animal($this->db);
        if (!$animalModel->estVendable($id_animal, $date_ventes)) {
            return json_encode([
                'success' => false,
                'message' => "L'animal n'est pas vendable à cette date."
            ]);
        }
        // Récupérer les informations nécessaires pour le prix de vente
        // Sélectionner le dernier état de l'animal
        $query = "SELECT e.prix_kg, et.poids 
              FROM animaux a
              JOIN espece e ON a.id_espece = e.id
              JOIN etat et ON et.id_animaux = a.id
              WHERE a.id = :id_animal
              ORDER BY et.date_etat DESC LIMIT 1";  // Prendre le dernier état

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal
        ]);
        $animal = $stmt->fetch();

        if (!$animal) {
            return json_encode([
                'success' => false,
                'message' => "Impossible de récupérer les informations de l'animal."
            ]);
        }

        // Calculer le prix de vente (poids * prix_kg)
        $prix_vente = $animal['poids'] * $animal['prix_kg'];

        // Insérer la vente dans la table ventes_animaux
        $query = "INSERT INTO ventes_animaux (animal_id, date_vente, prix_vente) 
              VALUES (:id_animal, :date_ventes, :prix_vente)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date_ventes' => $date_ventes,
            'prix_vente' => $prix_vente
        ]);

        return json_encode([
            'success' => true,
            'message' => "L'animal a été vendu avec succès.",
            'data' => [
                'id_animal' => $id_animal,
                'date_vente' => $date_ventes,
                'prix_vente' => $prix_vente
            ]
        ]);
    }
}
