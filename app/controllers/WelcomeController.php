<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class WelcomeController
{

    public function __construct() {}

    public function home()
    {
        $data = ['nom' => "oke"];
        Flight::render('welcome', $data);
    }
}
