<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class WelcomeController
{

    public function __construct() {}

    public function home()
    {
        Flight::render('layout/header');
    }
}
