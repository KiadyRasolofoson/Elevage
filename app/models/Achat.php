<?php

namespace app\models;

use Flight;

class Achat
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAchat() {}

    public function achat($idAcheteur, $id_animal_avendre)
    {
        // Vérifier si l'animal est disponible à la vente
        $query = "SELECT * FROM ventes_animaux WHERE animal_id = :id_animal_avendre AND estVendu = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_animal_avendre' => $id_animal_avendre]);
        $vente = $stmt->fetch();

        // Si l'animal n'est pas disponible à la vente
        if (!$vente) {
            return json_encode([
                'success' => false,
                'message' => "L'animal n'est pas disponible à la vente ou a déjà été vendu."
            ]);
        }

        $capitalModel = new Capital($this->db);
        // Vérifier le capital de l'acheteur en utilisant la méthode getCapital() de la classe Capital
        $capital = $capitalModel->getCapital($idAcheteur); // Appel à la méthode getCapital
        $capital = json_decode($capital, true); // Décoder la réponse JSON

        // Si le capital est insuffisant
        if (!$capital['success'] || $capital['somme_capital'] < $vente['prix_vente']) {
            return json_encode([
                'success' => false,
                'message' => "Capital insuffisant pour acheter cet animal."
            ]);
        }

        // Mettre à jour l'ID de l'utilisateur (acheteur) de l'animal
        $query = "UPDATE animaux SET id_user = :idAcheteur WHERE id = :id_animal_avendre";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'idAcheteur' => $idAcheteur,
            'id_animal_avendre' => $id_animal_avendre
        ]);

        // Mettre à jour la table des ventes pour marquer que l'animal a été vendu
        $query = "UPDATE ventes_animaux SET estVendu = 1 WHERE animal_id = :id_animal_avendre";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_animal_avendre' => $id_animal_avendre]);

        // Ajouter l'achat à la table des achats d'animaux
        $query = "INSERT INTO achats_animaux (animal_id, date_achat, prix_achat) 
                  SELECT animal_id, NOW(), prix_vente FROM ventes_animaux WHERE animal_id = :id_animal_avendre";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_animal_avendre' => $id_animal_avendre]);

        // Déduire le prix de l'animal du capital de l'acheteur
        $query = "INSERT INTO capital (id_user, solde, date_creation) VALUES (:id_user, :solde, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_user' => $idAcheteur,            // Corrected the parameter name to match the SQL placeholder
            'solde' => -$vente['prix_vente']    // The negative value for capital deduction
        ]);

        return json_encode([
            'success' => true,
            'message' => "L'animal a été acheté avec succès.",
            'id_acheteur' => $idAcheteur,
            'id_animal' => $id_animal_avendre
        ]);
    }
}
