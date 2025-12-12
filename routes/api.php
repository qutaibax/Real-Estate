<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Apartment\AddApartmentController;
use App\Http\Controllers\Apartment\BookController;
use App\Http\Controllers\Apartment\BrowseApartmentController;
use App\Http\Controllers\Apartment\FilterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Verifying\SendCodeController;
use App\Http\Controllers\Verifying\VerifyCodeController;
use Illuminate\Support\Facades\Route;


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

////verifying
Route::post('/users/{user}/verify', [VerifyCodeController::class, 'verify']);


Route::group(['middleware' => ['auth:sanctum']], function () {



    Route::get('filter', [FilterController::class, 'filter']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::post('add', [AddApartmentController::class, 'add']);
    Route::post('images/{id}', [AddApartmentController::class, 'addImages']);
    Route::get('apartment-browse',[BrowseApartmentController::class, 'index']);


    Route::post('book',[BookController::class, 'books']);
    Route::get('browse-books', [BookController::class, 'myApartmentRequests']);
    Route::patch('accept_offer/{id}', [BookController::class, 'acceptOffer']);
    Route::patch('reject_offer/{id}', [BookController::class, 'rejectOffer']);


});

/////////////////////////////////////////////////////////////////////////////////////////
//Admin


//Apartment
Route::get('apartment', [ApartmentController::class, 'index']);//browse apartment for admin
Route::patch('ok/{id}', [ApartmentController::class, 'accept']);//accept for admin
Route::patch('no/{id}', [ApartmentController::class, 'reject']);//reject for admin
//users
Route::get('browse', [AdminController::class, 'index']);
Route::patch('accept/{id}', [AdminController::class, 'accept']);
Route::patch('reject/{id}', [AdminController::class, 'reject']);


