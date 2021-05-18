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
	@include('partials.banner_head',['placeholder_search'=>'Cari Data '.(isset($instansi)?ucfirst(strtolower($instansi->type)).' '.ucfirst(strtolower($instansi->name)):', Instansi, Tema'),'route_search'=>route('query.data',['tahun'=>$GLOBALS['tahun_access']])])
@stop
@section('content')
<div class="box box-solid">
	<div class="box-header with-border">
		<h4 class="text-center" ><b>{{strtoupper($data->title)}} - {{$GLOBALS['tahun_access']}}</b></h4>
			<div class="box-solid box btn-ov " style="border: 1px solid #fa090a">
	  		<div class="box-body">
	  			<p>{!!nl2br($data->deskripsi)!!}</p>
	  		</div>
	  	</div>
	</div>

	<div class="box-body">
		<div id="dom_l_def"></div>
		
		<div id="dom_l_2"></div>
		<div id="dom_l_4"></div>
		<div id="dom_l_6"></div>
		<div id="dom_l_10"></div>
	</div>
</div>
@stop

@section('js')


<script type="text/javascript">
	function scrollToDomTarget(dom){
		 $([document.documentElement, document.body]).animate({
		        scrollTop: $(dom).offset().top
		    }, 2000);
	}

	function get_data(target,route,method='GET'){
    	scrollToDomTarget(target);

		$(target).html('<div class="text-center"><img src="{{ url('load.gif') }}" style="width:100px;"><h5 class="text-center" style="positon:absolute; top:0; bottom:0; margin:auto;"><b>Loading..</b></h5></div>');
		xhrReq=$.ajax({
			'url':route,
			 type: method,
			  beforeSend: function(request) {
			    request.setRequestHeader("Authorization", 'Bearer {{(Auth::check()?Auth::User()->api_token:'xx')}}');
			  },
			'contentType': "application/json; charset=utf-8",
			'statusCode':{
				401:function(){
					$(target).html('<h5 class="text-center"><b>DATA TIDAK DAPAT DIAKSES</b></h5>'+
					'<p class="text-center text-capitalize">Data Membutuhkan Authentifikasi, Silahkan <a href="{{route('login')}}">Login</a> terlebih dahulu</p>');
				},
				
			},
			success:function(res){
				$(target).html(res);
			},
			error: function (textStatus, errorThrown) {
        	}

		});

		switch(target.replace('#dom_l_','')){
			case '2':
		      $('#dom_l_4').html('');
		      $('#dom_l_6').html('');
		      $('#dom_l_10').html('');
		      break;
		    case '4':
		      $('#dom_l_6').html('');
		      $('#dom_l_10').html('');
		      break;

		    case '6':
		      $('#dom_l_10').html('');
		      break;

		}
		    

	}

	get_data('#dom_l_def','{{route('vs.data.visual',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}?kode_daerah=');

		
			

			




</script>

@stop