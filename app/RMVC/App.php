<?php

namespace Routing\App\RMVC;

use Routing\App\RMVC\Route\Route;
use Routing\App\RMVC\Route\RouteDispatcher;

class App
{
    public static function run(): void
    {

        foreach (Route::getRoutesGet() as $routeConfiguration) {

            $routeDispatcher = new RouteDispatcher($routeConfiguration);
            $routeDispatcher->process();

        }
    }
}