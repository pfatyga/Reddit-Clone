<?php

// @todo include files dynamically
include $_SERVER['DOCUMENT_ROOT'] . '/../server/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/Router.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/models/IdTrait.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/models/User.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/services/AuthenticationService.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/services/UserService.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/services/SubredditService.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/controllers/ApiController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/controllers/SubredditController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/controllers/UserController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/controllers/AuthenticationController.php';
include $_SERVER['DOCUMENT_ROOT'] . '/../server/controllers/NotFoundController.php';

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
