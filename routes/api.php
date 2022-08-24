<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function(){
    return 'manual do aluno';
});

Route::controller(ApiUserController::class)->group(function(){
    
    Route::post('/creat','index')->name('creat.index');
    Route::post('/profile-update','updateProfile')->name('updateProfile');

});

// Route::post('/auth/1', [ApiUserController::class, 'index'])->name('index');
