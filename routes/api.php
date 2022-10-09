<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Services\ResponseService;

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
//Route::post('login', 'UserController@login')->name('users.login');

// Route::group(['prefix' => 'v1', 'middleware' => 'jwt.verify'],function () {
//     Route::post('logout', 'UserController@logout')->name('users.logout');
// });
Route::controller(AuthController::class)->group(function(){

    Route::post('/login', 'login')->name('login.api');
    Route::middleware('jwt.verify')->post('logout', 'logout')->name('deslogar');
    Route::middleware('jwt.verify')->post('refresh', 'refresh')->name('att');
    Route::middleware('jwt.verify')->post('me', 'me')->name('i');
});

Route::controller(UserController::class)->group(function(){

    Route::post('/creat','index')->name('users.store');//cria user
    Route::middleware('jwt.verify')->post('/profile-update','updateProfile')->name('updateProfile');//atualiza  perfil
    Route::post('/allTeacher','allTeacher')->name('allTeacher.index');//busca todos professores
    Route::post('/selectTeacher','selectTeacher')->name('selectTeacher.index');//busca professor pelo id
    // Route::post('/login','login')->name('users.login');//login JWT
});

Route::controller(UploadController::class)->group(function(){
    
    Route::post('/upload','store')->name('apload.file');//sobe os aquivos dos  cursos
    // Route::post('/','')->name('');
    // Route::post('/','')->name('');
});

Route::controller(QuizController::class)->group(function(){
    
    Route::post('/standard-help','standard')->name('help.index');//duvidas padroes
    Route::post('/standard-help/creat','creatStandard')->name('helpCreat.index');//criar duvidas padroes
    Route::middleware('jwt.verify')->post('/request-help','creatRequestHelp')->name('helpRequest.index');//pedido de ajuda
    Route::post('/resposta','responseForm')->name('responseForm');
    Route::middleware('jwt.verify')->post('/creat_quiz','creatQuiz')->name('creat_quiz');//cria as questoes dos cursos
});

Route::controller(CoursesController::class)->group(function(){
        
    Route::post('/view_img','show')->name('show.img');//captura a imagen do curso 
    Route::post('/allCourses','allCourses')->name('courses.index');//mostra todos os cursos
});

Route::controller(EmblemController::class)->group(function(){
        
    Route::post('/view_emblem','show')->name('show.emblem');//captura todos os emblemas
    Route::post('/selectEmblem','selectEmblem')->name('selectEmblem.index');//escolhe um emblema
    
});

// Route::post('/auth/1', [UserController::class, 'index'])->name('index');
