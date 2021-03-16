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
	<div class="box-body" style="min-height: 50vh;">
	<div id="def"></div>
	<div id="dom_l_2"></div>
	<div id="dom_l_4"></div>
	<div id="dom_l_7"></div>
	<div id="dom_l_10"></div>


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

		


	setTimeout(function(){
		get_data('#def','{{route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'table'=>$data->table_view])}}');	
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
				'position':'fixed',
				'top':50
			});

     }
</script>
@stop