<?php

namespace app\controllers;

use app\models\Achat;
use app\models\Mort;
use Flight;

class MortController
{

    public function __construct() {}

    public function goMamono()
    {
        // Récupérer les données envoyées via POST
        $id = $_POST['animal_id'];
        $date = $_POST['date'];

        // Créer une instance du modèle Mort et appeler la méthode mamono
        $mort = new Mort(Flight::db());
        $result = $mort->mamono($id, $date);

        // Retourner la réponse au format JSON
        Flight::json($result);
    }
}
