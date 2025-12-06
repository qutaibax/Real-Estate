<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Apartment\AddApartmentController;
use App\Http\Controllers\Apartment\FilterController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('filter', [FilterController::class, 'filter']);
    Route::post('logout', [UserController::class, 'logout']);


});
//Apartment
Route::post('add', [AddApartmentController::class, 'add']);
Route::get('apartment', [ApartmentController::class, 'index']);//browse apartment
Route::patch('ok/{id}', [ApartmentController::class, 'accept']);//accept
Route::patch('no/{id}', [ApartmentController::class, 'reject']);//reject

//Admin
Route::get('browse', [AdminController::class, 'index']);
Route::patch('accept/{id}', [AdminController::class, 'accept']);
Route::patch('reject/{id}', [AdminController::class, 'reject']);


