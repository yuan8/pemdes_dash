@extends('vendor.adminlte.dashboard')

@section('content_header')
<div class="row">
	<div class="col-md-12">
	<ol class="breadcrumb text-left">
	    <li><a href="{{url('')}}"><i class="fa fa-home"></i> Home</a></li>
	    <li><a class="text-capitalize" href="{{route('query.data.categorycal',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->i_id,'slug'=>HPV::slugify($data->i_name)])}}"></i> {{ strtolower((!empty($data->i_id)) ?str_replace('_',' ',str_replace('_', ' ', $data->i_type)).' - '.$data->i_name:'')}}</a></li>

	    <li class="active text-capitalize">{{strtolower($data->name)}}</li>
	  </ol>
  </div>


</div>
	@include('partials.banner_head')
@stop


@section('content')
  <h2 class="text-center text-uppercase " style="padding-bottom: 10px;"><b>{{$data->name}}</b></h2>
  <div class="container">
  	<div class="row">
  	<div class="col-md-12">
	  	<div class="box-solid box btn-ov " style="border: 1px solid #fa090a">
	  		<div class="box-body">
	  			<p>{!!nl2br($data->description)!!}</p>
	  		</div>
	  	</div>
	  </div>
  </div>
  </div>

<div class="box-solid box">
	<div class="box-header with-border">
		<div class="row">
			<div class="col-md-4">
				<label>Provinsi</label>
				<select class="form-control" id="provinsi">
						@foreach($provinsi as $key=>$t)
						<option value="{{$t->kdprovinsi}}">{{$t->nmprovinsi}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-4">
				<label>Kota/Kab</label>
				<select class="form-control" id="kota"></select>
			</div>
			<div class="col-md-4">
				<label>Kecamatan</label>
				<select class="form-control" id="kecamatan"></select>
			</div>
		</div>
	</div>
	<div class="box-body" style="min-height: 50vh;">
		
	<div id="def"></div>
	


	</div>
</div>

@stop


@section('js')

<script type="text/javascript">
	var id_hrs=[];
	var kdparent=0;
	

	$('#provinsi').select2();
	$('#data').select2();

	

	$('#provinsi').on('change',function(){
		kdprovinsi(this.value);
		change_parent();	
	});

	$('#provinsi').trigger('change');

	$('#kota').on('change',function(){
		kdkota(this.value);
		change_parent();	
		

	});

	$('#kecamatan').on('change',function(){
		kdkecamatan(this.value);
		change_parent();	
		

	});

		function kdprovinsi(kd){
		console.log('tp');
		$('#kota').val(null).trigger('change');
		$('#kota').html('').trigger('change');
		$('#kecamatan').val(null).trigger('change');
		$('#kecamatan').html('').trigger('change');


		$('#desa').val(null).trigger('change');
		$('#desa').html('').trigger('change');
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
		$('#desa').val(null);
		$('#desa').html('');

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

	function kdkecamatan(kd){

		$('#desa').val(null).trigger('change');
		$('#desa').html('');
		$('#desa').append('<option value="" selected >-</option>');
		$('#desa').trigger('change');

		
		if(kd){

			$.get('{{route('api.meta.desa')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#desa').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');

				}
				$('#desa').select2();

			});

		

		}
			

	}


	function change_parent(){
		if($('#kecamatan').val()){
    		var c=$('#kecamatan').val();
    	}else if($('#kota').val()){
    		var c=$('#kota').val();
    	}else if($('#provinsi').val()){
    		var c=$('#provinsi').val();
    	}

    	if(kdparent!=c){
    		kdparent=c;
    		console.log(kdparent,'--');
    		get_data('#def','{{route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'table'=>$data->table_view])}}?kdparent='+kdparent);
    	}
	}
		

	function get_data(dom,route,method='GET',data={}){


    	if(id_hrs[dom]!=undefined){
    		id_hrs[dom].abort();

    		id_hrs[dom]=[];

    		id_hrs=id_hrs.splice(dom, 1);
    		

    	}

		$(dom).html('<div class="text-center"><h1 class="text-center" style="positon:absolute; top:0; bottom:0; margin:auto;"><b>Loading...</b></h1><p class="ppp_progres">... Send Request ...<p></div>');


		xhrReq=$.ajax({
			'url':route,
			 type: method,
			  beforeSend: function(request) {
			    request.setRequestHeader("Authorization", 'Bearer {{(Auth::check()?Auth::User()->api_token:'xx')}}');
			  },
			'contentType': "application/json; charset=utf-8",
			'statusCode':{
				401:function(){
					$(dom).html('<h5 class="text-center"><b>DATA TIDAK DAPAT DIAKSES</b></h5>'+
					'<p class="text-center text-capitalize">Data Membutuhkan Authentifikasi, Silahkan <a href="{{route('login')}}">Login</a> terlebih dahulu</p>');
				},
				
			},
			success:function(res){
				$(dom).html(res);
			},

			error: function (textStatus, errorThrown) {
        	}

		});
	
		id_hrs[dom]=xhrReq;




	}

		


	

	 function exportExcelTable(dom,title){
	 	// $(dom).floatThead('destroy');
       $(dom).tableExport({
        type:'xlsx',
        headings: true, 
        exclude:".no-export",
        fileName: title,  // (id, String), filename for the downloaded file
        bootstrap: true,  
        ignoreCSS:'.ignore-export',
        trimWhitespace:true                 // (Boolean), style buttons using bootstrap
   	 });

		//  $(dom).floatThead({
		// 			'position':'absolute',
		// });

     }
</script>
@stop