<?php

namespace Routing\App\RMVC\Route;

use JetBrains\PhpStorm\NoReturn;

class RouteDispatcher
{
    private string $requestUri = '/';

    private array $paramMap = [];
    private array $paramRequestMap = [];

    private RouteConfiguration $routeConfiguration;

    /**
     * RouteDispatcher constructor.
     * @param RouteConfiguration $routeConfiguration
     */

    public function __construct(RouteConfiguration $routeConfiguration)
    {
        $this->routeConfiguration = $routeConfiguration;
    }


    public function process(): void
    {
        // Если есть строка запроса, необходимо почистить и сохранить ее.
        $this->saveRequestUri();

        // Строка роута разбивается на массив и сохраняется в новый массив (позиция, параметр и название).
        $this->setParamMap();

        // Строка запроса разбивается на массив и проверяется на наличие позиции, как у позиции параметра.
        // Если есть, строка приводится в регулярное выражение.
        $this->makeRegexRequest();

        // Запускается контроллер и экшн.
        $this->run();
    }

    private function saveRequestUri(): void
    {
        if ($_SERVER['REQUEST_URI'] !== '/') {
            $this->requestUri = $this->clean($_SERVER['REQUEST_URI']);
            $this->routeConfiguration->route = $this->clean($this->routeConfiguration->route);
        }
    }

    private function clean($str): string
    {
        return preg_replace('/(^\/)|(\/$)/', '', $str);
    }

    private function setParamMap(): void
    {
        $routeArray = explode('/', $this->routeConfiguration->route);

        foreach ($routeArray as $paramKey => $param) {
            if (preg_match('/{.*}/', $param)) {
                $this->paramMap[$paramKey] = preg_replace('/(^{)|(}$)/', '', $param);
            }
        }
    }

    private function makeRegexRequest(): void
    {
        $requestUriArray = explode('/', $this->requestUri);


        foreach ($this->paramMap as $paramKey => $param) {
            if (!isset($requestUriArray[$paramKey])) {
                return;
            }
            $this->paramRequestMap[$param] = $requestUriArray[$paramKey];
            $requestUriArray[$paramKey] = '{.*}';
        }

        $this->requestUri = implode('/', $requestUriArray);
        $this->prepareRegex();

    }

    private function prepareRegex(): void
    {
        $this->requestUri = str_replace('/', '\/', $this->requestUri);
    }

    private function run(): void
    {
        if (preg_match("/$this->requestUri/", $this->routeConfiguration->route)) {
            $this->render();
        }
    }

    #[NoReturn] private function render(): void
    {
        $cont = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;
        print((new $cont)->$action(...$this->paramRequestMap));

        die();
    }
}