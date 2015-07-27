<?php

// @todo include files dynamically
include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/gabarro/class.FastTemplate.php';

include $_SERVER['DOCUMENT_ROOT'] . '/../app/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/Router.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/models/IdTrait.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/models/User.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/services/UserService.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/controllers/ApiController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/controllers/HomeController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/controllers/SubredditController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/controllers/UserController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../app/controllers/NotFoundController.php';

// Get route
$router = new \reddit_clone\Router();
$route = $router->getRoute();

// If route doesn't exist, return 404 page
if (is_null($route))
{
    $notFoundController = new \reddit_clone\controllers\NotFoundController();
    $result = $notFoundController->getNotFound();
    print $result;
    return;
}

// Get controller and method to call
$routeControllerParts = explode('::', $route['controller']);
$controllerClass = $routeControllerParts[0];
$controllerMethod = $routeControllerParts[1];

// Create controller and call method
$controller = new $controllerClass();
$result = $controller->{$controllerMethod}($route['parameters']);

// Send response
print $result;