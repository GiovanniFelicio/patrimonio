<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostra(Request $request){
        $user = User::all();
        $level = Auth::user()->level;
        $name = $request->user()->name;
        $email = $request->user()->email;
        if ($level < 3 ){
            abort(403, 'Você não é um Administrador');
        }

        return view('admin.users', compact('user', 'name', 'email'));
    }
    public function buscar(Request $request){
        $level = Auth::user()->level;

        if ($level < 3 ){
            abort(403, 'Você não é um Administrador');
        }
        $dados = $request->proc;
        if ($dados == ''){
            return redirect()->back();
        }
        else{
            return redirect(route('users'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Verifique se os dados foram preenchidos corretamente.');
        } else {

            $request->merge(['password' => bcrypt($request->password)]);
            $create = User::create($request->all());
            if($create == true){
                return redirect()->back()->with('success', 'Usuário criado com Sucesso !!');
            }
            else{
                return redirect()->back()->with('error', 'Erro ao criar usuário, tente novamente. Caso persista, contate  o departamento de iformática da FUNDETEC.');
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function allFuncsSec($id){
        $user = Auth::user();
        if ($user->level >= 3){
            $funcs = User::where('setor_id',0)->where('sec_id', $id)->where('status',1)->get();
        }
        else{
            abort(403, 'Você não é um Administrador');
        }
        return response()->json($funcs);
    }
}
