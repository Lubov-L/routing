<?php

namespace Routing\App\RMVC;

use Routing\App\RMVC\Route\Route;
use Routing\App\RMVC\Route\RouteDispatcher;

class App
{
    public static function run(): void
    {
        $requestMethod = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));

        $methodName = 'getRoutes'. $requestMethod;

        foreach (Route::$methodName() as $routeConfiguration) {
            $routeDispatcher = new RouteDispatcher($routeConfiguration);
            $routeDispatcher->process();
        }
    }
}