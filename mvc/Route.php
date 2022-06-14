<?php

namespace Mvc;


class Route
{
    private const ROUTES = [
        '/' => '/View/index.php',
        '/form/categorias' => '/View/categoria/Form.php',
        '/categorias' => '/View/categoria/index.php',
        '/api/categorias' => 'Mvc\\Controller\\CategoriaController',
        '/api/financas' => 'Mvc\\Controller\\FinancaController'
    ];

    private const ROUTES_TO_PAGES = [
        '/',
        '/form/categorias',
        '/categorias'
    ];

    public static function init()
    {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        if (in_array($url, self::ROUTES_TO_PAGES)) {
            include __DIR__ . static::ROUTES[$url];
        }

        $controller = static::ROUTES[$url];

        if (!class_exists($controller) && !in_array($url, self::ROUTES_TO_PAGES)) {
            header('Location: /');
            die;
        }

        if (!in_array($url, self::ROUTES_TO_PAGES)) {
            return new $controller();
        }
    }
}
