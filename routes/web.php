<?php

use Src\Route;

Route::add('login', [Controller\Auth::class, 'login']);
Route::add('logout', [Controller\Auth::class, 'logout']);


Route::add('list', [Controller\ListPage::class, 'show']);
Route::add('search', [Controller\ListPage::class, 'search']);

Route::add('add', [Controller\Actions::class, 'add_employee']);
