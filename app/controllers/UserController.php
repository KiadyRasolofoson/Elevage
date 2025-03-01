<?php

namespace app\controllers;

use app\models\Achat;
use app\models\ProductModel;
use app\models\Vente;
use app\models\Users;
use app\models\Animal;
use app\models\Mort;
use app\models\Alimentation;
use app\models\Capital;
use app\models\Espece;
use Flight;

class UserController
{
    public function __construct__() {}

    public function loginForm()
    {
        Flight::render('auth/login');
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
            session_unset(); // Clear session variables
        }

        Flight::redirect('/'); // Redirect instead of render
    }

    public function home()
    {
        Flight::render('dashboard/index');
    }

    public function login()
    {
        $data = Flight::request()->data;
        $username = $data->username;
        $password = $data->password;
        // Vérifier les informations de l'utilisateur

        $userModel = new Users(Flight::db());
        if ($userModel->verify_login($username, $password)) {
            // Stocker l'utilisateur dans la session
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['user'] = $userModel->getUserByUsername($username);
            Flight::redirect('/user?indice=0');
        } else {

            // Afficher une erreur

            Flight::render('auth/login', ['error' => 'Nom d’utilisateur ou mot de passe incorrect ']);
        }
    }
    public function registerForm()
    {
        Flight::render('auth/register');
    }

    // Traiter l'inscription
    public function register()
    {
        session_start();
        $data = Flight::request()->data;
        $username = $data->username;
        $password = $data->password;
        $balance = $data->balance; // Solde initial
        $userModel = new Users(Flight::db());
        $userModel->register($username, $password, $balance);
        $_SESSION['user'] = $userModel->getUserByUsername($username);
        Flight::redirect('dashboard');
    }
    public function nourrir()
    {
        $animal = new Animal(Flight::db());
        $alimentation = new Alimentation(Flight::db());
        $alimentations = $alimentation->getAllAlimentation();
        $animals = $animal->getAllAnimal();
        Flight::render('nourrir/index', ['animals' => $animals, 'alimentations' => $alimentations]);
    }

    public function goUser()
    {
        session_start();
        $id = $_SESSION['user']['id_user'];
        $capital = new Capital(Flight::db());

        // Fetch capital data (as a JSON string)
        $data = $capital->getCapital($id);

        // Decode the JSON string to an array
        $dataArray = json_decode($data, true);  // The true flag makes it an associative array

        // Check if the data is correctly decoded
        if (is_array($dataArray) && isset($dataArray['somme_capital'])) {
            $renderData = [
                'capital' => $dataArray['somme_capital']
            ];

            // Render the page with the decoded data
            Flight::render('users/index', $renderData);
        } else {
            // Handle the error if the format is not as expected
            echo "Capital data is not in the expected format.";
        }
    }


    public function goAnimal()
    {
        $animal = new Animal(Flight::db());
        $animaux = $animal->getAllAnimal();
        Flight::render('animals/index', ['animaux' => $animaux]);
    }

    public function goDashboard()
    {
        Flight::render('Dashboard/index');
    }

    public function goVente()
    {
        $vente = new Vente(Flight::db());
        $data = [
            'listeAnimaux' => $vente->getAll()
        ];
        Flight::render('ventes/index', $data);
    }

    public function goAchat()
    {
        $achat = new Achat(Flight::db());
        $data = [
            'achatsDisponibles' => $achat->getAchatDisponible()
        ];
        Flight::render('achat/index', $data);
    }

    public function goAlimentation()
    {
        $alimentation = new Alimentation(Flight::db());
        $alimentations = $alimentation->getAllAlimentation();
        Flight::render('alimentation/index', ['alimentations' => $alimentations]);
    }
    public function ajoutAnimal()
    {
        $espece = new Espece(Flight::db());
        $especes = $espece->getAllEspece();
        Flight::render('animals/ajouter', ['especes' => $especes]);
    }
    public function modification()
    {
        $espece = new Espece(Flight::db());
        $especes = $espece->getAllEspece();
        Flight::render('animals/edit', ['especes' => $especes]);
    }
    public function goNourriture()
    {
        $alin = new Alimentation(Flight::db());
        $data = [
            'alimentations' => $alin->getAllAlimentation()
        ];
        Flight::render('nourriture/index', $data);
    }
    public function mourrir()
    {
        $mourir = new Mort(Flight::db());
        $data = [
            'animaux' => $mourir->getAnimalPasMort()
        ];
        Flight::render('mourrir/index', $data);
    }
}
