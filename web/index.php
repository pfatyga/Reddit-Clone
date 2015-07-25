<?php

include '../vendor/gabarro/class.FastTemplate.php';

include '../app/config.php';
include '../app/controllers/HomeController.php';
include '../app/controllers/SubredditController.php';
include '../app/controllers/NotFoundController.php';

$route = getRoute();

// If route doesn't exist, return 404 page
if (is_null($route))
{
    $notFoundController = new \reddit_clone\controllers\NotFoundController();
    $notFoundController->getNotFound();
    return;
}

// Get controller and method to call
$routeControllerParts = explode('::', $route['controller']);
$controllerClass = $routeControllerParts[0];
$controllerMethod = $routeControllerParts[1];

// Create controller and call method
$controller = new $controllerClass();
$controller->{$controllerMethod}($route['parameters']);

/**
 * Gets route based on path and request method.
 *
 * @return array|null
 */
function getRoute()
{
    global $config;

    $path = array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '/';
    $pathParts = explode('/', $path);

    foreach ($config['routes'] as $route)
    {
        $isRoute = true;
        $routeParameters = array();
        $routePathParts = explode('/', $route['path']);

        if (count($routePathParts) != count($pathParts))
        {
            continue;
        }

        if (array_key_exists('method', $route) && $route['method'] != $_SERVER['REQUEST_METHOD'])
        {
            continue;
        }

        foreach ($routePathParts as $index => $routePathPart)
        {
            $pathPart = $pathParts[$index];

            // If this is a route parameter, set value and continue
            if (substr($routePathPart, 0, 1) == '{' && substr($routePathPart, -1) == '}')
            {
                $routeParameters[substr($routePathPart, 1, strlen($routePathPart) - 2)] = $pathPart;
            }
            else
            {
                if ($routePathPart != $pathPart)
                {
                    $isRoute = false;
                    break;
                }
            }
        }

        if ($isRoute)
        {
            $route['parameters'] = $routeParameters;
            return $route;
        }
    }

    return null;
}