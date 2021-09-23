@extends('layouts.default')
@section('content')
    <!-- Latest compiled and minified CSS -->
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
        $("#dropdownMenuButton").on('click', function () {
           $(".button").css('z-index', '-1');
           $(".header-desktop").css('z-index', '2');
        });
    </script>
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
        #myModal{
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2;
        }
    </style>
    <div class="row button">
        <div class="col-md-12 text-right">
            <a href="{{route('addpatrimonio')}}" style="color: white" class="au-btn au-btn-icon au-btn--blue">
                <i class="zmdi zmdi-plus"></i>add Patriomônio</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-1 text-center">Patrimônios</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <br><br>
            <div class="col-md-6">
                <form action="{{ route('importExcel') }}" class="md-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="input-group-text">Upload</button>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="import_file" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Importar tabela do Excel</label>
                        </div>
                    </div>
                </form>
                <br>
            </div>
            <div class="table-responsive m-b-30">
                <table id="myTable" class="table display nowrap table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Número</th>
                            <th>Data da Aquisição</th>
                            <th>Estado</th>
                            <th>Situação</th>
                            <th>Localização</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        //$('#myTable').DataTable().ajax.reload();
        $(document).ready(function () {
            let table = $('#myTable').DataTable({
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": '{{route('patrimoniosget', $id)}}',
                "columns":[
                    {"data": 'nome'},
                    {"data": 'codigo'},
                    {"data": 'numero'},
                    {"data": 'dtaquisicao'},
                    {"data": 'estado'},
                    {"data": 'situacao'},
                    {"data": 'localizacao'},
                    {"data": 'observacao'}
                ],
                "lengthMenu": [[10, 25, 100, -1], [10, 25, 100, "All"]],
            });

            $('#myTable tbody').on('dblclick', 'tr', function () {
                $(".header-desktop").css('z-index', '1');
                let dato = table.row( this ).data();
                $.ajax({
                    type: "GET",
                    url: "{{url('')}}/patrimonios/getpatrimonio/"+dato['idd'],
                    success: function( data )
                    {
                        $('#inputName').val(data['namePatri']);
                        $('#inputSetor').val(data['setorPatri']);
                        $('#inputCodigo').val(data['codPatri']);
                        $('#inputNum').val(data['numPatri']);
                        $('#inputDate').val(data['dataPatri']);
                        $('#inputEst').val(data['estPatri']);
                        $('#inputSit').val(data['situPatri']);
                        $('#inputLoca').val(data['locPatri']);
                        $('#inputObs').val(data['obsPatri']);
                        $('#reference').val(dato['idd']);
                    }
                });
                $('#myModal').modal('show');
            });
            $.ajax({
                url: '{{route('getsectors', encrypt(Auth::user()->sec_id))}}',
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(idd, value) {
                        document.getElementById('inputSetor').innerHTML += '<option value="'+value['reference']+'">'+value['nameSector']+'</option>';
                    });
                }
            });
            $('#updatePatri').submit(function(){
                var dados = $( this ).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{route('updatePatri')}}",
                    data: dados,
                    success: function(data){
                        if (data == 1){
                            $('#myModal').modal('hide');
                            $('#myTable').DataTable().ajax.reload();
                            alert('Sucesso !!')
                        }
                        else if(data == 2){
                            alert('Error !!')
                        }
                        else{
                            alert(' Error no Sistema !! ')
                        }
                    }
                });

                return false;
            });
        });
    </script>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> EDITAR </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="updatePatri">
                        @csrf
                        <input id="reference" hidden name="reference">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control au-input au-input--full" id="inputName" name="namePatri" placeholder="Nome do Patrimônio">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputSetor">Setor</label>
                                <select id="inputSetor" name="setorPatri" class="form-control au-input au-input--full">
                                    <option selected >Escolher...</option>
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
                                    <option value="1">Ruim</option>
                                    <option value="2">Regular</option>
                                    <option value="3">Ótimo</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputSit">Situação</label>
                                <select id="inputSit" name="situPatri" class="form-control au-input au-input--full">
                                    <option selected disabled>Escolher...</option>
                                    <option value="1">Disponível</option>
                                    <option value="2">Indisponível</option>
                                    <option value="3">Não encontrado</option>
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
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

