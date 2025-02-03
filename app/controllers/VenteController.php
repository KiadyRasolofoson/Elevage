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
        Flight::render('vendre/index');
    }

}
