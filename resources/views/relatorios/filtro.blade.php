@extends('layouts.default')
@section('content')
    <link href="{{asset('vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>
    <style>
        b{
            color: black;
        }
        h2{
            color: black;
        }
        p{
            padding-left: 50px;
            padding-top: 20px;
            padding-bottom: 30px;
        }
    </style>
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
    @if(session('warning'))
        <div class="alert alert-warning">
            {{session('error')}}
        </div>
    @endif
    <script>
        $(".alert").fadeTo(3200, 800).slideUp(1000, function(){
            $(".alert").slideUp(500);
        });
    </script>
    <div class="row">
        <div class="login-wrap">
            <div class="login-content" id="contentLogin">
                <div class="login-logo">
                    <h1>Gerador de Relatório</h1>
                </div>
                <div class="login-form">
                    <div class="col-12">
                        <form method="POST" action="{{route('gerador')}}">
                            @csrf
                            <div class="form-group">
                                <label>Tipo: </label>
                                <select id="tipo" name="tipo" class="au-input au-input--full p-3">
                                    <option selected disabled="disabled">Selecione: </option>
                                    <option value="1">Bordo(s)</option>
                                    <option value="2">Solicitação(ões)</option>
                                    <option value="3">Gasto(s) do(s) Veículo(s)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Filtrar Por: </label>
                                <select id="filtrarPor" name="filtroPor" class="au-input au-input--full p-3">
                                    <option selected disabled="disabled">Selecione: </option>
                                    <option value="1">Dia</option>
                                    <option value="2">Mês</option>
                                    <option value="3">Ano</option>
                                </select>
                            </div>
                            <div id="tipofiltro">

                            </div>
                            <div hidden id="divFunc" class="form-group">
                                <label for="func">Funcionário: </label>
                                <select id="func" class="au-input au-input--full p-3" multiple name="func[]"></select>
                            </div>
                            <div hidden id="divVehi" class="form-group">
                                <label for="vehi">Veiculo: </label>
                                <select id="vehi" class="au-input au-input--full" multiple name="vehi[]"></select>
                            </div>
                            <br>
                            <div class="form-group">
                                <input id="signup" onclick="" onkeydown="" type="submit" value="Gerar Relatório" class="au-btn au-btn--block au-btn--green m-b-20">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <script>
        $(document).ready(function(){
        $('#func').select2();
        $('#vehi').select2();
        $('#tipo').change(function () {
            let value = $('#tipo').val();
            switch (value) {
                case '1':
                    document.getElementById('divFunc').hidden = false;
                    document.getElementById('divVehi').hidden = true;
                    break;
                case '2':
                    document.getElementById('divFunc').hidden = false;
                    document.getElementById('divVehi').hidden = true;
                    break;
                case '3':
                    document.getElementById('divFunc').hidden = true;
                    document.getElementById('divVehi').hidden = false;
                    break;
            }
        });
        $('#filtrarPor').change(function () {
            let value = $('#filtrarPor').val();
            switch (value) {
                case '1':
                    $('#tipofiltro').html(' ');
                    $('#tipofiltro').html('' +
                        '<label for="start">Selecione o Dia:</label>\n' +
                        '<input type="date" class="au-input au-input--full" name="day">');
                    break;
                case '2':
                    $('#tipofiltro').html(' ');
                    $('#tipofiltro').html('' +
                        '<label for="start">Selecione o Mês:</label>\n' +
                        '<input type="month" class="au-input au-input--full" name="month">');
                    break;
                case '3':
                    $('#tipofiltro').html(' ');
                    $('#tipofiltro').html('' +
                        '<label>Selecione o Ano: </label>' +
                        '<input type="number" class="au-input au-input--full" name="year" min="2000" max="2020" value="2019">');
                    break;
            }
        });
            let url = '{{url('')}}';
            fullUrl = url + '/employees/allfuncs/secretaria/' + '{{encrypt(Auth::user()->sec_id)}}';
            $.ajax({
                url: fullUrl,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#func').html('<option value="0">Todos</option>');
                    $.each(data, function(idd, value) {
                        document.getElementById('func').innerHTML += '<option value="'+value['reference']+'">'+value['name']+'</option>';
                    });
                }
            });
            fullUrl = url + '/veiculos/allvehicles/secretaria/' + '{{encrypt(Auth::user()->sec_id)}}';
            $.ajax({
                url: fullUrl,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#vehi').html('<option value="0">Todos</option>');
                    $.each(data, function(idd, veiculo) {
                        document.getElementById('vehi').innerHTML += '<option value="'+veiculo['id']+'">'+veiculo['nameVei']+'</option>';
                    });
                }
            });
        });


    </script>
@endsection
