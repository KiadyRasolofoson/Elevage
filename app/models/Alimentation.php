<?php

namespace app\models;

use Flight;

class Alimentation {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getAlimentaionById($alimentation_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM alimentations WHERE id = :id_alimentation');
        $stmt->execute(['id_alimentation' => $alimentation_id]);
        $alimentation = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($alimentation) {
            return $alimentation;
        }
        return null;   
    }
    public function getAllAlimentation()
    {
        $stmt = $this->db->query('SELECT * FROM alimentations');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function add($pourcentage_gain,$nom,$prix)
    {
         try {
            // Préparation de la requête SQL pour insérer un enregistrement dans la table nourrir_animaux
            $stmt = $this->db->prepare('INSERT INTO alimentations (nom, pourcentage_gain,prix) 
                                        VALUES (:nom, :pourcentage_gain, :prix)');

            // Exécution de la requête avec les paramètres fournis
            $stmt->execute([
                'nom' => $nom,
                'pourcentage_gain' => $pourcentage_gain,
                'prix' => $prix
            ]);
         
            return true;
        } catch (\PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            return 'Erreur lors de l\'ajout : ' . $e->getMessage();
        }
    }
}