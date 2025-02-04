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

    public function acheterNouriture()
    {
        $id_alim = isset($_POST['id_alim']) ? intval($_POST['id_alim']) : null;
        $quantite = isset($_POST['quantiter']) ? floatval($_POST['quantiter']) : null;

        $achatModel = new Achat(Flight::db());
        $result  = $achatModel->achatNourriture($id_alim, $quantite);
        Flight::json(json_decode($result, true));
    }
}
