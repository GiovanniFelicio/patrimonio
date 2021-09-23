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
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{route('adicionarSec')}}" style="color: white" class="au-btn au-btn-icon au-btn--blue">
                <i class="zmdi zmdi-plus"></i>add Sec/Aut</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-1 text-center">Secretarias/Autarquias</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <br><br>
            <div class="table-responsive m-b-30">
                <table id="myTable" class="table display nowrap table-borderless table-striped table-earning">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data</th>
                        <th>Opções</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": '{{route('getdataSecs')}}',
                "columns":[
                    {"data": 'id'},
                    {"data": 'name'},
                    {"data": 'email'},
                    {"data": 'data'},
                    {"data": 'action'}
                ]
            });
        });
    </script>

@endsection

