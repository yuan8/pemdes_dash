<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('proepdeskel.meta.title')}}</title>

    <meta name="description" content="{{config('proepdeskel.meta.description')}}">
    <meta name="keywords" content="{{config('proepdeskel.meta.keywords')}}">
    <meta name="author" content="{{config('proepdeskel.meta.author')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="url" content="{{url()->full()}}">
    <meta name="category" content="{{config('proepdeskel.meta.category')}}">
    <meta name="copyright" content="PROEPDESKEL - {{isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:date('Y')}}">
     <script type="text/javascript">
       METAUSER={
        name:'{{Auth::check()?Auth::User()->name:''}}',
        id:'{{Auth::check()?Auth::User()->id:''}}',
        api_token:'{{Auth::check()?Auth::User()->api_token:'xx'}}',
        email:'{{Auth::check()?Auth::User()->email:'xx'}}',

       }
       METANOTIF={
        icon:'{{url('logo.png')}}',
        image:'{{url('logo.png')}}',

       }

       function spawnNotification(body, title) {
        var options = {
            body: body,
            icon: '{{url('logo.png')}}',
            silent:false
        }
        var notification = new Notification(title, options);
      }
     </script>
    <!-- T
      ell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{asset('/css/app.css?v='.date('dmYhi'))}}">


    <script src="{{asset('bower_components/datatables/media/js/jquery.dataTables.js')}}" charset="utf-8"></script>
    <script src="{{asset('bower_components/datatables/media/js/dataTables.bootstrap.js')}}" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/animate-css/animate.min.css')}}">



    <!-- <link rel="stylesheet" href="{{asset('bower_components/datatables/media/css/jquery.dataTables.css')}}"> -->
    <link rel="stylesheet" href="{{asset('bower_components/datatables/media/css/dataTables.bootstrap.css')}}">
    <script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
    

 <link rel="stylesheet" type="text/css" href="{{asset('/bower_components/components-font-awesome/css/all.min.css')}}">
     <script type="text/javascript" src="{{asset('bower_components/jquery-export/libs/js-xlsx/xlsx.core.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('bower_components/jquery-export/libs/FileSaver/FileSaver.min.js')}}"></script>

     <script type="text/javascript" src="{{asset('bower_components/jquery-export/tableExport.min.js')}}"></script>
     <script type="text/javascript" src="{{asset('bower_components/jquery.floatThead/dist/jquery.floatThead.min.js')}}"></script>
     <script type="text/javascript">let _TOKEN_A='{{Auth::check()?Auth::User()->api_token:md5(rand(0,100))}}'</script>
    


    @yield('adminlte_css')

    <!--[if lt IE 9]>jquery.floatThead.min.js
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="icon" href="{{asset('asset/icon.gif')}}" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('body_class')" >

@yield('body')

<div id="modal_sm" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

        </div>

      </div>
</div>

<div id="modal_md" class="modal fade" role="dialog">
      <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">

        </div>

      </div>
</div>

<div id="modal_lg" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

        </div>

      </div>
</div>

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('bower_components/highcharts/highstock.js') }}"></script>
<script src="{{asset('bower_components/highcharts/modules/map.js')}}" charset="utf-8"></script>
<script src="{{asset('bower_components/highcharts/modules/full-screen.js')}}" charset="utf-8"></script>
<script src="{{asset('bower_components/highcharts/modules/exporting.js')}}" charset="utf-8"></script>
<script src="{{asset('bower_components/highcharts/modules/offline-exporting.js')}}" charset="utf-8"></script>
<script src="{{asset('bower_components/vue/dist/vue.min.js')}}"></script>
<script src="{{asset('bower_components/vue/dist/select2.js')}}"></script>


<!-- The core Firebase JS SDK is always required and must be listed first -->

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script type="text/javascript">
  let sw_root='{{url('sw.js')}}';
</script>

<script type="text/javascript" src="{{asset('js/app.js')}}"></script>



@yield('adminlte_js')
<style type="text/css">
    table tr td{
        font-size:10px;
    }
    table tr th{
        font-size:12px;
    }
</style>
</body>
@include('sweetalert::alert')


<script type="text/javascript">
    if(localStorage.local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_pemdes_refresh){

    }else{
      localStorage.setItem("{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_pemdes_refresh", "OO");
    }

     function buildNum(){
     $('.val_check_type').each(function(key,dom){
        var t=$(dom).text().trim()!=''?$(dom).text().trim():'';

        if(((t!=null)&&(t!=''))){

            if(isNaN(t)==false){
                t=parseFloat(t);
                $(dom).html(new Intl.NumberFormat('de-DE', { }).format(t));
                $(dom).removeClass('val_check_type');

            }
        }


     });


   }

    buildNum();

    $('html').on('load',buildNum());
    var localy_trigger_refresh=localStorage.getItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_pemdes_refresh');

    $(window).on("storage", function(e) {
    var event = e.originalEvent; // Get access to the storage-specifics
    if (event.key == "local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_pemdes_refresh") { // Or whatever
        // Do something with event.newValue
        if(localy_trigger_refresh!=localStorage.getItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_pemdes_refresh')){
            window.location.reload();
        };
    }
    });
    @if(null!==session('change_tahun'))
        @if(session('change_tahun')!=0)
            localStorage.setItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_pemdes_refresh',{{session('change_tahun')}});
        @endif
        @php
            session(['change_tahun'=>0]);
        @endphp

    @endif

    function showForm(url,size='lg'){
        $.get(url,function(res){
          $('#modal_'+size+' .modal-content').html(res);
          setTimeout(function(){
              $('#modal_'+size).modal();

          },800);
        });
      }

      function scrollToDOM(dom){
       setTimeout(function(){
         $('html,body').animate({
            scrollTop: $(dom).offset().top!=undefined?$(dom).offset().top:0
        }, 2000);
       },100);
      }

      function LinShowForm(dom,size='lg'){
        $('#modal_'+size+' .modal-content').html(dom);
          setTimeout(function(){
              $('#modal_'+size).modal();
          },800);
      }


</script>

 <script src="{{url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script src="{{url('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script>
       if($('.ck-editor-init').html()!=undefined){
           $('.ck-editor-init').ckeditor();
       }
    </script>

    <script type="text/javascript">
        $(function(){
         setTimeout(function(){
          Echo.private('App.User.'+window.METAUSER.id)
            .notification((notification) => {
                
                window.notifO.fire(notification);
            });
          },500);

        });

    </script>
</html>
