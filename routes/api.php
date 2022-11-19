<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\EmblemController;
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
    return 'manual dos alunos ';
});
//Route::post('login', 'UserController@login')->name('users.login');

// Route::group(['prefix' => 'v1', 'middleware' => 'jwt.verify'],function () {
//     Route::post('logout', 'UserController@logout')->name('users.logout');
// });
Route::controller(AuthController::class)->group(function(){

    Route::post('/login', 'login')->name('login.api');
    Route::middleware('jwt.verify')->post('/logout', 'logout')->name('deslogar');
    Route::middleware('jwt.verify')->post('/refresh', 'refresh')->name('att');
});

Route::controller(UserController::class)->group(function(){

    Route::post('/creat','index')->name('users.store');//cria user
    Route::middleware('jwt.verify')->post('/profile-update','updateProfile')->name('updateProfile');//atualiza  perfil, menos o email
    Route::post('/allTeacher','allTeacher')->name('allTeacher.index');//busca todos professores
    Route::post('/selectTeacher','selectTeacher')->name('selectTeacher.index');//busca professor pelo id
    Route::post('/alunosHistorico','alunosHistorico')->name('alunosHistorico.index');//busca professor pelo id
    Route::post('/log','logAdm')->name('logAdm.index');//busca professor pelo id
    // Route::post('/login','login')->name('users.login');//login JWT
});

Route::controller(UploadController::class)->group(function(){
    
    Route::middleware('jwt.verify')->post('/upload','cadCurso')->name('apload.file');//sobe os aquivos dos  cursos
    Route::middleware('jwt.verify')->post('/cadArticle','cadArticle')->name('cadArticle.file');//sobe os aquivos dos  artigos
    Route::get('/viewArticle','viewArticle')->name('viewArticle.file');//view dos artigos
    Route::middleware('jwt.verify')->post('/attArticle','attArticle')->name('attArticle.file');//sobe os aquivos dos  artigos
});

Route::controller(QuizController::class)->group(function(){
    
    Route::post('/standard-help','standard')->name('help.index');//duvidas padroes
    Route::post('/standard-help/creat','creatStandard')->name('helpCreat.index');//criar duvidas padroes
    Route::middleware('jwt.verify')->post('/request-help','creatRequestHelp')->name('helpRequest.index');//pedido de ajuda
    Route::post('/resposta','responseForm')->name('responseForm');
    Route::middleware('jwt.verify')->post('/creat_quiz','creatQuiz')->name('creat_quiz');//cria as questoes dos cursos
    Route::middleware('jwt.verify')->post('/history','history')->name('history_quiz');//exibir historico
});

Route::controller(CoursesController::class)->group(function(){
        
    Route::post('/viewCourses','show')->name('show.img');//captura a imagen do curso 
    Route::post('/allCourses','allCourses')->name('courses.index');//mostra todos os cursos
    Route::get('/viewImg','viewImg')->name('courses.index');//mostra todos os cursos
    Route::post('/authCourse','authCourse')->name('authCourse.index');//mostra todos os cursos
    Route::post('/offCourses','statusOffCourse')->name('statusOffCourse.index');//mostra todos os cursos
    Route::post('/cadMatter','cadMatter')->name('cadMatter.index');//cadastra as materias
    Route::post('/buscaMateria','buscaMateria')->name('buscaMateria.index');//passa apenas o id 
});

Route::controller(EmblemController::class)->group(function(){
        
    Route::post('/view_emblem','show')->name('show.emblem');//captura todos os emblemas
    Route::post('/selectEmblem','selectEmblem')->name('selectEmblem.index');//escolhe um emblema    
    Route::post('/creatEmblema','creatEmblema')->name('creatEmblema.index');//cria um emblema
});

// Route::post('/auth/1', [UserController::class, 'index'])->name('index');
