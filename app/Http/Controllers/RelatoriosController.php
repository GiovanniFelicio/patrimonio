<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class RelatoriosController extends Controller
{

    public function registroLogBook(){
        $user = Auth::user();
        if($user->level >= 3) {
            return view('relatorios.registroLogBook');
        }
        else{
            return abort(403, 'Você não tem permissão suficente');
        }
    }
    public function filtro(){
        $user = Auth::user();
        if ($user->level >= 3){
            return view('relatorios.filtro');
        }
        else{
            return abort(403, 'Error de permissão !!');
        }
    }
}
