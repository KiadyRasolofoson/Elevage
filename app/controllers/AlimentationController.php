<?php

namespace app\controllers;

use app\models\Alimentation;

use Flight;

class AlimemtationController
{
    public function __construct()
    {
        
    }

    public function alimentation()
    {
        // Récupération des données envoyées par le client (POST ou JSON)
        $alimentation = new Alimentation(Flight::db());
        $request = Flight::request();
        $data = $request->data;

        // Vérification de la présence des paramètres nécessaires
        if (!isset($data->pourcentage_gain,$data->nom)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        // Appel à la méthode ajout du modèle
        $result = $alimentation->ajout(
            $data->animal_id,
            $data->alimentation_id,
            $data->date_nourriture,
            $data->quantite_nourriture
        );

        // Réponse JSON
        if ($result === true) {
           
        
            Flight::json(['success' => 'L\'animal a été nourri avec succès']);
            Flight::redirect('dashboard');
        } else {
            Flight::json(['error' => $result], 500);
        }
    }
}
