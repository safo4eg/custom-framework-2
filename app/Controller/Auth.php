<?php

namespace Controller;
use Model\Employee;
use Src\Request;
use Src\View;

class Auth
{
    public function login(Request $request): string
    {
        if($request->method === 'GET') {
            return new View('auth.login', ['fff' => 'ddd']);
        }
    }
}