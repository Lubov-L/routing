<?php

namespace Routing\App\RMVC\Route;

class Route
{

    private static array $routesGet = [];

    public static function get(string $route, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routesGet[] = $routeConfiguration;

        return $routeConfiguration;
    }

    /**
     * @return array
     */
    public static function getRoutesGet(): array
    {
        return self::$routesGet;
    }
}