<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Emblem;
use App\Models\Log;
use App\Models\User;
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

    public function creatEmblema(Request $request){
        $x = array();
        $new = new Emblem;
        $new->name          = $request->name;
        $new->goal          = $request->goal;
        $new->description   = $request->description;
        $new->img_route     = $request->img_route;
        $user_l = User::where('id','=',$request->id_user)->first();
        if(!empty($new)){
            $new->save();
            $log = new Log;
            $log->title = 'Criação de Emblema';
            $log->user_email = $user_l->email;
            $log->mensage = 'Foi criado um emblema de id ('.$new->id.') com o nome de ('.$new->name.') pelo usuário de id ('.$user_l->id.')';
            $log->save();
            $x[0] = 'sucess';
            $x[1] = $new;
            $x[2] = $log;
            return json_encode($x);
        }
        $x[0] = 'erro';
        return json_encode($x);
    }
}
