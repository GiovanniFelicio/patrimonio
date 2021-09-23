@extends('layouts.default')
@section('content')
	<link href="{{asset('css/dataTable/buttons.dataTables.min.css')}}" rel="stylesheet">
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
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1">Registros do diário de bordo</h2>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12">
			<div class="table-responsive m-b-30">
                <table id="myTable" class="table display nowrap table-borderless table-striped table-earning">
                    <thead>
                    <tr>
                        <th class="text-left">Saída</th>
                        <th class="text-left">Funcionário</th>
                        <th class="text-left">Origem</th>
                        <th class="text-left">Destino</th>
                        <th class="text-left">Km Inicial</th>
                        <th class="text-left">Chegada</th>
                        <th class="text-left">Km Final</th>
                        <th class="text-left">Opcoes</th>
                    </tr>
                    </thead>
                </table>
			</div>
        </div>
    </div>

    <script src="{{asset('js/dataTable/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/dataTable/buttons.flash.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/dataTable/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/dataTable/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/dataTable/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/dataTable/buttons.html5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/dataTable/buttons.print.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
				"responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": '{{route('getdataRelatorio')}}',
                "columns":[
                    {"data": 'dtSai'},
                    {"data": 'name'},
                    {"data": 'origem'},
                    {"data": 'destino'},
                    {"data": 'kmInicial'},
                    {"data": 'dtCheg'},
                    {"data": 'kmFinal'},
                    {"data": 'action'}
                ]
            });
        });
    </script>
@endsection

