<?php

namespace App\Http\Controllers;

use App\Patrimonios;
use App\Setores;
use App\Variables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PatrimoniosController extends Controller
{
    public function show($id){

        return view('patrimonios.patrimonios',compact('id'));
    }
    public function getdata($id){
        $user = Auth::user();
        if($user->level >= 1){
            $patrimonios = Patrimonios::where('sec_id', decrypt($id))->get();
            for ($i = 0; $i < count($patrimonios); $i++){
                $patrimonios[$i]['idd'] = encrypt($patrimonios[$i]->id);
                switch ($patrimonios[$i]->estado){
                    case Variables::RUIM:
                        $patrimonios[$i]->estado = 'Ruim';
                        break;
                    case Variables::REGULAR:
                        $patrimonios[$i]->estado = 'Regular';
                        break;
                    case Variables::OTIMO:
                        $patrimonios[$i]->estado = 'Ótimo';
                        break;
                    default:
                        $patrimonios[$i]->estado = 'Error !!';
                        break;
                }
                switch ($patrimonios[$i]->situacao){
                    case Variables::DISPONIVEL:
                        $patrimonios[$i]->situacao = 'Disponível';
                        break;
                    case Variables::INDISPONIVEL:
                        $patrimonios[$i]->situacao = 'Indisponível';
                        break;
                    case Variables::NAOENCONTRADO:
                        $patrimonios[$i]->situacao = 'Não Encontrado';
                        break;
                    default:
                        $patrimonios[$i]->situacao = 'Error !!';
                        break;
                }
            }
            return DataTables::of($patrimonios)->make(true);
        }
        else{
            return abort(403, 'Você não tem permissão suficente');
        }
    }
    public function adicionar(){
        $user = Auth::user();
        if($user->level >= 3){
            $setores = Setores::where('sec_id', $user->sec_id)->where('status', 1)->get();
            return view('patrimonios.adicionar', compact('setores'));
        }
        else{
            return abort(403, 'Você não tem permissão suficente');
        }
    }
    public function create(Request $request){
        $user = Auth::user();
        if($user->level >= 3){
            $validator = Validator::make($request->all(), [
                'namePatri' => ['required'],
                'setorPatri' => ['required'],
                'codPatri' => ['required'],
                'numPatri' => ['required'],
                'dataPatri' => ['required'],
                'estPatri' => ['required'],
                'situPatri' => ['required'],
                'locPatri' => ['required'],
                'obsPatri' => ['required']
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Verifique se os dados foram preenchidos corretamente');
            }
            else{
                $dados = array('sec_id' => $user->sec_id, 'nome' => $request->namePatri, 'setor_id' => $request->setorPatri ,'codigo' => $request->codPatri, 'numero' => $request->numPatri, 'dtaquisicao' => $request->dataPatri, 'estado' => decrypt($request->estPatri),
                    'situacao' => decrypt($request->situPatri), 'localizacao' => $request->locPatri, 'observacao' => $request->obsPatri);
                if (Patrimonios::create($dados) == true){
                    return redirect()->route('patrimoniosShow')->with('success', 'Sucesso !!');
                }
                else{
                    return redirect()->back()->with('error', 'Error ao salvar os dados !!');
                }
            }

        }
        else{
            return abort(403, 'Você não tem permissão suficente');
        }
    }
    public function getPatri($id){
        $user = Auth::user();
        if($user->level >= 3){
            $patrimonio = Patrimonios::find(decrypt($id));
            $dados = array('namePatri' => $patrimonio->nome, 'setorPatri' => $patrimonio->setor_id ,'codPatri' => $patrimonio->codigo, 'numPatri' => $patrimonio->numero, 'dataPatri' => $patrimonio->dtaquisicao, 'estPatri' => $patrimonio->estado,
                'situPatri' => $patrimonio->situacao, 'locPatri' => $patrimonio->localizacao, 'obsPatri' => $patrimonio->observacao);
            return $dados;
        }
        else{
            return 'Você não tem permissão suficente';
        }
    }
    public function update(Request $request){
        $user = Auth::user();
        if($user->level >= 3){
            $dados = Patrimonios::find(decrypt($request->reference));
            if ($dados == null){
                return 2;
            }
            if(!empty($request->namePatri)){
                $dados['nome'] = $request->namePatri;
            }
            if(!empty($request->setorPatri)){
                $dados['setor_id'] = $request->setorPatri;
            }
            if(!empty($request->codPatri)){
                $dados['codigo'] = $request->codPatri;
            }
            if(!empty($request->numPatri)){
                $dados['numero'] = $request->numPatri;
            }
            if(!empty($request->dataPatri)){
                $dados['dtaquisicao'] = $request->dataPatri;
            }
            if(!empty($request->estPatri)){
                $dados['estado'] = $request->estPatri;
            }
            if(!empty($request->situPatri)){
               $dados['situacao'] = $request->situPatri;
            }
            if(!empty($request->locPatri)){
              $dados['localizacao'] = $request->locPatri;
            }
            if(!empty($request->obsPatri)){
                $dados['observacao'] = $request->obsPatri;
            }
            if($dados->update()){
                return 1;
            }
            else{
                return 2;
            }
        }
        else{
            return 'Você não tem permissão suficente';
        }
    }
    public function import(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'import_file' => 'required'
        ]);

        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();
        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = ['sec_id' => $user->sec_id, 'setor_id' => $user->setor_id, 'nome' => $value->nome, 'codigo' => $value->codigo, 'numero' => $value->numero, 'dtaquisicao' => Carbon::parse($value->data_da_aquisicao)->format('Y-m-d'), 'estado' => $value->estado, 'situacao' => $value->situacao, 'localizacao' => $value->localizacao, 'observacao' => $value->observacao];
            }
            if(!empty($arr)){
                Patrimonios::insert($arr);
            }
        }

        return back()->with('success', 'Insert Record successfully.');
    }
}
