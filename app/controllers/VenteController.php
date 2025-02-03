<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class VenteController
{

    public function __construct() {}

    public function goVente()
    {
        
        Flight::render('vendre/index');
    }

}
