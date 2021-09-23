<?php

namespace App\Http\Controllers;

use App\Secretarias;
use App\Setores;
use App\User;
use App\UsersActions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SetoresController extends Controller
{
    public function getsectors($id){
        $user = Auth::user();
        if($user->level >= 3){
            $setores = Setores::where('sec_id',decrypt($id))->get();
            $dados = array();
            for ($i = 0; $i < count($setores); $i++){
                array_push($dados, ['reference' => $setores[$i]->id, 'nameSector' => $setores[$i]->name]);
            }
            return $dados;
        }
        else{
            return 'Você não tem permissão suficente';
        }
    }
    public function show()
    {
        $user = Auth::user();
        if ($user->level >= 1) {
            return view('setores.setores');
        } else {
            return abort(403, 'Você não é um Administrador');
        }
    }

    public function sectors($id)
    {

        $level = Auth::user()->level;
        if ($level < 2) {
            abort(403, 'Você não é um Administrador');
        }
        $sector = Setores::where('sec_id', decrypt($id))->pluck('name', 'id');
        return response()->json($sector);
    }

    public function adcSetor()
    {
        if (Auth::user()->level < 2) {
            abort(403, 'Você não é um Administrador');
        }
        $secretarias = Secretarias::all();
        return view('setores.adicionar', compact('secretarias'));
    }

    public function create(Request $request)
    {

        $user = Auth::user();
        if ($user->level >= 4) {
            $validator = Validator::make($request->all(), [
                'nameSector' => ['required', 'string'],
                'secretaria' => ['required', 'string']
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Erro !! Verifique se foi digitado os Dados correntamente, Não esqueça de selecionar uma Sec/Aut.');
            }
            if (Secretarias::where('id', decrypt($request->secretaria))->count() == 0) {
                return redirect()->back()->with('error', 'Secretaria Inválida');
            }
            else {
                    $sec = decrypt($request->secretaria);
                    $secretaria = Secretarias::find($sec)->name;
                    $setor = Setores::where('name', $request->nameSector)->get();
                    if ($setor->count() == 1) {
                        $sector = $setor->last();
                        if ($sector->status == 1) {
                            return redirect()->route('setoresShow')->with('error', 'Esse setor já existe !!');
                        } else {
                            $sector->status = 1;
                            if ($sector->update()) {
                                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Reativou o Setor ' . $sector->name . ' da Sec/Aut ' . $secretaria);
                                UsersActions::create($logs);
                            }
                        }
                    }
                    $dados = array('sec_id' => $sec, 'name' => $request->nameSector);
                    $create = Setores::create($dados);
                    $nameSector = $create->name;
                    if ($create == true) {
                        $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Criou o Setor ' . $nameSector . ' da Sec/Aut ' . $secretaria);
                        UsersActions::create($logs);
                        return redirect()->route('setoresShow')->with('success', 'Setor Adicionado com sucesso !!');
                    } else {
                        return redirect()->back()->with('error', 'Error ao adicionar o Setor, caso persista comunique o setor de informatica da FUNDETEC.');
                    }
                }
        } elseif ($user->level == 2 or $user->level == 3) {

            $validator = Validator::make($request->all(), [
                'nameSector' => ['required', 'string']
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Erro !!, Verifique se foi digitado um nome valido.');
            } else {
                $secretaria = Secretarias::find($user->sec_id)->name;
                $setor = Setores::where('name', $request->nameSector)->get();
                if ($setor->count() == 1) {
                    $sector = $setor->last();
                    if ($sector->status == 1) {
                        return redirect()->route('setoresShow')->with('error', 'Esse setor já existe !!');
                    } else {
                        $sector->status = 1;
                        if ($sector->update()) {
                            $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Reativou o Setor ' . $sector->nameSector . ' da Sec/Aut ' . $secretaria);
                            UsersActions::create($logs);
                        }
                    }
                }
                $dados = array('sec_id' => $user->sec_id, 'name' => $request->nameSector);
                if (Setores::create($dados)) {
                    $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Criou o Setor ' . $request->nameSector . ' da Sec/Aut ' . $secretaria);
                    UsersActions::create($logs);
                    return redirect()->route('setoresShow')->with('success', 'Setor Adicionado com sucesso !!');
                } else {
                    return redirect()->back()->with('error', 'Error ao adicionar o Setor, caso persista comunique o setor de informatica da FUNDETEC.');
                }
            }
        } else {
            return abort(403, 'Você não é um Administrador');
        }

    }

    public function delete($idd)
    {
        $user = Auth::user();
        $id = decrypt($idd);
        if ($user->level >= 3) {
            $funcs = Setores::find($id)->employees;
            for ($i = 0; $i < count($funcs); $i++) {
                $funcs[$i]->setor_id = 0;
                $funcs[$i]->update();
            }
            $sectors = Setores::find($id);
            $sectors->status = 0;
            $secretaria = Secretarias::find($sectors->sec_id)->nameSec;
            if ($sectors->update()) {
                $logs = array('func' => $user->id, 'sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'action' => 'Deletou o setor ' . $sectors->nameSector . ' da Sec/Aut ' . $secretaria);
                UsersActions::create($logs);
                return redirect()->back()->with('success', 'Deletado com Sucesso !!');
            } else {
                return redirect()->back()->with('error', 'Erro ao Deletar');
            }
        } else {
            return abort(403, 'Você não é um Administrador');
        }
    }

    public function getdata()
    {
        $user = Auth::user();
        if ($user->level >= 3) {
            $sector = Setores::where('status', 1)->get();
            for ($i = 0; $i < count($sector); $i++) {
                if ($sector[$i]->sec_id == 0 or $sector[$i]->sec_id == null) {
                    $sector[$i]->secretaria = 'Sem Secretaria/Autarquia';
                } else {
                    $sector[$i]->secretaria = Secretarias::find($sector[$i]->sec_id)->name;
                }
            }
        } elseif ($user->level <= 2) {
            $sector = Setores::where('sec_id', $user->sec_id)->get();
        } else {
            return abort(403, 'Você não tem permissão suficente');
        }
        for ($i = 0; $i < count($sector); $i++) {
            $sector[$i]->data = Carbon::parse($sector[$i]->created_at)->format('d/m/Y') . ' às ' . Carbon::parse($sector[$i]->created_at)->format(':i:s');
        }
        return DataTables::of($sector)
            ->addColumn('action', function ($data) {
                $id = encrypt($data->id);
                if (Auth::user()->level >= 3) {
                    if (Secretarias::find($data->sec_id) == null) {
                        $button = '<a href="#"><button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button></a>&nbsp;&nbsp;';
                        $button .= '<a data-id="' . $id . '" class="item delete del" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    } else {
                        $button = '<a style="color: black" data-id="' . $id . '" class="item delete del" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    }
                } else {
                    if (Secretarias::find($data->sec_id) != null) {
                        $button = '<a href="' . route('viewSectors', encrypt($data->id)) . '"><button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></button></a>&nbsp;&nbsp;';
                    } else {
                        $button = '';
                    }
                }
                return $button;
            })->make(true);
    }
}

