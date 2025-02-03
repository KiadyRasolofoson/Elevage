<?php

namespace app\models;

use Flight;

class Vente
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function vendre($id_animal, $date_ventes)
    {
        // Vérifier si l'animal est vendable
        $animalModel = new Animal($this->db);
        if (!$animalModel->estVendable($id_animal, $date_ventes)) {
            return "L'animal n'est pas vendable à cette date.";
        }

        // Récupérer les informations nécessaires pour le prix de vente
        $query = "SELECT e.prix_kg, et.poids 
                  FROM animaux a
                  JOIN espece e ON a.id_espece = e.id
                  JOIN etat et ON et.id_animaux = a.id
                  WHERE a.id = :id_animal AND et.date_etat = :date";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date' => $date_ventes
        ]);
        $animal = $stmt->fetch();

        if (!$animal) {
            return "Impossible de récupérer les informations de l'animal.";
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

        return "L'animal a été vendu avec succès pour $prix_vente €.";
    }
}
