<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Patrimônios</title>

    <link rel = "icon" type = "image/png" href = "{{asset('/images/frotasvel/frotasvel-512x512.png')}}">
    <!-- For apple devices -->
    <link rel = "apple-touch-icon" type = "image/png" href = "{{asset('/images/frotasvel/frotasvels-512x512.png')}}"/>
    <link href="{{asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
    <!-- Bootstrap CSS-->
    <link href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">
    <!-- Vendor CSS-->
    <link href="{{asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" media="all">
    <!-- Web Application Manifest -->
    {{--<link rel='manifest' href='{{asset('/manifest.json')}}'>--}}
    <link href="{{asset('css/dataTable/jquery.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{asset('/css/dataTable/responsive.dataTables.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-3.4.1.js')}}" type="text/javascript"></script>
    <link href="{{asset('/css/editable/bootstrap-editable.css')}}" rel="stylesheet">

    <!-- Tile for Win8 -->
    <meta name="msapplication-TileImage" content="{{asset('/images/icons/icon-512x512.png')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!--<script type="text/javascript">
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/serviceworker.js').then(function(registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>-->
    <script>
        $(window).on('load', function () {
            $('#preloader .inner').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
            $('body').delay(350).css({'overflow': 'visible'});
        })
    </script>
</head>

<body id="conteudo">
<style>
    body {
        overflow: hidden;
    }

    /* ini: Preloader */

    #preloader {
        position:fixed;
        top:0;
        left:0;
        right:0;
        bottom:0;
        background-color:#bdbbbb; /* cor do background que vai ocupar o body */
        z-index:999; /* z-index para jogar para frente e sobrepor tudo */
    }
    #preloader .inner {
        position: absolute;
        top: 50%; /* centralizar a parte interna do preload (onde fica a animação)*/
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .load{
        color: #0c0c0c;
    }
    .bolas > div {
        display: inline-block;
        background-color: #fff;
        width: 25px;
        height: 25px;
        border-radius: 100%;
        margin: 3px;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        animation-name: animarBola;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

    }
    .bolas > div:nth-child(1) {
        animation-duration:0.75s ;
        animation-delay: 0;
    }
    .bolas > div:nth-child(2) {
        animation-duration: 0.75s ;
        animation-delay: 0.12s;
    }
    .bolas > div:nth-child(3) {
        animation-duration: 0.75s  ;
        animation-delay: 0.24s;
    }

    @keyframes animarBola {
        0% {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
        16% {
            -webkit-transform: scale(0.1);
            transform: scale(0.1);
            opacity: 0.7;
        }
        33% {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }
    /* end: Preloader */
</style>
<div id="preloader">
    <div class="inner">
        <!-- HTML DA ANIMAÇÃO MUITO LOUCA DO SEU PRELOADER! -->
        <div class="bolas">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li>
                        <a href="#">
                            <i class="fas fa-tachometer-alt"></i>Início</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-chart-bar"></i>Gestão</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            @if(Auth::user()->level == 4)
                                <li>
                                    <a href="{{route('SecretariasShow')}}">
                                        <i class="fas fa-book"></i>Secretarias</a>
                                </li>
                            @endif
                            @if(Auth::user()->level < 4)
                                <li>
                                    <a href="{{route('patrimoniosShow', encrypt(Auth::user()->sec_id))}}">
                                        <i class="fas fa-clipboard-list"></i>Patrimônios</a>
                                </li>
                            @endif
                                <li>
                                    <a href="{{route('showEmployees')}}">
                                        <i class="fas fa-users"></i>Funcionários</a>
                                </li>
                                <li>
                                    <a href="{{route('setoresShow')}}">
                                        <i class="fas fa-map"></i>Setores</a>
                                </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-wrench"></i>Ferramentas</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            @if(Auth::user()->level >= 3)
                                <li>
                                    <a href="#">Gerar Relatórios</a>
                                </li>
                            @endif
                            @if(Auth::user()->level == 5)
                                <li>
                                    <a href="{{route('UsersActionsShow')}}">Logs</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{route('login')}}">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo" >
            <h2>Patrimônios</h2>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li>
                        <a href="{{route('home')}}">
                            <i class="fas fa-tachometer-alt"></i>Início</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-chart-bar"></i>Gestão</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            @if(Auth::user()->level == 4)
                                <li>
                                    <a href="{{route('SecretariasShow')}}">
                                        <i class="fas fa-book"></i>Secretarias</a>
                                </li>
                            @endif
                            @if(Auth::user()->level < 4)
                                <li>
                                    <a href="{{route('patrimoniosShow', encrypt(Auth::user()->sec_id))}}">
                                        <i class="fas fa-clipboard-list"></i>Patrimônios</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{route('showEmployees')}}">
                                    <i class="fas fa-users"></i>Funcionários</a>
                            </li>
                            <li>
                                <a href="{{route('setoresShow')}}">
                                    <i class="fas fa-map"></i>Setores</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-wrench"></i>Ferramentas</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            @if(Auth::user()->level >= 3)
                                <li>
                                    <a href="#">Gerar Relatórios</a>
                                </li>
                            @endif
                            @if(Auth::user()->level == 5)
                                <li>
                                    <a href="{{route('UsersActionsShow')}}">Logs</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{route('login')}}">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->


    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="navbar header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <div></div>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{Auth::user()->name}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{route('profileFunc')}}">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="{{route('login')}}">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<!-- Bootstrap JS-->
{{--<script src="{{asset('js/jquery-3.4.1.js')}}" type="text/javascript"></script>--}}
<script src="{{asset('js/dataTable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/dataTable/dataTables.responsive.min.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/bootstrap-4.1/popper.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/editable/bootstrap-editable.min.js')}}" type="text/javascript"></script>
<!-- Vendor JS       -->
<script src="{{asset('vendor/slick/slick.min.js')}}"></script>
<script src="{{asset('vendor/wow/wow.min.js')}}"></script>
<script src="{{asset('vendor/animsition/animsition.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{asset('vendor/counter-up/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('vendor/counter-up/jquery.counterup.min.js')}}"></script>
<script src="{{asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
<script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('vendor/chartjs/Chart.bundle.min.js')}}"></script>
<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<!-- Main JS-->
<script src="{{asset('js/main.js')}}"></script>

</body>

</html>
<!-- end document-->
