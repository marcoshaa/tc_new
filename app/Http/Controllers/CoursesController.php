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

    function nameMatter($id){
        $return = Matter::where('id','=',$id)->first();
        return $return->name;
    }

    function nameTeacher($id){
        $return = User::where('id','=',$id)->first();
        return $return->name;
    }

    //retorna todos os cursos 
    public function allCourses(){
        $cursos = Courses::where('status','=','1')->get();
        $y = array();
        foreach($cursos as $curso){
            $y[] = array(
                'id'          =>$curso->id,
                'name'        =>$curso->name,
                'teacher_name'=>$this->nameTeacher($curso->teacher_code),
                'teacher_code'=>$curso->teacher_code,
                'matter'      =>$this->nameMatter($curso->id_matter),
                'status'      =>$curso->status,
            );
        }
        return json_encode($y);
    }

    //retorna todos os cursos/ visao gerencial
    public function tdsCursos(){
        $cursos = Courses::all();
        $y = array();
        foreach($cursos as $curso){
            $y[] = array(
                'id'          =>$curso->id,
                'name'        =>$curso->name,
                'teacher_name'=>$this->nameTeacher($curso->teacher_code),
                'teacher_code'=>$curso->teacher_code,
                'matter'      =>$this->nameMatter($curso->id_matter),
                'status'      =>$curso->status,
            );
        }
        $cursosAtivos = Courses::where('status','=','1')->count();
        $cursosInativos = Courses::where('status','=','0')->count();
        $y[] = array(
            'ativos'   =>$cursosAtivos,
            'Inativos' =>$cursosInativos,
        );
        return json_encode($y);
    }

    public function viewImg(Request $request){        
        return Storage::response($request->route);
    }

    public function authCourse(Request $request){
        $user = User::where('id','=', $request->id)->first();
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

    //cadastra novas materias
    public function cadMatter(Request $request){
        $newCad = new Matter;
        $newCad->name = $request->name;
        $newCad->save();
        $x = array();
        if(!empty($newCad->id)){
            $x[0] = 'cadastro realizado com sucesso';
        }else{
            $x[0] = 'cadastro não realizado';
        }
        $x[1] = $newCad;
        return json_encode($x);
    }

    //consulta materia
    public function buscaMateria(Request $request){
        $busca = Matter::where('id','=',$request->id)->first();        
        $x=array();
        if(!empty($busca)){
            $x[0]='ok';
        }else{
            $x[0]='falha na busca';
        }
        $x[1] =  $busca;
        return json_encode($x);
    }
}
