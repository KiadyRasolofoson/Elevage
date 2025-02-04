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
        $id = $_POST['animal_id'];
        $date = $_POST['date'];
        $mort = new Mort(Flight::db());
        $result = $mort->mamono($id, $date);
        Flight::json($result); // On suppose que $result est déjà un tableau ou objet
    }

    
}
