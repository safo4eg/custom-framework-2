<?php

use Src\Route;

Route::add(['GET', 'POST'],'/login', [Controller\Auth::class, 'login']);
Route::add('GET','/logout', [Controller\Auth::class, 'logout'])->middleware('auth');
Route::add('GET','/non-access', [Controller\NonAccess::class, 'show'])->middleware('auth');


Route::add(['GET', 'POST'], '/list', [Controller\ListPage::class, 'show'])->middleware('auth');
Route::add(['GET', 'POST'], '/applications/patient', [Controller\ListPage::class, 'patient_applications'])->middleware('auth', 'non-access:type=role[2,3,5]');
Route::add(['GET', 'POST'], '/applications/doctor', [Controller\ListPage::class, 'doctor_applications'])->middleware('auth', 'non-access:type=role[2,3,4]', 'non-access:type=id');
Route::add('GET', '/search', [Controller\ListPage::class, 'search'])->middleware('auth');

Route::add('POST','/add/employee', [Controller\Actions::class, 'add_employee'])->middleware('auth');
Route::add('POST','/add/patient', [Controller\Actions::class, 'add_patient'])->middleware('auth');
Route::add('POST','/add/diagnostic', [Controller\Actions::class, 'add_diagnostic'])->middleware('auth');
Route::add('POST','/edit', [Controller\Actions::class, 'edit']);
