<?php

include '../vendor/gabarro/class.FastTemplate.php';

include '../app/config.php';
include '../app/Router.php';
include '../app/controllers/HomeController.php';
include '../app/controllers/SubredditController.php';
include '../app/controllers/NotFoundController.php';

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