<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\Vente;
use app\models\Users;
use app\models\Animal;
use app\models\Alimentation;
use Flight;

class UserController
{
    public function __construct__() {}

    public function loginForm() {
        Flight::render('auth/login');
    }
    public function home() {
        Flight::render('dashboard/index');
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
            $_SESSION['user']=$userModel->getUserByUsername($username);
            Flight::redirect('dashboard');
        } else {
         
            // Afficher une erreur
            
            Flight::render('auth/login', ['error' => 'Nom d’utilisateur ou mot de passe incorrect ']);
        }
    }
    public function registerForm() {
        Flight::render('auth/register');
    }

    // Traiter l'inscription
    public function register() {
        session_start();
        $data = Flight::request()->data;
        $username = $data->username;
        $password = $data->password;
        $balance = $data->balance; // Solde initial
        $userModel = new Users(Flight::db());
        $userModel->register($username,$password,$balance);
        $_SESSION['user']=$userModel->getUserByUsername($username);


        Flight::redirect('dashboard');
    }
    public function nourrir(){
        $animal=new Animal(Flight::db());
        $alimentation=new Alimentation(Flight::db());
        $alimentations=$alimentation->getAllAlimentation();
        $animals=$animal->getAllAnimal();
        Flight::render('nourrir/index', ['animals' => $animals,'alimentations'=>$alimentations]);
    }

    public function goUser(){
        Flight::render('users/index');
    }
    public function goAnimal(){
        $animal=new Animal(Flight::db());
        $animaux=$animal->getAllAnimal();
        Flight::render('animals/index',['animaux'=>$animaux]);
    }
    
    public function goDashboard(){
        Flight::render('Dashboard/index');
    }public function goVente(){
        $vente = new Vente(Flight::db());
        $data = [
            'listeAnimaux' => $vente->getAll()
        ];
        Flight::render('ventes/index',$data);
    }
    public function goAlimentation(){
        $alimentation=new Alimentation(Flight::db());
        $alimentations=$alimentation->getAllAlimentation();
        Flight::render('alimentation/index', ['alimentations'=>$alimentations]);
    }
    public function ajoutAnimal(){
        
        Flight::render('animals/ajouter');
    }

}
