<?php

namespace app\controllers;

use app\models\NourrirAnimalModel;

use Flight;

class NourrirController
{
    public function __construct()
    {
        
    }

    public function nourrir()
    {
        // Récupération des données envoyées par le client (POST ou JSON)
        $nourrirModel = new NourrirAnimalModel(Flight::db());
        $request = Flight::request();
        $data = $request->data;

        // Vérification de la présence des paramètres nécessaires
        if (!isset($data->animal_id, $data->alimentation_id, $data->date_nourriture, $data->quantite_nourriture)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        // Appel à la méthode ajout du modèle
        $result = $nourrirModel->ajout(
            $data->animal_id,
            $data->alimentation_id,
            $data->date_nourriture,
            $data->quantite_nourriture
        );

        // Réponse JSON
        if ($result === true) {
           
        
            Flight::json(['success' => 'L\'animal a été nourri avec succès']);
            Flight::redirect('dashboard/index');
        } else {
            Flight::json(['error' => $result], 500);
        }
    }
}
