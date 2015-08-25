<?php

namespace reddit_clone;

/**
 * Class Router
 *
 * @package reddit_clone
 */
class Router
{
    /**
     * Gets route based on path and request method.
     *
     * @return array|null
     */
    public function getRoute()
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
                if (substr($routePathPart, 0, 1) == ':')
                {
                    $routeParameters[substr($routePathPart, 1, strlen($routePathPart) - 1)] = $pathPart;
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
}
