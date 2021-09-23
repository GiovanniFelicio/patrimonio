<?php

namespace App\Http\Controllers;

use App\Secretarias;
use App\User;
use App\UsersActions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SecretariasController extends Controller
{
    public function show(){
        $user = Auth::user();
        if ($user->level >= 4){
            return view('secretarias.secretarias');
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }
    }

    public function getdata(){
        $user = Auth::user();
        if($user->level >= 4){
            $secretarias = Secretarias::latest()->get();
            for ($i = 0; $i< count($secretarias); $i++){
                $secretarias[$i]->data = Carbon::parse($secretarias[$i]->created_at)->format('d/m/Y').' às '.Carbon::parse($secretarias[$i]->created_at)->format('H:i:s');
            }
            return DataTables::of($secretarias)
                ->addColumn('action', function($data){
                    $button = '<a style="font-size: 30px" href="'.route('viewSec',encrypt($data->id)).'"><button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="Ver detalhes"><i class="fas fa-eye"></i></button></a>&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<a style="font-size: 30px" href="'.route('patrimoniosShow',encrypt($data->id)).'"><button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="Ver detalhes"><i class="fas fa-clipboard-list"></i></button></a>&nbsp;&nbsp;&nbsp;&nbsp;';
                    return $button;
                })->make(true);
        }
        else{
            return abort(403, 'Você não tem permissao suficente');
        }
    }

    public function adicionar(){
        $user = Auth::user();
        if (!$user->level >= 4){
            abort(403, 'Você não é um Administrador');
        }
        return view('secretarias.adicionar');
    }
    public function create(Request $request){
        $user = Auth::user();

        if(Secretarias::where('emailSec', '=', $request->email)->count() >= 1){
            return redirect()->back()->with('error', 'Essa Empresa Já existe');
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'max:60']
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Verifique se os dados foram preenchidos corretamente');
        }
        else{
            if (Secretarias::create($request->all())){
                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Criou a Secretaria/Autarquia: '. $request->nameSec);
                UsersActions::create($logs);
                return redirect()->route('SecretariasShow')->with('success', 'Secretaria/Autarquia adicionada com Sucesso !!');
            }
            else{
                return redirect()->route('SecretariasShow')->with('error', 'Erro ao tentar adicionar a Secretaria/Autarquia !!');
            }
        }
    }
    public function view($id){
        $user = Auth::user();
        if ($user->level >= 4){
            $allUsers = array();
            $secretarias = Secretarias::find(decrypt($id));
        }
        else{
            abort(403, 'Você não é um Administrador');
        }

        return view('secretarias.view', compact('secretarias', 'allUsers'));
    }

    public function usersForAdm($id){
        $user = Auth::user();
        if ($user->level >= 4){
            $funcsNoAdmin = User::where('level', '<',3)->where('sec_id', $id)->where('status', 1)->get();
            return response()->json($funcsNoAdmin);
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }
    }

    public function usersAdmin($number){
        $user = Auth::user();
        if ($user->level >= 4){
            $users = User::where('level', '>=', 3)->where('sec_id', $number)->where('status', 1)->get();
        }
        else{
            abort(403, 'Você não é um Administrador');
        }

        return response()->json($users);
    }

    public function addFuncAdmSec(Request $request){

        if (Auth::user()->level >= 4){
            for ($j = 0; $j < count($request->Func); $j++){
                $user = User::find($request->Func[$j]);
                $user->level = 3;
                if ($user->update() == false){
                    return 'Erro';
                }
            }
            $secretaria = Secretarias::find($user->sec_id)->nameSec;
            $logs = array('func' => Auth::user()->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Tornou o Funcionario '.$user->name. ' Admin da Secretaria/Autarquia '. $secretaria);
            UsersActions::create($logs);
            return 'Sucesso';
        }
        else {
            return abort(403, 'Você não é um Administrador');
        }
    }
    public function delUserAdmSec($id){

        $user = Auth::user();
        if ($user->level >= 4){
            $authSecUsers = User::find($id);
            $authSecUsers->level = 1;
            $secretaria = Secretarias::find($authSecUsers->sec_id)->nameSec;
            if ($authSecUsers->update())
            {
                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Deletou o Funcionario '. $authSecUsers->name. ' de adm da Secretaria/Autarquia '. $secretaria);
                UsersActions::create($logs);
                return 'Deletado com Sucesso !!';
            }
            else{
                return 'Erro ao Deletar';
            }
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }

    }
}
