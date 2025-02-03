<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class UserController {
    public function __construct__(){

    }

    public function goLogin(){
        Flight::render('auth/login');
    }
}