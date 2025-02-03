<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\Vente;
use Flight;

class VenteController
{

    public function __construct() {}

    public function goVente()
    {
        $vente = new Vente(Flight::db());
        $data = [
            'listeAnimaux' => $vente->getAll()
        ];
        Flight::render('vendre/index', $data);
    }

    public function vendre($id_animaux)
    {
        $vente = new Vente(Flight::db());
        $date_vente = date('Y-m-d H:i:s');
        $result = $vente->vendre($id_animaux, $date_vente);
        Flight::json(json_decode($result, true)); 
    }
}
