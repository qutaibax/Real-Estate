<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Apartment\AddApartmentController;
use App\Http\Controllers\Apartment\BookController;
use App\Http\Controllers\Apartment\BrowseApartmentController;
use App\Http\Controllers\Apartment\FilterController;
use App\Http\Controllers\Apartment\ShowAllBookingsController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Modification\ModificationController;
use App\Http\Controllers\Verifying\SendCodeController;
use App\Http\Controllers\Verifying\VerifyCodeController;
use Illuminate\Support\Facades\Route;


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

////verifying
Route::post('/users/{user}/verify', [VerifyCodeController::class, 'verify']);

///get all bookings


/////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['auth:sanctum']], function () {


    Route::get('filter', [FilterController::class, 'filter']);
    Route::post('logout', [UserController::class, 'logout']);

    //Apartment
    Route::post('add', [AddApartmentController::class, 'add']);
    Route::post('images/{id}', [AddApartmentController::class, 'addImages']);

    ///bookings
    Route::post('book', [BookController::class, 'books']);
    Route::get('browse-books', [BookController::class, 'myApartmentRequests']);
    Route::patch('accept-offer/{id}', [BookController::class, 'acceptOffer']);
    Route::patch('reject-offer/{id}', [BookController::class, 'rejectOffer']);
    Route::get('bookings/{user}', [ShowAllBookingsController::class, 'index']);

    ////Modifications  here I have not tried it yet
    Route::post('edit', [ModificationController::class, 'edit']);
    Route::get('browse-modifications', [ModificationController::class, 'index']);
    Route::patch('accept-edit/{id}', [ModificationController::class, 'acceptEdit']);
    Route::patch('reject-edit/{id}', [ModificationController::class, 'rejectEdit']);
    //////////////
    Route::get('user-bookings', [ShowAllBookingsController::class, 'index']);

});

Route::get('apartment-browse', [BrowseApartmentController::class, 'index']);

//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//ADMIN SECTION
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//Apartment
Route::get('apartment', [ApartmentController::class, 'index']);//browse apartment for admin
Route::patch('ok/{id}', [ApartmentController::class, 'accept']);//accept for admin
Route::patch('no/{id}', [ApartmentController::class, 'reject']);//reject for admin
//users
Route::get('browse', [AdminController::class, 'index']);
Route::patch('accept/{id}', [AdminController::class, 'accept']);
Route::patch('reject/{id}', [AdminController::class, 'reject']);

///LOG IN
Route::post('admin-login', [LoginController::class, 'adminLogin']);
