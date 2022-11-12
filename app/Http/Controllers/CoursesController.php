<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Courses;
use App\Models\Matter;
use App\Models\CoursesImg;
Use DB;


class CoursesController extends Controller
{
    //seleciona o curso
    public function show(Request $request){
        
        $id = $request->id_courses;
        $table_filter = DB::table('courses_img');
        $table_filter->where('id_courses','=',$id);
        $j = $table_filter->get();
        
        return json_encode($j);
    }

    //retorna todos os cursos 
    public function allCourses(){
        $cursos = Courses::where('status','=','1')->get();
        return json_encode($cursos);
    }

    public function viewImg(Request $request){        
        return Storage::response($request->route);
    }

    public function authCourse(Request $request){
        $user = User::where('id', Auth::id())->first();
        if($user->occupation != 'adm'){
            $retorno='Usuário sem permissão';
        }else{
            $cursos = Courses::where('id','=',$request->id)->update(['status'=>'1']);
            $retorno = array();
            if(!empty($cursos)){
                $retorno[0] = 'atualizado com sucesso';
            }else{
                $retorno[0] = 'não foi atualizado';
            }
            $retorno[1]= $cursos;            
        }
        return json_encode([$retorno]);
    }

    public function statusOffCourse(){
        $cursos = Courses::where('status','=','0')->get();
        return json_encode($cursos);
    }

    public function cadMatter(Request $request){
        $newCad = new Matter;
        $newCad->name = $request->name;
        $newCad->save();
        if(!empty($newCad->id)){
            $x = 'cadastro realizado com sucesso';
        }else{
            $x = 'cadastro não realizado';
        }
        return json_encode($x);
    }
}
