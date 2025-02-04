<?php

namespace app\controllers;

use app\models\Alimentation;

use Flight;

class AlimentationController
{
    public function __construct() {}

    public function alimentation()
    {
        // Récupération des données envoyées par le client (POST ou JSON)
        $alimentation = new Alimentation(Flight::db());
        $request = Flight::request();
        $data = $request->data;

        // Vérification de la présence des paramètres nécessaires
        if (!isset($data->pourcentage_gain, $data->nom)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        // Appel à la méthode ajout du modèle
        $result = $alimentation->add(
            $data->pourcentage_gain,
            $data->nom,
            $data->prix
        );

        // Réponse JSON
        if ($result === true) {


            Flight::json(['success' => 'L\'alimentation a été inserer avec succès']);
            Flight::redirect('alimentation');
        } else {
            Flight::json(['error' => $result], 500);
        }
    }
    public function ajoutation(){
        Flight::render('alimentation/ajout');
    }
}
