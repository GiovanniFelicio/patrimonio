<?php

namespace App\Http\Controllers;

use App\AuthFuncVehicle;
use App\Secretarias;
use App\Setores;
use App\User;
use App\UsersActions;
use App\Veiculos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeesController extends Controller
{
    public function show(){
        $user = Auth::user();
        if($user->level >= 3){
            $funcionarios = User::all();
            $count = count($funcionarios);
            for ($i = 0; $i < $count; $i++) {
                if ($funcionarios[$i]->setor_id == 0 or $funcionarios[$i]->setor_id == null) {
                    $funcionarios[$i]->setor = 'Sem Setor';
                } else {
                    $funcionarios[$i]->setor = Setores::find($funcionarios[$i]->setor_id)->nameSector;
                }
                if ($funcionarios[$i]->sec_id == 0 or $funcionarios[$i]->sec_id == null) {
                    $funcionarios[$i]->secretaria = 'Sem Sec/Aut';
                } else {
                    $funcionarios[$i]->secretaria = Secretarias::find($funcionarios[$i]->sec_id)->nameSec;
                }
            }
        }
        elseif($user->level <= 2){
            $funcionarios = User::where('sec_id', $user->sec_id)->get();
            $count = count($funcionarios);
            for ($i = 0; $i < $count; $i++) {
                if ($funcionarios[$i]->setor_id == 0 or $funcionarios[$i]->setor_id == null) {
                    $funcionarios[$i]->setor = 'Sem Setor';
                } else {
                    $funcionarios[$i]->setor = Setores::find($funcionarios[$i]->setor_id)->nameSector;
                }
            }
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }

        return view('employees.employees',compact('funcionarios'));
    }

    public function criaFunc(){
        $user = Auth::user();
        if($user->level >= 2){
            $secretarias = Secretarias::all();
            $setores = Setores::where('sec_id', $user->sec_id)->get();
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }
        return view('employees.criaFunc', compact('setores', 'secretarias'));
    }

    public function create(Request $request){
        $user = Auth::user();
        if($user->level >= 4){
            $sec = decrypt($request->secretaria);

            if(Secretarias::where('id', $sec)->get()->count() == 1){

                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:191'],
                    'setor' => ['required', 'string', 'max:4'],
                    'email' => ['required', 'email', 'max:191'],
                    'matricula' => ['required', 'string', 'max:100']
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'Verifique se os dados foram preenchidos corretamente');
                }
                else{
                    if($request->setor != 0 and Setores::where('id', $request->setor)->count() == 0){
                        return redirect()->back()->with('error', 'Setor Invalido');
                    }
                    $request['password'] = bcrypt(123456789);
                    $func = User::where('email', $request['email'])->get();
                    if($func->count() == 1){
                        $emplo = $func->last();
                        if ($emplo->status == 1){
                            return redirect()->back()->with('error', 'E-mail ja cadastrado');
                        }
                        else{
                            $emplo->status = 1;
                            if($emplo->update()){
                                return redirect()->route('showEmployees')->with('success','Funcionário adicionado com sucesso');
                            }
                            else{
                                return redirect()->back()->with('error','Error ao adicionar o Funcionário, caso persista comunique o setor de informática da FUNDETEC.');
                            }
                        }
                    }
                    elseif(User::where('matricula', $request->matricula)->get()->count() == 1){
                        return redirect()->back()->with('error', 'Matricula já cadastrada');
                    }
                    else {
                        $dados = array('sec_id' => $sec,'setor_id' => $request->setor, 'name' => $request->name,'email' => $request->email, 'password' => $request->password, 'level' => $request->level, 'matricula' => $request->matricula);
                        $create = User::create($dados);
                        if ($create == true){
                            $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Criou o funcionário '.$create->name);
                            UsersActions::create($logs);
                            return redirect()->route('showEmployees')->with('success','Funcionario adicionado com sucesso');
                        }
                        else{
                            return redirect()->back()->with('error','Error ao adicionar o Funcionario, caso persista comunique o setor de informatica da FUNDETEC.');
                        }
                    }
                }
            }
            else{
                return redirect()->back()->with('error', 'Secretaria/Autarquia Invalida');
            }
        }
        elseif($user->level == 2 or $user->level == 3){

            $request['sec_id'] = $user->sec_id;
            if($request['setor'] == 0){
                $request['setor_id'] = $request['setor'];
            }
            elseif(Setores::where('id', $request->setor)->count() == 0){
                return redirect()->back()->with('error', 'Setor Invalido');
            }
            $request['setor_id'] = $request['setor'];
            $validate = $this->validateAndCreateFunc($request->all());
            if ($validate == 'error'){
                return redirect()->back()->with('error', 'Verifique se os dados foram preenchidos corretamente');
            }
            else{
                $request['password'] = bcrypt(123456789);
                if(User::where('email', $request['email'])->get()->count() == 1){
                    return redirect()->back()->with('error', 'E-mail ja cadastrado');
                }
                else {
                    $create = User::create($request->all());
                    if ($create == true){
                        $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Criou o funcionário '.$create->name);
                        UsersActions::create($logs);
                        return redirect()->route('showEmployees')->with('success','Funcionario adicionado com sucesso');
                    }
                    else{
                        return redirect()->back()->with('error','Error ao adicionar o Funcionario, caso persista comunique o setor de informatica da FUNDETEC.');
                    }
                }
            }
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }
    }
    public function editFunc($id){
        $user = Auth::user();
        if($user->level >= 4 ) {
            $employee = User::find(decrypt($id));
            $setores = Setores::where('sec_id', $user->sec_id)->get();
            $secretarias = Secretarias::all();
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }

        return view('employees.edit', compact('employee', 'setores', 'secretarias'));
    }
    public function update(Request $request){
        $user = Auth::user();
        $idFunc = decrypt($request->cdFunc);
        if($user->level >= 4){
            $funcUp = User::find($idFunc);
            $request['setor_id'] = $request->setor;
            $request['sec_id'] = $request->secretaria;
            if ($funcUp == null){
                return redirect()->back()->with('error', 'Erro !! Funcionário inválido');
            }
            if($request->nameFunc != null){
                $funcUp->name = $request->nameFunc;
            }
            if ($request->setor != null){
                if (Setores::find($request->setor) != null){
                    $funcUp->setor_id = $request->setor;
                }
                elseif ($request->setor == 0){
                    $funcUp->setor_id = 0;
                }
            }
            if ($request->sec_id != null){
                if (Secretarias::find($request->sec_id) != null){
                    $funcUp->sec_id = $request->sec_id;
                }
            }
            if ($request->matricula != null){
                $funcUp->matricula = $request->matricula;
            }
            $funcUp->matricula = $request->matricula;
            $funcUp->token_access = null;
            if ($funcUp->update()){
                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Atualizou o Funcionário '.$funcUp->name);
                UsersActions::create($logs);
                return redirect()->route('showEmployees')->with('success','Funcionario atualizado com sucesso');
            }
            else{
                return redirect()->back()->with('error','Error ao atualizar o Funcionario, caso persista comunique o setor de informatica da FUNDETEC.');
            }
        }
        elseif($user->level == 3){
            $funcUp = User::find($idFunc);
            $request['setor_id'] = $request->setor;
            $request['sec_id'] = $request->secretaria;
            if ($funcUp == null){
                return redirect()->back()->with('error', 'Erro !! Funcionário inválido');
            }
            if($request->nameFunc != null){
                $funcUp->name = $request->nameFunc;
            }
            if ($request->setor_id != null){
                if (Setores::find($request->setor) != null){
                    $funcUp->setor_id = $request->setor;
                }
                elseif ($request->setor == 0){
                    $funcUp->setor_id = 0;
                }
            }
            if ($request->sec_id != null){
                if (Secretarias::find($request->sec_id) != null){
                    $funcUp->sec_id = $request->sec_id;
                }
            }
            $funcUp->matricula = $request->matricula;
            $funcUp->token_access = null;
            if ($funcUp->update()){
                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Atualizou o Funcionário '.$funcUp->name);
                UsersActions::create($logs);
                return redirect()->route('showEmployees')->with('success','Funcionario atualizado com sucesso');
            }
            else{
                return redirect()->back()->with('error','Error ao atualizar o Funcionario, caso persista comunique o setor de informatica da FUNDETEC.');
            }
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }

    }
    public function delete($id){
        $user = Auth::user();
        if($user->level >= 3) {
            $employee = User::find(decrypt($id));
            $employee->status = 0;
            if ($employee->update())
            {
                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Desativou o funcionário '.$employee->name);
                UsersActions::create($logs);
                return redirect()->back()->with('error','Deletado com Sucesso !!');
            }
            else{
                return redirect()->back()->with('error','Erro ao Deletar');
            }
        }
        else{
            return abort(403, 'Você não é um Administrador');
        }
    }
    public function funcsSec($idd){
        $user = Auth::user()->level;
        $id = decrypt($idd);
        if($user >= 3){
            $funcs = User::where('sec_id', $id)->get();
            for ($i = 0; $i < count($funcs); $i++){
                $funcs[$i]['reference'] = encrypt($funcs[$i]->id);
            }
        }
        else{
            abort(403, 'Você não é um Administrador');
        }

        return response()->json($funcs);
    }
    public function profileFunc(){
        $func = Auth::user();

        return view('employees.profile', compact('func'));
    }
    public function upProfileFunc(Request $request){
        $user = Auth::user();
        $func = User::find($user->id);
        if($request->name != ' ' or $request->nameFunc != null){
            $func->name = $request->nameFunc;
        }
        if($request->matricula != ' ' or $request->matricula != null){
            $func->matricula = $request->matricula;
        }
        if($request->password != ' ' or $request->password != null){
            $request->merge(['password' => bcrypt($request->password)]);
            $func->password = $request->password;
        }
        if($func->update()){
            $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Atualizou o próprio Perfil');
            UsersActions::create($logs);
            return redirect()->back()->with('success', 'Usuário Atualizado com Sucesso !!');
        }
        else{
            return redirect()->back()->with('error', 'Erro ao atualizar usuário, tente novamente. Caso persista, contate  o departamento de iformática da FUNDETEC.');
        }
    }
    public function getdata(){
        $user = Auth::user();
        if($user->level >= 3){
            $funcionarios = User::where('id', '!=', $user->id)->where('status','!=', 0)->get();
            $count = count($funcionarios);
            for ($i = 0; $i < $count; $i++) {
                if ($funcionarios[$i]->setor_id == 0 or $funcionarios[$i]->setor_id == null) {
                    $funcionarios[$i]->setor = 'Sem Setor';
                } else {
                    $funcionarios[$i]->setor = Setores::find($funcionarios[$i]->setor_id)->name;
                }
                if ($funcionarios[$i]->sec_id == 0 or $funcionarios[$i]->sec_id == null) {
                    $funcionarios[$i]->secretaria = 'Sem Sec/Aut';
                } else {
                    $funcionarios[$i]->secretaria = Secretarias::find($funcionarios[$i]->sec_id)->name;
                }
            }
        }
        elseif($user->level <= 2){
            $funcionarios = User::where('id', '!=', $user->id)->where('sec_id', $user->sec_id)->where('status','!=', 0)->get();
            $count = count($funcionarios);
            for ($i = 0; $i < $count; $i++) {
                if ($funcionarios[$i]->setor_id == 0 or $funcionarios[$i]->setor_id == null) {
                    $funcionarios[$i]->setor = 'Sem Setor';
                } else {
                    $funcionarios[$i]->setor = Setores::find($funcionarios[$i]->setor_id)->name;
                }
            }
        }
        else{
            return abort(403, 'Você não tem permissão suficente');
        }
        return DataTables::of($funcionarios)
            ->addColumn('action', function($data){
                if(Auth::user()->level >= 3){
                    $id = encrypt($data->id);
                    $button = '<a href="'.route('editFunc', $id).'"><button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button></a>&nbsp;&nbsp;';
                    $button .= '<a style="color: black" data-id="'.$id.'" class="item delete del" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    return $button;
                }
                return '-';
            })->make(true);

    }
}
