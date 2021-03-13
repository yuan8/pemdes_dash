@extends('vendor.adminlte.dashboard')
@section('content_header')
<div class="row">
	<div class="col-md-12">
	<ol class="breadcrumb text-left">
    <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=" text-capitalize"><a href="{{route('query.data.categorycal',['tahun'=>$GLOBALS['tahun_access'],'id'=>$instansi->id,'slug'=>'slug-test'])}}">{{ strtolower((!empty($instansi)) ?$instansi->type.' - '.$instansi->name:'')}}</a>  </li>
    <li class="text-capitalize">
    	{{strtolower($data->name)}}
    </li>
  </ol>
  </div>


</div>
	@include('partials.banner_head')
@stop

@section('content')
<div class="banner-content text-center  background-img-box" style="position: relative;  min-height: 10px; margin-bottom: 50px;">
	

	<div  style="left:0; background: #fff; right: 0; border-radius: 5px; padding: 5px;  margin:auto; min-height: 55px; width: 90%; position: absolute; bottom:-30px; ">
		<h5>{{$data->name}}</h5>
	</div>

	</div>

	<div class="">
		<div class="box box-solid">
			<div class="box-body">
				<h5><b>Deskripsi</b></h5>
				<p>{!!nl2br($data->description)!!}</p>
				<hr>
				
				<div class="btn-group" style="">
					
				</div>
				@if(in_array(strtolower($data->delivery_type), ['VISUALISASI']))
				<div class="">
						<div id="def"></div>
						<div id="dom_l_2"></div>
						<div id="dom_l_4"></div>
						<div id="dom_l_7"></div>
						<div id="dom_l_10"></div>
				</div>
				@elseif(in_array(strtolower($data->extension), ['pdf','png','jpg','jpeg']))
				<div class="">	
					<iframe src="{{url($data->document_path)}}" style="width:100%; min-height:400px"></iframe>
				</div>
				@endif


			</div>
		</div>
	</div>

@stop

@section('js')

<script type="text/javascript">
	var id_hrs=[];

	function get_data(dom,route,method='GET',data={}){
    	scrollToDOM(dom);

    	if(id_hrs[dom]!=undefined){
    		id_hrs[dom].abort();

    		id_hrs[dom]=[];

    		id_hrs=id_hrs.splice(dom, 1);
    		

    	}

		$(dom).html('<div class="text-center"><h1 class="text-center" style="positon:absolute; top:0; bottom:0; margin:auto;"><b>Loading...</b></h1><p class="ppp_progres">... Send Request ...<p></div>');

		// var xhrReq = new XMLHttpRequest();

		xhrReq=$.ajax({
			'url':route,
			 type: method,
			  beforeSend: function(request) {
			    request.setRequestHeader("Authorization", 'Bearer {{(Auth::check()?Auth::User()->token:'xx')}}');
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

		


	setTimeout(function(){
		get_data('#def','{{route('visual.dataset',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}');	
	},1000);

	 function exportExcelTable(dom,title){
	 	$(dom).floatThead('destroy');
       $(dom).tableExport({
        type:'xlsx',
        headings: true,                    
        fileName: title,  // (id, String), filename for the downloaded file
        bootstrap: true,  
        ignoreCSS:'.ignore-export',
        trimWhitespace:true                 // (Boolean), style buttons using bootstrap
    });

	 $(dom).floatThead({
				'position':'absolute',
			});

     }
</script>
@stop