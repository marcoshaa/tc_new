<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Emblem;
Use DB;


class EmblemController extends Controller
{
    public function show(){
        
        $j = Emblem::all();
        return json_encode($j);
    }

    //retorna todos os cursos 
    public function selectEmblem(Request $request){
        $emblema = Emblem::where('id','=',$request->id)->first();
        return json_encode($emblema);
    }
}
