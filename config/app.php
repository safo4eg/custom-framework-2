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
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'latin' => \Validators\LatinValidator::class
    ]
];

