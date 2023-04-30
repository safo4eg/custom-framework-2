<?php

namespace Controller;

use Model\Employee;
use Src\Request;
use Src\View;
use Src\Response;

class Auth
{
    public function login(Request $request): string
    {
        $response = new Response();
        $payload = $request->all();

        if ($request->method === 'GET') {
            if (!empty($payload) && isset($payload['login']) && isset($payload['password'])) {
                $login = $payload['login'];
                $password = $payload['password'];

                $employee = Employee::where('login', $login)->first();

                if (!$employee) {
                    echo $response->setStatus('error')->setCode(400)->setData('Какая-то ошибка'); die();
                }

                echo $response->setStatus('url')->setCode(302)->setData('/go');die();
            }
            return new View('auth.login');
        }
    }

    public function go(Request  $request): string
    {
        return new View('auth.login');
    }
}