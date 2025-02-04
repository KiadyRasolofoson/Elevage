<?php

namespace app\controllers;

use app\models\Achat;
use Flight;

class AchatController
{

    public function __construct() {}

    public function achat($id_animal)
    {
        session_start();
        $id_user = $_SESSION['user']['id_user'];
        $achatModel = new Achat(Flight::db());
        $result = $achatModel->achat($id_user, $id_animal);
        Flight::json(json_decode($result, true));
    }
}
