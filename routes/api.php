<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\UploadController;

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

Route::controller(UploadController::class)->group(function(){
    
    Route::post('/upload','store')->name('apload.file');
    Route::post('/view_img','show')->name('show.img');
    // Route::post('/','')->name('');
    // Route::post('/','')->name('');
    // Route::post('/','')->name('');

});

// Route::post('/auth/1', [ApiUserController::class, 'index'])->name('index');
