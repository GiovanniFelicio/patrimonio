@extends('layouts.default')
@section('content')
    <script src="{{asset('js/jquery-3.4.1.js')}}" type="text/javascript"></script>
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
    <div class="page-wrapper">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <h1>Adicionar Secretaria/Autarquia</h1>
                    </div>
                    <div class="login-form">
                        <form method="POST" action="{{route('createSec')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Nome da Secretaria/Autarquia</label>
                                <input class="au-input au-input--full" required type="text" name="nameSec" placeholder="Ex: Fundetec" autofocus>
                            </div>
                            <div class="form-group">
                                <label>E-mail da Secretaria/Autarquia</label>
                                <input class="au-input au-input--full " required name="emailSec" placeholder="Ex: fundetec@fundetec.org.br" type="email">
                            </div>
                            <div class="form-group">
                                <input id="signup" onclick="" onkeydown="" type="submit" value="Adicionar" class="au-btn au-btn--block au-btn--green m-b-20">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function verify() {
        val1 = document.getElementById("password").value;
        val2 = document.getElementById("password-confirm").value;
        if (val1 != val2) {
            document.getElementById('signup').disabled = true;
            document.getElementById("password").style.borderColor = "#f00";
            document.getElementById("password-confirm").style.borderColor = "#f00";
        } else {
            document.getElementById('signup').disabled = false;
            document.getElementById("password").style.borderColor = "#009e12";
            document.getElementById("password-confirm").style.borderColor = "#009e12";

        }
    }
    function formatar(mascara, documento){
        var i = documento.value.length;
        var saida = mascara.substring(0,1);
        var texto = mascara.substring(i);

        if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
        }

    }
</script>

