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
    <div class="col-lg-12">
        <div class="au-card chart-percent-card">
            <div class="au-card-inner">
                <div class="login-logo">
                    <h1>Adicionar Funcionario</h1>
                </div>
                <div class="login-form">
                    <form method="POST" action="{{route('createFunc')}}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Nome do Funcionario</label>
                                <input class="au-input au-input--full" type="text" required name="name" placeholder="Ex: Lucas Silva" autofocus>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    @if(Auth::user()->level >= 4)
                                        <div class="form-group">
                                            <label>Secretaria/Autarquia</label>
                                            <select id="secretaria" name="secretaria" required  class="form-control" onchange="ajax()">
                                                <option selected>Selecione a Sec/Aut</option>
                                                @foreach($secretarias as $secretaria)
                                                    <option value="{{encrypt($secretaria->id)}}">{{$secretaria->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Setor</label>
                                @if(Auth::user()->level >= 4)
                                    <select required  id="sector" name="setor" class="form-control">
                                        <option value="0">Sem Setor</option>
                                    </select>
                                @elseif(Auth::user()->level == 2 or Auth::user()->level == 3)
                                    <select required  name="setor" class="form-control">
                                        <option selected>Selecione o Setor</option>
                                        <option value="0">Sem Setor</option>
                                        @foreach($setores as $setor)
                                            <option value="{{$setor->id}}">{{$setor->name}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>E-mail</label>
                                <input required class="au-input au-input--full " name="email" placeholder="Ex: lucas@exemplo.com" type="email">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Matricula</label>
                                <input required class="au-input au-input--full " name="matricula" placeholder="Ex: 11.111-1" type="text">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Permissao</label>
                                <select required id="level" name="level"  class="form-control">
                                    <option value="1">Usuario</option>
                                    <option value="2">Moderador</option>
                                    <option value="3">Administrador</option>
                                </select>
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
@endsection

<script>
    function formatar(mascara, documento){
        var i = documento.value.length;
        var saida = mascara.substring(0,1);
        var texto = mascara.substring(i);

        if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
        }

    }
    let url = '{{url('')}}';
    function ajax() {
        document.getElementById('sector').value='';
        let id = document.getElementById('secretaria').value;
        document.getElementById('sector').innerHTML = '<option selected="selected" value="">Carregando...</option>';
        fullUrl = url + '/setores/pesquisaSector/' + id;
        $.ajax({
            url: fullUrl,
            type: "GET",
            dataType: "json",
            success:function(data) {
                document.getElementById('sector').innerHTML = '<option selected="selected" value="0">Selecione o Setor</option>';
                document.getElementById('sector').innerHTML += '<option value="0">Sem Setor</option>';
                $.each(data, function(key, value) {
                    document.getElementById('sector').innerHTML += '<option value="'+key+'">'+value+'</option>';
                });
            }
        });
    }
</script>
