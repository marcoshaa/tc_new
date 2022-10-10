<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\User;
use App\Models\Courses;
use App\Models\CoursesImg;
Use DB;


class CoursesController extends Controller
{
    public function show(Request $request){
        
        $id = $request->id_courses;
        $table_filter = DB::table('courses_img');
        $table_filter->where('id_courses','=',$id);
        $j = $table_filter->get();
        
        return json_encode($j);
    }

    //retorna todos os cursos 
    public function allCourses(){
        $cursos = Courses::all();
        return json_encode($cursos);
    }

    //retorna todos os cursos 
    public function selectCourses(){
        $cursos = Courses::all();
        return json_encode($cursos);
    }
}
