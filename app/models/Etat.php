<?php

namespace app\models;

use Flight;
use PDO;

class Etat {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getEtatByAnimalId($id_animaux)
    {
        try {
            $query = "SELECT * FROM etat WHERE id_animaux = :id_animaux ORDER BY date_etat DESC LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_animaux', $id_animaux, PDO::PARAM_INT);
            $stmt->execute();
            $etat = $stmt->fetch(PDO::FETCH_ASSOC);

            return $etat ?: ['error' => 'Aucun état trouvé pour cet animal'];
        } catch (\PDOException $e) {
            return ['error' => 'Erreur de base de données: ' . $e->getMessage()];
        }
    }
    public function addEtat($id_animaux, $poids)
    {
        try {
            $query = "INSERT INTO etat (id_animaux, date_etat, poids) VALUES (:id_animaux, NOW(), :poids)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_animaux', $id_animaux, PDO::PARAM_INT);
            $stmt->bindParam(':poids', $poids, PDO::PARAM_STR);
            $stmt->execute();

        } catch (\PDOException $e) {
            return ['error' => 'Erreur lors de l\'ajout de l\'état: ' . $e->getMessage()];
        }
    }
}
