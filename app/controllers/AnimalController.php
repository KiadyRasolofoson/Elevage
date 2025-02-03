<?php

namespace app\controllers;

use app\models\Animal;

use Flight;

class AnimalController
{
    public function __construct()
    {
        
    }

    public function ajouter()
    {
        // Récupération des données envoyées par le client (POST ou JSON)
        $animal = new Animal(Flight::db());
        $request = Flight::request();
        $data = $request->data;

        // Vérification de la présence des paramètres nécessaires
        if (!isset($data->id_espece,$data->nom,$data->poids)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        // Appel à la méthode ajout du modèle
        $result = $animal->add(
            $data->id_espece,
            $data->nom,
            $data->poids
        );

        // Réponse JSON
        if ($result === true) {
           
        
            Flight::json(['success' => 'L\'alimentation a été inserer avec succès']);
            Flight::redirect('animal');
        } else {
            Flight::json(['error' => $result], 500);
        }
    }
}
