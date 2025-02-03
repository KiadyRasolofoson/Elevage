<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class UserController
{
    public function __construct__() {}

    public function loginForm() {
        Flight::render('login');
    }
}
