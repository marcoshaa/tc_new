<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\CoursesImg;
use App\Models\Article;
Use DB;

class UploadController extends Controller
{
    public function store(Request $request){

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
            return json_encode('ok');
        }
    }
    public function cadArticle(Request $request){
        $images = $request->file('images');

        $artigo = new Article;
        $artigo->title=$request->title;
        $artigo->subtitle=$request->subtitle;
        $artigo->bio=$request->bio;
        $artigo->rota= $image->store('public/artigo/');;
        $artigo->save();

        if(!empty($artigo->id)){
            $x = 'cadastro realizado com sucesso';
        }else{
            $x = 'cadastro não realizado';
        }

        return json_encode($x);
    }
}
