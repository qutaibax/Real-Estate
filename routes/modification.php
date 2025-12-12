<?php

use App\Http\Controllers\Modification\ModificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;



Route::post('edit',[ModificationController::class, 'edit']);
Route::get('browse-modifications',[ModificationController::class, 'index']);
