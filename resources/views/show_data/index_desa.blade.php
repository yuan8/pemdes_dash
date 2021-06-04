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
  <div class="row">
      <div class="col-md-4">
          <div class="form-group">
          <label>PROVINSI</label>
          <select class="form-control" name="kdprovinsi" id='provinsi' >
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
      <div class="row">
        <div class="col-md-12">
          @php
            $rand=rand(0,10000000);
          @endphp
          <div class="box box-solid">
            <div class="box-body">
                <table class="table-bordered table" id="table-index-desa-{{$rand}}">
            <thead>
              <tr>
                <th>KODEDESA</th>
                <th>NAMA DESA</th>
                <th>NAMA KECAMATAN</th>
                <th>NAMA KAB/KOTA</th>
                <th>NAMA PROVINSI</th>
                <th>KLASIFIKASI PRODESKEL</th>
                <th>KLASIFIKASI EPDESKEL</th>

              </tr>
            </thead>
            <tbody></tbody>
          </table>
            </div>
          </div>
        </div>
      </div>
</div>
  @stop


@section('js')
    <script type="text/javascript">

      var data_table_=$('#table-index-desa-{{$rand}}').DataTable({
        sort:false,
        columns:[
         {
          data:'kddesa'
         },
         {
          data:'nmdesa'
         },
         {
          data:'nmkecamatan'
         },
         {
          data:'nmkabkota'
         },
         {
          data:'nmprovinsi'
         },
         {
          data:'klasifikasi_prodeskel'
         },
          {
          data:'klasifikasi_epdeskel'
         }
        ]

      });


      var request_API=null;
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
        request_API=$.get('{{route('index.desa.data',['tahun'=>$GLOBALS['tahun_access']])}}',{'q':$('[name="q"]').val()??'{{$request->q}}','kodedaerah':kodedaerah},function(res){

            // $('#content-instansi').html(res);

             data_table_.clear();
            data_table_.rows.add(res);
            data_table_.draw();
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