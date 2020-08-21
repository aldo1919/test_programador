<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    function GetUsers(Request $request){
        $cantidad = isset($request->hoja) ? $request->hoja  : 30 ;
        $data = User::paginate($cantidad);
        return json_encode($data,200);
    }
    function ChangeState(Request $request){
        $id = $request->id;
        $estado = ($request->estado == 1) ? 0 : 1 ; 
        $user = User::find($id);
        $user->estado = $estado;
        $user->save();
        if($user){
            return $estado;
        }else{
            return 'error';
        }
    }
}
