@extends('vendor.adminlte.master')
@php
$CONF_THEM='page';
$CONF_MENU=MENUS::dashboard();

if(isset($bind_side_left)){
    $CONF_MENU['side_left']=$bind_side_left;
}

@endphp

@section('adminlte_css')

      <script type="text/javascript" src="{{asset('bower_components/js-xlsx/dist/xlsx.core.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('bower_components/file-saverjs/FileSaver.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bower_components/jquery-export/libs/jsPDF/jspdf.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bower_components/jquery-export/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js')}}"></script>
      <script type="text/javascript" src="{{asset('bower_components/jquery-export/tableExport.min.js')}}"></script>


    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config($CONF_THEM.'.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.theme.default.css?v'.date('i'))}}">





@stop

@section('body_class', 'skin-' . config($CONF_THEM.'.skin', 'blue') . ' sidebar-mini ' . (config($CONF_THEM.'.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'

][config($CONF_THEM.'.layout')] : '') . (config($CONF_THEM.'.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config($CONF_THEM.'.layout') == 'top-nav')
            <nav class=" navbar navbar-static-top " data-spy="affix" data-offset-top="100" style="min-width: 100vw;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        @if($CONF_MENU['side_left'])
                            <style type="text/css">
                                .sidebar-mini.sidebar-collapse .main-header .navbar{
                                    margin-left: 0px!important;
                                }

                            </style>
                                <a style="margin-right: 7px;" href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                                    <span class="sr-only">{{ trans('vendor.adminlte.adminlte.toggle_navigation') }}</span>
                                </a>
                        @else
                         <style type="text/css">
                                .sidebar-mini.sidebar-collapse .main-header .navbar{
                                    margin-left: 0px!important;
                                }
                                .sidebar-mini.sidebar-collapse .content-wrapper, .sidebar-mini.sidebar-collapse .right-side, .sidebar-mini.sidebar-collapse .main-footer{
                                    margin-left: 0px!important;
                                }

                            </style>

                        @endif
                      

                        <a href="{{ route('index',['tahun'=>$GLOBALS['tahun_access']]) }}" class="navbar-brand background-primary " style="padding: 5px 10px 5px 10px; margin-top: -1px; "  >
                             <img src="{{url('dist-web/logo2.png')}}"  style="height:150%;" >
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="control-sidebar" >
                            <i class="fa fa-bars"></i> 
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                   
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config($CONF_THEM.'.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config($CONF_THEM.'.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config($CONF_THEM.'.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="background-blue navbar navbar-static-top "  role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('vendor.adminlte.adminlte.toggle_navigation') }}</span>
                </a>
             @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu hidden-sm hidden-xs" style="padding-right: 10px;">



                      @include('vendor.adminlte.partials.auth_info')


                    </ul>
                </div>
                     @if(config($CONF_THEM.'.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if($CONF_MENU['side_left'])
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('vendor.adminlte.partials.menu-item', $CONF_MENU['side_left'], 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @if(config($CONF_THEM.'.layout') == 'top-nav')
            <div class="container-full">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header background-danger-y" style="margin-bottom:40px; ">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content" style="padding-bottom: 30px;">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config($CONF_THEM.'.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        {{-- @hasSection('footer') --}}
        <footer class="main-footer background-primary text-white">
          {{--   <div class="row" >
                <div class="col-md-4 text-center">
                    <img src="{{asset('logo.png')}}" style="width:30px; margin-bottom: 10px;"> 
                </div>
                <div class="col-md-8">
                    <H4 class="text-center">Layanan Terkait</H4>
                    <hr>
                    
                </div>

            </div> --}}
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12 text-center" style="float:left; position: relative;">
                        
                         <p>Jl. Raya Pasar Minggu No.19, RT.7/RW.1, Pejaten Barat, Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12510 </p>
                         <p><b>Email :</b> pusdatinkomtel@kemendagri.go.id</p>

                </div>
               {{--  <div class="col-md-4">
                    <ul class="list-unstyled">
                        <li><a href="http://www.setjen.kemendagri.go.id/" target="_blank">Sekretariat Jenderal</a></li>
                        <li><a href="http://www.ditjenpum.go.id/" target="_blank">Ditjen Bina Administrasi Kewilayahan</a></li>
                        <li><a href="http://www.bangda.kemendagri.go.id/" target="_blank">Ditjen Bina Pembangunan Daerah</a></li>
                        <li><a href="http://www.dukcapil.kemendagri.go.id/" target="_blank">Ditjen Kependudukan dan Pancatatan Sipil</a></li>
                        <li><a href="http://itjen.kemendagri.go.id/" target="_blank">Inspektorat Jenderal</a></li>
                        <li><a href="http://diklat.kemendagri.go.id/" target="_blank">Badan Pengembangan Sumber Daya Manusia</a></li>
                </ul>
                   
                    <style type="text/css">
                        ul li a{
                            color:#fff;
                        }
                    </style>
                </div>
                <div class="col-md-4"> --}}
                   {{--  <ul class="list-unstyled">
                                                            <li><a href="http://kesbangpol.kemendagri.go.id/" target="_blank">Ditjen Politik dan Pemerintahan Umum</a></li>
                                                            <li><a href="http://otda.kemendagri.go.id/" target="_blank">Ditjen Otonomi Daerah</a></li>
                                                            <li><a href="http://binapemdes.kemendagri.go.id/" target="_blank">Ditjen Bina Pemerintahan Desa</a></li>
                                                            <li><a href="http://keuda.kemendagri.go.id/" target="_blank">Ditjen Bina Keuangan Daerah</a></li>
                                                            <li><a href="http://bpp.kemendagri.go.id/" target="_blank">Badan Penelitian dan Pengembangan</a></li>
                                                            <li><a href="http://www.ipdn.ac.id/" target="_blank">Institut Pemerintahan Dalam Negeri</a></li>
                                                    </ul> --}}
               {{--  </div> --}}
            </div>
           <div class="row " style="background: yellow;">
               <div class="col-md-12 text-center">
                    <div class="text-center" style="color:#222">
                 <h5><b>DITJEN BINA PEMERINTAHAN DESA - Copyright &copy {{$GLOBALS['tahun_access']}}</b></h5>
            </div>
               </div>
           </div>
        </footer>
        {{-- @endif --}}

            <aside style="position: fixed; height: 100vh; padding:5px; padding-top: 60px;" class="control-sidebar control-sidebar-{{config($CONF_THEM.'.right_sidebar_theme')}}">
                @include('vendor.adminlte.partials.right-side-bar',['menu'=>$CONF_MENU['top']])
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('bower_components/jquery-treetable/jquery.treetable.js')}}"></script>
    @stack('js')
    @yield('js')

    <script type="text/javascript">
        $.AdminLTESidebarTweak = {};

        $.AdminLTESidebarTweak.options = {
            EnableRemember: true,
            NoTransitionAfterReload: false
            //Removes the transition after page reload.
        };

        $(function () {
            "use strict";

            $("body").on("expanded.pushMenu collapsed.pushMenu", function(){
                if($.AdminLTESidebarTweak.options.EnableRemember){
                    var toggleState = 'opened';
                    if($("body").hasClass('sidebar-collapse')){
                        toggleState = 'closed';
                    }
                    document.cookie = "toggleState="+toggleState;
                }
            });


            if($.AdminLTESidebarTweak.options.EnableRemember){
                var re = new RegExp('toggleState' + "=([^;]+)");
                var value = re.exec(document.cookie);
                var toggleState = (value != null) ? unescape(value[1]) : null;
                if(toggleState == 'closed'){
                    if($.AdminLTESidebarTweak.options.NoTransitionAfterReload){
                        $("body").addClass('sidebar-collapse hold-transition').delay(100).queue(function(){
                            $(this).removeClass('hold-transition');
                        });
                    }else{
                        $("body").addClass('sidebar-collapse');
                    }
                }
            }
        })


       function EXPORT_PDF(div,filename='EXPORT-'){
         $(div).tableExport({fileName: filename,
                        type: 'pdf',
                        jspdf: {
                            docDefinition:{pageOrientation:'landscape'},
                            format: 'bestfit',
                            autotable: {styles: {overflow: 'linebreak'}},
                            margins: {left:5, right:5, top:5, bottom:5},

                        }

                       });
       }

       function EXPORT_EXCEL(div,filename='EXPORT'){

             $(div).tableExport({
                        fileName: filename,
                        type:'excel',
                        mso: {fileFormat:'xlsx'}

                    });
       }

       if($('.datatable-auto').html()!==undefined){
            $('.datatable-auto').dataTable({
                lengthChange:false
            });
       }

    </script>
@stop
