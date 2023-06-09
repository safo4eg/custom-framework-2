<?php

namespace Controller;

use Src\Request;
use Src\Session;
use Src\Validator\Validator;
use Src\View;
use Src\Response;
use Src\Auth\Auth as coreAuth;

class Auth
{
    public function login(Request $request): string
    {
        $response = new Response();
        $payload = $request->all();

        if ($request->method === 'GET') {
            return new View('auth.login');
        }

        if($request->method === 'POST') {
            $validator = new Validator($payload, [
                'login' => ['required'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field не может быть пустым'
            ]);

            if($validator->fails()) {
                echo $response->setStatus('error')->setCode(400)->setData($validator->errors()); die();
            }

            if(coreAuth::attempt($payload)){
                if($_SESSION['role'] === 4) {
                    echo $response->setStatus('url')->setCode(302)->setData("/applications/doctor?id={$_SESSION['id']}");
                    die();
                }
                else {
                    echo $response->setStatus('url')->setCode(302)->setData('/list');
                    die();
                }
            }
        }
    }

    public function logout(Request $request): string
    {
        coreAuth::logout();
        session_unset();
        app()->route->redirect('/login');
    }

}