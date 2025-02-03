<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\Users;
use Flight;

class UserController
{
    public function __construct__() {}

    public function loginForm() {
        Flight::render('auth/login');
    }
    public function login() {
        $data = Flight::request()->data;
        $username = $data->username;
        $password = $data->password;
        // Vérifier les informations de l'utilisateur
       
        $userModel = new Users(Flight::db());
        if ($userModel->verify_login($username,$password)){
            // Stocker l'utilisateur dans la session
            session_start();
            $_SESSION['username'] = $username;
            Flight::redirect('dashboard/index');
        } else {
         
            // Afficher une erreur
            
            Flight::render('auth/login', ['error' => 'Nom d’utilisateur ou mot de passe incorrect ']);
        }
    }

}
