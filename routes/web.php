<?php

use Src\Route;

Route::add('login', [Controller\Auth::class, 'login']);
Route::add('logout', [Controller\Auth::class, 'logout']);


Route::add('list', [Controller\ListPage::class, 'show']);
Route::add('applications/patient', [Controller\ListPage::class, 'patient_applications']);
Route::add('applications/doctor', [Controller\ListPage::class, 'doctor_applications']);
Route::add('search', [Controller\ListPage::class, 'search']);

Route::add('add/employee', [Controller\Actions::class, 'add_employee']);
Route::add('add/patient', [Controller\Actions::class, 'add_patient']);
Route::add('add/diagnostic', [Controller\Actions::class, 'add_diagnostic']);
Route::add('edit', [Controller\Actions::class, 'edit']);
