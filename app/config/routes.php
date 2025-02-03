<?php

use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;
use flight\Engine;
use flight\net\Router;
use app\controllers\UserController;
use app\controllers\VenteController;

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

Flight::route('/', [$user_controller, 'loginForm']);
Flight::route('POST /login', [$user_controller, 'login']);
Flight::route('POST /register', [$user_controller, 'register']);
Flight::route('GET /register', [$user_controller, 'registerForm']);
Flight::route('GET /dashboard', [$user_controller, 'home']);
FLight::route('GET /testHeader', [$Welcome_Controller, 'home']);

//$router->get('/', \app\controllers\WelcomeController::class.'->home'); 


$router->group('/api', function () use ($router, $app) {
	$Api_Example_Controller = new ApiExampleController($app);
	$router->get('/users', [$Api_Example_Controller, 'getUsers']);
	$router->get('/users/@id:[0-9]', [$Api_Example_Controller, 'getUser']);
	$router->post('/users/@id:[0-9]', [$Api_Example_Controller, 'updateUser']);
});
