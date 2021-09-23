@extends('layouts.default')
@section('content')
    <link href="{{asset('vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>
    <div class="col-lg-12">
        <div class="au-card chart-percent-card">
            <div class="au-card-inner">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <br><br>
                        <div class="table-responsive m-b-30">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{$secretarias->id}}</td>
                                </tr>
                                <tr>
                                    <th>Nome da Sec/Aut:</th>
                                    <td>{{$secretarias->name}}</td>
                                </tr>
                                <tr>
                                    <th>E-mail da Sec/Aut</th>
                                    <td>{{$secretarias->email}}</td>
                                </tr>
                                <tr>
                                    <th>Data de Criação</th>
                                    <td>{{\Carbon\Carbon::parse($secretarias->created_at)->format('d/m/Y')}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="text-center">
                                    Usuários Administradores
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive m-b-30">
                                    <table class="table" id="auth">
                                        <thead>
                                        <tr>
                                            <th class="">ID</th>
                                            <th class="text-center">Nome do Usuário</th>
                                            <th class="text-center">E-mail do Usuário</th>
                                            <th class="text-center">Opções</th>
                                        </tr>
                                        </thead>
                                        <tbody id="funcs">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <form action="" method="POST" id="adcUsrAdmSec">
                            @csrf
                            <h3 class="text-center">Adicionar Usuário</h3>
                            <div class="form-group">
                                <input name="sec" hidden value="{{$secretarias->id}}">
                                <select id="user" class="multipleSelect" multiple name="Func[]"></select>
                            </div>
                            <small class="text-center">Selecione os usuários que deseja tornar adm desta Secretaria/Autarquia.</small>
                            <br><br>
                            <div class="form-group">
                                <input id="signup" type="submit" value="Adicionar" class="au-btn au-btn--block au-btn--green m-b-20">
                            </div>
                        </form>
                    </div>
                </div>
                <br><br><br>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.multipleSelect').select2();
        });
        jQuery(document).ready(function(){
            jQuery('#adcUsrAdmSec').submit(function(){
                var dados = jQuery( this ).serialize();

                jQuery.ajax({
                    type: "POST",
                    url: "{{route('addUsrAdmSec')}}",
                    data: dados,
                    success: function( data )
                    {
                        alert( data );
                        showAdminsEmp();
                        funcsForAdmin();
                        $('.multipleSelect').empty();
                    }
                });

                return false;
            });
        });
        showAdminsEmp();

        function showAdminsEmp() {
            let url = '{{url('')}}';
            let id = '{{$secretarias->id}}';
            document.getElementById('funcs').innerHTML = '<td class="col-xs-3">Loading...</td>';
            fullUrl = url + '/secretarias/usersAdmin/' + id;
            $.ajax({
                url: fullUrl,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    document.getElementById('funcs').innerHTML='';
                    $.each(data, function(idd, usuario) {
                        document.getElementById('funcs').innerHTML +=
                            '<tr>\n' +
                            '<td class="">'+usuario['id']+'</td>\n' +
                            '<td class="">'+usuario['name']+'</td>\n' +
                            '<td class="">'+usuario['email']+'</td>\n' +
                            '<td class="">\n' +
                            '<button onclick="deleta('+usuario['id']+')" onkeypress="deleta('+usuario['id']+')" class="btn btn-danger delete">X</button>\n' +
                            '</td>\n' +
                            '</tr>';
                        //sectorId.append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            });
        }
        function deleta(id){
            let resposta = confirm('Deseja Deletar esta empresa mesmo ?');
            if(resposta){
                var dados = jQuery( this ).serialize();
                let idd = id;
                let url = '{{url('')}}';
                jQuery.ajax({
                    type: "GET",
                    url: url + '/secretarias/delUserAdmSec/' + idd,
                    data: dados,
                    success: function( data )
                    {
                        alert( data );
                        showAdminsEmp();
                        funcsForAdmin();
                        $('.multipleSelect').empty();
                    }
                });
            }
            return false;
        }
        $(document).ready(function(){
            $('.delete').click(function () {


            });
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        function funcsForAdmin() {
            let url = '{{url('')}}';
            let idEmp = '{{$secretarias->id}}';
            document.getElementById('user').value='';
            //document.getElementById('user').innerHTML = '<option selected="selected" value="">Carregando...</option>';
            fullUrl = url + '/secretarias/usersForAdm/' + idEmp;
            $.ajax({
                url: fullUrl,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(idd, value) {
                        document.getElementById('user').innerHTML += '<option value="'+value['id']+'">'+value['name']+'</option>';
                    });
                }
            });
        }
        funcsForAdmin();

    </script>

@endsection

