@extends('layouts.default')
@section('content')
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="au-card chart-percent-card">
                <div class="au-card-inner">
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
                                        <h1>Seus Dados</h1>
                                    </div>
                                    <div class="login-form">
                                        <form method="POST" action="{{route('upProfileFunc')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nome do Funcionario</label>
                                                <input class="au-input au-input--full" type="text" required name="nameFunc" placeholder="Ex: Lucas Silva" value="{{$func->name}}" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input class="au-input au-input--full" disabled value="{{$func->email}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Matricula</label>
                                                <input required class="au-input au-input--full" value="{{$func->matricula}}" name="matricula" placeholder="Ex: 11.111-1" maxlength="8" type="text" onkeypress="formatar('##.###-#', this)">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="au-input au-input--full" onKeyPress="verify()" onchange="verify()" onkeydown="verify()" placeholder=" ********** " id="password" type="password" name="password" autocomplete="new-password">
                                            </div>
                                            <div class=" form-group">
                                                <label>Confirm Password</label>
                                                <input onKeyPress="verify()" onchange="verify()" onkeydown="verify()" placeholder=" ********** " id="password-confirm" type="password" class="au-input au-input--full" name="password_confirmation" autocomplete="new-password">
                                            </div>
                                            <div class="form-group">
                                                <input id="signup" onclick="" onkeydown="" type="submit" value="Atualizar" class="au-btn au-btn--block au-btn--green m-b-20">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
</script>
