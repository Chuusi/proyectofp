<?php

namespace App\Core;

class Routes
{
    private static $routes = [];
    public static function get($url, $callback)
    {
        $route = new Route('GET', $url, $callback);
        self::$routes[] = $route;

        var_dump($route);
        return $route;
    }
}
