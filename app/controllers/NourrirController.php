<?php

namespace app\controllers;

use app\models\NourirAnimalModel;

use Flight;

class NourrirController
{
    private $nourrirModel;

    public function __construct()
    {
        $this->nourrirModel = new NourirAnimalModel(Flight::db());
    }

    public function nourrir()
    {
        // Récupération des données envoyées par le client (POST ou JSON)
        $request = Flight::request();
        $data = $request->data;

        // Vérification de la présence des paramètres nécessaires
        if (!isset($data->animal_id, $data->alimentation_id, $data->date_nourriture, $data->quantite_nourriture)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        // Appel à la méthode ajout du modèle
        $result = $this->nourrirModel->ajout(
            $data->animal_id,
            $data->alimentation_id,
            $data->date_nourriture,
            $data->quantite_nourriture
        );

        // Réponse JSON
        if ($result === true) {
           
        
            Flight::json(['success' => 'L\'animal a été nourri avec succès']);
        } else {
            Flight::json(['error' => $result], 500);
        }
    }
}
