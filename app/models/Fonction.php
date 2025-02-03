<?php

namespace app\models;

use Flight;

class Fonction {
    private $db;

    public function __construct($db) {
        $this->db = $db; 
    }

    public function insert($table, $data) {
        // Vérification des paramètres
        if (empty($table) || empty($data)) {
            throw new \InvalidArgumentException("Le nom de la table et les données ne peuvent pas être vides.");
        }

        // Préparation des colonnes et des valeurs pour la requête SQL
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        // Construction de la requête SQL
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        // Exécution de la requête
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return true; // Insertion réussie
        } catch (\PDOException $e) {
            // Gestion des erreurs (vous pouvez logger l'erreur ou la relancer)
            error_log("Erreur lors de l'insertion dans la table $table : " . $e->getMessage());
            return false; // Insertion échouée
        }
    }
}