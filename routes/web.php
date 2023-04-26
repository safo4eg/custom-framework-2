<?php

use Src\Route;

Route::add('index', [Controller\Site::class, 'index']);
Route::add('hello', [Controller\Site::class, 'hello']);