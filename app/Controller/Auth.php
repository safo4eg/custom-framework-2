<?php

namespace Controller;

use Model\Employee;
use Src\Request;
use Src\View;

class Auth
{
    public function login(Request $request): string
    {
        $payload = $request->all();

        if ($request->method === 'GET') {
            if (!empty($payload) && isset($payload['login']) && isset($payload['password'])) {
                $login = $payload['login'];
                $password = $payload['password'];

                $employee = Employee::where('login', $login)->first();

                if (!$employee) {
                    http_response_code(400);
                    echo json_encode('net', JSON_UNESCAPED_UNICODE);
                    die();
                }

                // иначе редирект
            }

            return new View('auth.login');
        }
    }
}