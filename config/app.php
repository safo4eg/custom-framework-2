<?php

return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity'=>\Model\Employee::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class
    ]
];

