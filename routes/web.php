<?php

use Src\Route;

Route::add('GET','/login', [Controller\Auth::class, 'login']);
Route::add('GET','logout', [Controller\Auth::class, 'logout']);


Route::add(['GET', 'POST'], 'list', [Controller\ListPage::class, 'show']);
Route::add(['GET', 'POST'], 'applications/patient', [Controller\ListPage::class, 'patient_applications']);
Route::add(['GET', 'POST'], 'applications/doctor', [Controller\ListPage::class, 'doctor_applications']);
Route::add('GET', 'search', [Controller\ListPage::class, 'search']);

Route::add('POST','add/employee', [Controller\Actions::class, 'add_employee']);
Route::add('POST','add/patient', [Controller\Actions::class, 'add_patient']);
Route::add('POST','add/diagnostic', [Controller\Actions::class, 'add_diagnostic']);
Route::add('POST','edit', [Controller\Actions::class, 'edit']);
