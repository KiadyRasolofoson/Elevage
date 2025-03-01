<?php

namespace app\models;
use app\models\Alimentation;
use app\models\Etat;
use Flight;

class NourrirAnimalModel {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    // Fonction pour ajouter un aliment à un animal
    public function ajout($animal_id, $alimentation_id, $date_nourriture, $quantite_nourriture)
    {
        try {
            // Préparation de la requête SQL pour insérer un enregistrement dans la table nourrir_animaux
            $stmt = $this->db->prepare('INSERT INTO nourrir_animaux (animal_id, alimentation_id, date_nourriture, quantite_nourriture) 
                                        VALUES (:animal_id, :alimentation_id, :date_nourriture, :quantite_nourriture)');

            // Exécution de la requête avec les paramètres fournis
            $stmt->execute([
                'animal_id' => $animal_id,
                'alimentation_id' => $alimentation_id,
                'date_nourriture' => $date_nourriture,
                'quantite_nourriture' => $quantite_nourriture
            ]);
            $alimentation=new Alimentation(Flight::db());
            $etat=new Etat(Flight::db());
            $e=$etat->getEtatByAnimalId($animal_id);
            $al=$alimentation->getAlimentaionById($alimentation_id);
            $poidsGagne=($e['poids']*$al['pourcentage_gain'])+$e['poids'];
            $etat-> addEtat($animal_id, $poidsGagne);

         
            return true;
        } catch (\PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            return 'Erreur lors de l\'ajout : ' . $e->getMessage();
        }
    }
   
}
