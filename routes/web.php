<?php

use Src\Route;

Route::add('login', [Controller\Auth::class, 'login']);
Route::add('go', [Controller\Auth::class, 'go']);
