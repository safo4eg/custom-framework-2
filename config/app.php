<?php

return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity'=>\Model\Employee::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'non-access' => \Middlewares\NonAccessMiddleware::class
    ],
    'routeAppMiddleware' => [
        'trim' => \Middlewares\TrimMiddleware::class
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'latin' => \Validators\LatinValidator::class
    ]
];

