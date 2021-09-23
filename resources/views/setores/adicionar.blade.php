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
    <div class="login-wrap">
        <div class="login-content" id="contentLogin">
            <div class="col-lg-12">
                <div class="au-card-inner">
                    <div class="login-logo">
                        <h1 class="text-center">Adicionar</h1>
                        <h1 class="text-center">Setor/Departamento</h1>
                    </div>
                    <div class="login-form">
                        <form method="POST" action="{{route('createSector')}}">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Nome do Setor/Departamento</label>
                                        <input class="au-input au-input--full" type="text" required name="nameSector" placeholder="Ex: Recursos Humanos" autofocus>
                                    </div>
                                    @if(Auth::user()->level >= 4 and Auth::user()->email == 'giovanni.carvalho@fundetec.org.br')
                                        <div class="form-group">
                                            <label>Secretaria/Autarquia</label>
                                            <select name="secretaria" class="form-control">
                                                <option selected disabled>Selecione a Secretaria</option>
                                                @foreach($secretarias as $secretaria)
                                                    <option value="{{encrypt($secretaria->id)}}">{{$secretaria->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <input id="signup" onclick="" onkeydown="" type="submit" value="Adicionar" class="au-btn au-btn--block au-btn--green m-b-20">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

