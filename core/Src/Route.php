<?php

namespace Src;
use Error;
class Route
{
    private static array $routes = [];
    private static string $prefix = '';

    public function __construct(string $prefix = '')
    {
        self::setPrefix($prefix);
    }

    public function getUrl(string $url): string
    {
        return self::$prefix . $url;
    }


    public function redirect(string $url): void
    {
        header('Location: ' . $this->getUrl($url));
    }

    public function setPrefix($value)
    {
        self::$prefix = $value;
    }

    public static function add(string $route, array $action): void
    {
        if(!array_key_exists($route, self::$routes)) {
            self::$routes[$route] = $action;
        }
    }

    public function start(): void
    {
        $path = explode('?', $_SERVER['REQUEST_URI'])[0];
        $path = substr($path, strlen(self::$prefix) + 1);

        if(!array_key_exists($path, self::$routes)) {
            throw new Error('Такого пути нет');
        }
        $class = self::$routes[$path][0];
        $action = self::$routes[$path][1];

        if (!class_exists($class)) {
            throw new Error('Такого класса нет');
        }

        if (!method_exists($class, $action)) {
            throw new Error('Такого метода нет');
        }

        call_user_func([new $class, $action], new Request());
    }
}