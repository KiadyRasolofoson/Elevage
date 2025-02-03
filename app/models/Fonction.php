<?php

namespace app\models;

use Flight;

class Fonction {
    private $db;

    public function __construct($db) {
        $this->db = $db; 
    }

    public function insert($table, $data) {
        if (empty($table) || empty($data)) {
            throw new \InvalidArgumentException("Le nom de la table et les données ne peuvent pas être vides.");
        }
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return true; 
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'insertion dans la table $table : " . $e->getMessage());
            return false; 
        }
    }

    public function update($table, $data, $conditions) {
        if (empty($table) || empty($data) || empty($conditions)) {
            throw new \InvalidArgumentException("Le nom de la table, les données et les conditions ne peuvent pas être vides.");
        }

        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "$column = :$column";
        }
        $setClause = implode(', ', $setClause);

        $whereClause = [];
        foreach ($conditions as $column => $value) {
            $whereClause[] = "$column = :where_$column";
        }
        $whereClause = implode(' AND ', $whereClause);

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $params = [];
        foreach ($data as $column => $value) {
            $params[":$column"] = $value;
        }
        foreach ($conditions as $column => $value) {
            $params[":where_$column"] = $value;
        }


        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour dans la table $table : " . $e->getMessage());
            return false; 
        }
    }

    public function getAll($table){
        if (empty($table)){
            throw new \InvalidArgumentException("Le nom de la table, les données et les conditions ne peuvent pas être vides.");
        }
        $sql = "SELECT * FROM $table";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la selection dans la table $table : " . $e->getMessage());
            return false; 
        }
    }
}
