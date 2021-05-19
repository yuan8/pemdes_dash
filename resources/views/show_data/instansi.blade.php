@extends('vendor.adminlte.dashboard')

@section('content_header')
<div class="row">
  <div class="col-md-12">
    <ol class="breadcrumb text-left">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active text-capitalize">{{ strtolower((!empty($instansi)) ?str_replace('_',' ',str_replace('_', ' ', $instansi->type)).' - '.$instansi->name:(isset($title)?$title:'Cari Data'))}}</li>
    </ol>
  </div>


</div>
@include('partials.banner_head',['placeholder_search'=>'Cari Instansi','route_search'=>url()->full(),'mode_js'=>'getInstansi()'])
  @stop 

  @section('content')
  	<div class="container-fluid">
      <form action="{{url()->full()}}" method="GET" id="form-jenis-instansi">

     <div class="row">

        <div class="col-md-6">
          <input type="hidden" name="q" value="{{$request->q}}">
        <div class="form-group">
          <label>JENIS INSTANSI</label>
          <select class="form-control" name="jenis" onchange="$('#form-jenis-instansi').submit()" >
            <option value="PUSAT" {{$request->jenis!='PUSAT'?'selected':''}}>PUSAT</option>
            <option value="PEMDA" {{$request->jenis=='PEMDA'?'selected':''}}>PEMDA</option>
          

          </select>
        </div>
      </div>
    </div>

    @if(isset($request->jenis) and ($request->jenis!='PUSAT') )
    <div class="row">
      <div class="col-md-4">
          <div class="form-group">
          <label>PROVINSI</label>
          <select class="form-control" name="kdprovinsi" id='provinsi' >
            <option value="">-</option>
            @foreach($provinsi as $key=>$t)
              <option value="{{$t->kdprovinsi}}">{{$t->nmprovinsi}}</option>
            @endforeach
          </select>
          </div>
          </div>
          
         <div class="col-md-4">
           <div class="form-group">

              <label>KOTA</label>
              <select class="form-control" id="kota" name="kdkabkota" >
                
              </select>
            </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">


              <label>KECAMATAN</label>
              <select class="form-control" id="kecamatan" name="kdkecamatan">
                
              </select>
            </div>
        </div>

      </div>

    @endif 
      </form>

     
    <div id="content-instansi">
      
    </div>


    </div>

  @stop

@section('js')
    <script type="text/javascript">
      var request_API=null;
      console.log('sss');
      $('[name="jenis"]').select2();
      function getInstansi(){

      var kodedaerah=null;

      if($('#kecamatan').val()){
        kodedaerah=$('#kecamatan').val();
      }else if($('#kota').val()){
        kodedaerah=$('#kota').val();


      }else if($('#provinsi').val()){
        kodedaerah=$('#provinsi').val();

      }else{
        kodedaerah=null;
      }
        if(request_API!=null){
          request_API.abort();
        }
        request_API=$.get('{{route('api.get.instansi',['tahun'=>$GLOBALS['tahun_access']])}}',{'jenis':$('[name="jenis"]').val(),'q':$('[name="q"]').val()??'{{$request->q}}','kodedaerah':kodedaerah},function(res){
            $('#content-instansi').html(res);
        });
      }

      setTimeout(function(){
        getInstansi();
      },500);


  setTimeout(function(){
    $('#provinsi').select2();
    $('#provinsi').trigger('change');
  },500);

  

  $('#provinsi').on('change',function(){
    kdprovinsi(this.value);
    getInstansi();


  });


  $('#kota').on('change',function(){
    kdkota(this.value);
    getInstansi();

  });

$('[ name="q"]').on('keyup',function(){
    getInstansi();
    
  });
 

  $('#kecamatan').on('change',function(){
    getInstansi();
    
  });

  


  


  function kdprovinsi(kd){
    $('#kota').val(null).trigger('change');
    $('#kota').html('').trigger('change');
    $('#kecamatan').val(null).trigger('change');
    $('#kecamatan').html('').trigger('change');


    $('#kota').append('<option value="" selected >-</option>');
        $('#kota').trigger('change');


    if(kd){

      $.get('{{route('api.meta.kota')}}/'+kd,function(res){
        res=res.result;

        for(var i=0;i<res.length;i++){
          $('#kota').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');
        }
        $('#kota').trigger('change');
        $('#kota').select2();
      });

      


    }

  }

  function kdkota(kd){

    $('#kecamatan').val(null)
    $('#kecamatan').html('');
   

    $('#kecamatan').append('<option value="" selected >-</option>');
    $('#kecamatan').trigger('change');



    if(kd){
      $.get('{{route('api.meta.kecamatan')}}/'+kd,function(res){
        res=res.result;
        for(var i=0;i<res.length;i++){
          $('#kecamatan').append('<option value="'+res[i].id+'"  >'+res[i].text+'</option>');

        }
        $('#kecamatan').trigger('change');
        $('#kecamatan').select2();
      });
      
      

    }
    
    
  }


    </script>
  @stop