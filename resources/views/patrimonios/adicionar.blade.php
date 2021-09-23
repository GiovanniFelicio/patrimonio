@extends('layouts.default')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <script>
        $(".alert").fadeTo(3200, 800).slideUp(1000, function(){
            $(".alert").slideUp(500);
        });
    </script>
    <br>
    <div class="au-card chart-percent-card">
        <div class="au-card-inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center">Adicionar Patrimônio(s)</h1>
                        </div>
                    </div>
                    <br><br>
                    <div>
                        <form method="POST" action="{{route('createPatri')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Nome</label>
                                    <input type="text" class="form-control au-input au-input--full" id="inputName" name="namePatri" placeholder="Nome do Patrimônio">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputSetor">Setor</label>
                                    <select id="inputSetor" name="setorPatri" class="form-control au-input au-input--full">
                                        <option selected>Escolher...</option>
                                        @foreach($setores as $setor)
                                            <option value="{{encrypt($setor->id)}}">{{$setor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputCodigo">Código</label>
                                    <input type="text" class="form-control au-input au-input--full" name="codPatri" id="inputCodigo">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputNum">Número</label>
                                    <input type="text" class="form-control au-input au-input--full" name="numPatri" id="inputNum">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputDate">Data da Aquisição</label>
                                    <input type="date" class="form-control au-input au-input--full" name="dataPatri" id="inputDate">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEst">Estado</label>
                                    <select id="inputEst" name="estPatri" class="form-control au-input au-input--full">
                                        <option selected disabled>Escolher...</option>
                                        <option value="{{encrypt(1)}}">Ruim</option>
                                        <option value="{{encrypt(2)}}">Regular</option>
                                        <option value="{{encrypt(3)}}">Ótimo</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputSit">Situação</label>
                                    <select id="inputSit" name="situPatri" class="form-control au-input au-input--full">
                                        <option selected disabled>Escolher...</option>
                                        <option value="{{encrypt(1)}}">Disponível</option>
                                        <option value="{{encrypt(2)}}">Indisponível</option>
                                        <option value="{{encrypt(3)}}">Não encontrado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputLoca">Localização</label>
                                    <input type="text" class="form-control au-input au-input--full" name="locPatri" id="inputLoca" placeholder="Localização do patrimônio">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputObs">Observação(ões)</label>
                                    <input type="text" class="form-control au-input au-input--full" name="obsPatri" id="inputObs" placeholder="Ex: Quebrado, Faltando Hd">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

