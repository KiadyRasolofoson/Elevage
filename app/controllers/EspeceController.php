<?php

namespace app\controllers;

use app\models\Espece;

use Flight;

class EspeceController
{
    public function __construct()
    {
        
    }

    public function modifier()
    {
        $nom = $_POST['nom'];
        $columnIndex = $_POST['columnIndex'];
        $newValue = $_POST['newValue'];
        $conn = Flight::db();

        // Déterminer le nom de la colonne en fonction de l'index
        $columns = [
            'nom', 'poids_minimal_vente', 'poids_maximal',
            'jours_sans_manger', 'perte_poids_par_jour',
            'prix_kg', 'quota_nourriture_journalier'
        ];

        if (!isset($columns[$columnIndex])) {
            die("Colonne invalide.");
        }

        $columnName = $columns[$columnIndex]; // Sécurisé car défini dans un tableau contrôlé

        // Préparer et exécuter la requête SQL
        $sql = "UPDATE espece SET $columnName = :newValue WHERE nom = :nom";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'newValue' => $newValue,
            'nom' => $nom
        ]);
    

        if ($stmt->execute()) {
            echo "Mise à jour réussie";
        } else {
            echo "Erreur lors de la mise à jour";
        }
    }

}
