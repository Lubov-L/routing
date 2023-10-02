<?php

namespace Routing\App\RMVC\Route;

class RouteDispatcher
{

    private string $requestUri = '/';

    private array $paramMap = [];

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
        // Если есть строка запроса, необходимо почитить и сохранить ее.
        $this->saveRequestUri();

        // Строка роута разбивается на массив и сохраняется в новый массив (позиция, параметр и название).
        $this->setParamMap();

        // Строка запроса разбиватся на массив и проверяется на наличие позиции, как у позиции параметра.
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

    private function render(): void
    {

        $cont = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;

        echo '<pre>';
        var_dump((new $cont)->$action());
        echo '<pre>';
    }
}