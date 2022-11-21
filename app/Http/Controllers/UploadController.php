<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\CoursesImg;
use App\Models\Article;
use App\Models\User;
use App\Models\Matter;
use App\Models\Log;
Use DB;

class UploadController extends Controller
{
    public function cadCurso(Request $request){

        $val = [
            'images'       =>['required'],
            'teacher_code' =>['required'],
            'name'         =>['required',],
        ];
        $validacao = Validator::make($request->all(),$val);
        // dd($request->file('images'));
        if($validacao->fails()){
            return response()->json(['erro'=> $validacao->messages()],200);
        }else{
            $user_l = User::where('id','=',$request->teacher_code)->first();
            $images = $request->file('images');

            $un = new Courses();
            $un->name = $request->name;
            $un->id_matter = $request->id_matter;
            $un->teacher_code = $request->teacher_code;
            $un->save();

            if(!empty($images)){
                foreach($images as $image){
                    $route = $image->store('public/courses/'.$un->id);
                    $course_img = new CoursesImg;
                    $course_img->id_courses = $un->id;
                    $course_img->route = $route;
                    $course_img->save();
                }                
            }
            $log = new Log;
            $log->title = 'Criação de Cruso';
            $log->user_email = $user_l->email;
            $log->mensage = 'Foi criado um Curso de id ('.$un->id.') com o nome de ('.$un->name.') pelo professor de id ('.$request->teacher_code.')';
            $log->save();
            return json_encode('ok');
        }
    }
    public function cadArticle(Request $request){
        $user_l = User::where('id','=',$request->id_user)->first();
        $images = $request->file('images');
        $route = $images->store('public/artigo');
        $artigo = new Article;
        $artigo->title      =$request->title;
        $artigo->subtitle   =$request->subtitle;
        $artigo->bio        =$request->bio;
        $artigo->id_matter  =$request->id_matter;
        $artigo->rota       =$route;
        $artigo->save();
        $x = array();
        if(!empty($artigo->id)){           
            $log = new Log;
            $log->title = 'Criação de Artigo';
            $log->user_email = $user_l->email;
            $log->mensage = 'Foi criado um Artigo de id ('.$artigo->id.') com o nome de ('.$artigo->title.') pelo professor de id ('.$user_l->id.')';
            $log->save();
            $x[0] = 'cadastro realizado com sucesso';
            $x[1] = $artigo;
            $x[2] = $log;
        }else{
            $x[0] = 'cadastro não realizado';
        }
        $x[1]=$artigo;
        return json_encode($x);
    }
    function nameMatter($id){
        $return = Matter::where('id','=',$id)->first();
        return $return->name;
    }

    public function allArtigos(){
        $artigos = Article::all();
        $x = array();
        foreach($artigos as $artigo){
            $x[] = array(
                'id'        =>$artigo->id,
                'title'     =>$artigo->title,
                'subtitle'  =>$artigo->subtitle,
                'bio'       =>$artigo->bio,
                'id_matter' =>$this->nameMatter($artigo->id_matter),
                'matter'    =>$this->nameMatter($artigo->id_matter),
                'status'    =>$artigo->status,
                'rota'      =>$artigo->rota,
            );
        }
        $ativo = Article::where('status','=','1')->count();
        $inativo = Article::where('status','=','0')->count();
        $x[] = array(
            'inativos' =>$inativo,
            'ativo'    =>$ativo,
        );
        return json_encode($x);
    }

    public function allMatter(){
        $materias = Matter::all();
        $x = array();
        foreach($materias as $materia){
            $x[] = array(
                'id'   => $materia->id,
                'name' => $materia->name,
            );
        }
        return json_encode($x);
    } 

    public function viewArticle(Request $request){
        $xs = Article::where('status','=','0')->get();
        $y=array();
        foreach($xs as $x){
            $y[] = array(
                'id'        =>$x->id,
                'title'     =>$x->title,
                'subtitle'  =>$x->subtitle,
                'bio'       =>$x->bio,
                'matter'    =>$this->nameMatter($x->id_matter),
                'status'    =>$x->status,
                'rota'      =>$x->rota,
            );
        }
        return json_encode($y);
    }

    public function attArticle(Request $request){
        $user_l = User::where('id','=',$request->id_user)->first();
        $id = $request->id;
        $article = Article::where('id','=',$id)->update(['status'=>'1']);
        $articleNew = Article::where('id','=',$id)->first();
        $x=array();

        $log = new Log;
        $log->title = 'Verificação do Artigo';
        $log->user_email = $user_l->email;
        $log->mensage = 'Foi alterado um Artigo de id ('.$articleNew->id.') com o nome de ('.$articleNew->title.') pelo professor de id ('.$user_l->id.')';
        $log->save();

        $x[0]=$article;
        $x[1]='update realizado com sucesso';
        $x[2] = $log;
        $x[3] = $articleNew;
        return json_encode($x);
    }
}
