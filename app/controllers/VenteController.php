<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\Vente;
use Flight;
use DateTime;
use DateTimeZone;

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

    public function vendre($id_animaux, $date_vente)
    {
        $vente = new Vente(Flight::db());
        //  $date_vente = (new DateTime('now', new DateTimeZone('Indian/Antananarivo')))->format('Y-m-d');
        $result = $vente->vendre($id_animaux, $date_vente);
        Flight::json(json_decode($result, true));
    }
}
