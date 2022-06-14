<?php

namespace Mvc\Controller;



class BaseController
{
    public static function init(string $class)
    {
        $requestMethod = $_GET['method'];
        if (!$requestMethod) {
            return;
        }

        $methods = [
            'GET' => 'index',
            'POST' => 'create',
            'PUT' => 'update',
            'DELETE' => 'delete',
            'PAY' => 'payFinanca',
        ];
        $method = $methods[$requestMethod];
        return (new $class())->$method();
    }

    public function jsonResponse($data = null, $status = 200)
    {
        if ($data) {
            //header('Content-type', 'application/json');
            echo json_encode($data);
        }
        http_response_code($status);
    }
}
