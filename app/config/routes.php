<?php

use app\controllers\AchatController;
use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;
use flight\Engine;
use flight\net\Router;
use app\controllers\UserController;
use app\controllers\VenteController;
use app\controllers\NourrirController;
use app\controllers\AlimentationController;
use app\controllers\AnimalController;


//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$Welcome_Controller = new WelcomeController();
$user_controller = new UserController();

$Vente_controller = new VenteController();
$nourrir_controller = new NourrirController();
$alimentation_controller = new AlimentationController();
$animal_controller = new AnimalController();
$achat_controller = new AchatController();

Flight::route('/', [$user_controller, 'loginForm']);
Flight::route('POST /login', [$user_controller, 'login']);
Flight::route('POST /register', [$user_controller, 'register']);
Flight::route('GET /register', [$user_controller, 'registerForm']);
Flight::route('GET /dashboard', [$user_controller, 'home']);
FLight::route('GET /testHeader', [$Welcome_Controller, 'home']);
FLight::route('GET /user', [$user_controller, 'goUser']);
FLight::route('GET /animal', [$user_controller, 'goAnimal']);
FLight::route('GET /alimentation', [$user_controller, 'goAlimentation']);
FLight::route('POST /alimentation', [$alimentation_controller, 'alimentation']);
FLight::route('GET /vente', [$user_controller, 'goVente']);
FLight::route('GET /dashboard', [$user_controller, 'goDashboard']);
FLight::route('GET /nourrir', [$user_controller, 'nourrir']);
Flight::route('POST /nourrir', [$nourrir_controller, 'nourrir']);
FLight::route('GET /ajouter-animal', [$user_controller, 'ajoutAnimal']);
FLight::route('POST /ajouter-animal', [$animal_controller, 'ajouter']);
FLight::route('GET /modifier', [$user_controller, 'modification']);
FLight::route('GET /nourriture', [$user_controller, 'goNourriture']);

FLight::route('GET /achat', [$user_controller, 'goAchat']);
FLight::route('POST /achat/nourriture', [$achat_controller, 'goAchatNourriture']);

// Flight::route('POST /vente/vendre/@id', [$Vente_controller, 'vendre']);

Flight::route('POST /achat/acheter/@id', [$achat_controller, 'achat']);
Flight::route('POST /vente/vendre/@id', function($id) use ($Vente_controller) {
    // Récupération de la date envoyée via AJAX
    $date_vente = Flight::request()->data->date_vente;

    // Vérification si la date est vide
    if (empty($date_vente)) {
        Flight::json(["success" => false, "message" => "Veuillez fournir une date de vente."]);
        return;
    }

    // Appel de la méthode vendre du contrôleur avec l'ID et la date
    $Vente_controller->vendre($id, $date_vente);
});

//$router->get('/', \app\controllers\WelcomeController::class.'->home'); 

$router->group('/api', function () use ($router, $app) {
	$Api_Example_Controller = new ApiExampleController($app);
	$router->get('/users', [$Api_Example_Controller, 'getUsers']);
	$router->get('/users/@id:[0-9]', [$Api_Example_Controller, 'getUser']);
	$router->post('/users/@id:[0-9]', [$Api_Example_Controller, 'updateUser']);
});
