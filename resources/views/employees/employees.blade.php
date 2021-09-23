@extends('layouts.default')
@section('content')
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
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
                <h2 class="title-1">Funcionarios</h2>
                @if(Auth::user()->level >= 2)
                    <a href="{{route('criaFunc')}}" style="color: white" class="au-btn au-btn-icon au-btn--blue">
                        <i class="zmdi zmdi-plus"></i>add Funcionario</a>
                @endif
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            <br><br>
			<div class="table-responsive m-b-30">
                <table id="myTable" class="table display nowrap func table-earning">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        @if(Auth::user()->level >= 3)
                            <th>Secretaria/Autarquia</th>
                        @endif
                        <th>E-mail</th>
                        <th>Setor</th>
                        @if(Auth::user()->level >= 3)
                            <th></th>
                        @endif
                    </tr>
                    </thead>
                </table>
			</div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> DELETAR </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>X</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja deletar este Funcionario mesmo ?
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="idFunc" class="idFunc">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">NAO</button>
                    <button type="button" class="btn btn-primary yes">SIM</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            let idEncrypt;

            $('.func').on('click', '.del', function () {

                idEncrypt = $(this).data('id');
                $('#myModal').modal('show');
            });

            $('.yes').on('click', function () {
                window.location.replace("{{url('/employees/delete')}}" + '/'+idEncrypt);
            });

            $('#myTable').DataTable({
				"responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": '{{route('getdataFunc')}}',
                "columns":[
                    {"data": 'name'},
                    @if(Auth::user()->level >= 3)
                        {"data": 'secretaria'},
                    @endif
                    {"data": 'email'},
                    {"data": 'setor'},
                    @if(Auth::user()->level >= 3)
                        {"data": 'action'}
                    @endif
                ]
            });


        });
    </script>

@endsection
