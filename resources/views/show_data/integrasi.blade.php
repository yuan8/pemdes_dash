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
		<p class="text-center">{{isset($nama_daerah)?$nama_daerah:''}}</p>
			<div class="box-solid box btn-ov " style="border: 1px solid #fa090a">
	  		<div class="box-body">
	  			<p>{!!nl2br($data->deskripsi)!!}</p>
	  		</div>
	  	</div>
	</div>

	<div class="box-body">
		@if($data->inheritance==false)
		@include('show_data.view.desa')
		@endif
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

	@if($data->id_map)
		@if($data->inheritance)
			@if($req->kdparent)
			get_data('#dom_l_{{strlen($req->kdparent)}}','{{route('vs.data.integrasi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}?kode_daerah={{$req->kdparent}}');
			@else
			get_data('#dom_l_{{$data->start_level}}','{{route('vs.data.integrasi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}?kode_daerah=');
			@endif

		@else
		// 
			console.log('ch');
			change_parent();

			// get_data('#dom_l_{{$data->start_level}}','{{route('vs.data.integrasi.desa',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}?kode_daerah=');

		@endif
	@endif



</script>
<div id="section-to-print">
	<div v-for="i in [2,4,6,10]">
		<div v-if="level['lev_'+i]" class="break-print">
			<div >
				{{-- map --}}
				@{{level['lev_'+i].map}}
			</div>
			<div >
				{{-- bar --}}
				@{{level['lev_'+i].bar}}
			</div>
			<div>
				{{-- table --}}
				@{{level['lev_'+i].table}}
			</div>
	</div>
	</div>
</div>
<style type="text/css">
	@media print {
	  body * {
	    visibility: hidden;
	  }
	  #section-to-print, #section-to-print * {
	    visibility: visible;
	  }
	  #section-to-print {
	    position: absolute;
	    left: 0;
	    top: 0;
	  }
}
</style>

<script type="text/javascript">
	var v_section_print=new Vue({
		el:'#section-to-print',
		data:{
			level:{
				lev_2:null,
				lev_2:null,
				lev_4:null,
				lev_6:null,
				lev_10:null,
			}
		},
		methods:{
			init_level:function(lev){
			setTimeout(function(){
				var data={
					title:null,
					sub_title:null,
					map:$('#dom_l_'+lev+' .map svg')[0],
					table:$('#dom_l_'+lev+' .table')[0],
					bar:$('#dom_l_'+lev+' .chart-pemdes svg')[0],
				}
				window.v_section_print.level['lev_'+lev]=data;
			},1000);

			}
		}
	});
</script>
@stop