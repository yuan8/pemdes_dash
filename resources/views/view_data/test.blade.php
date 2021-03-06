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
  <h2 class="text-center text-uppercase " style="padding-bottom: 10px;"><b>{{$data->name}} CAPAIAN TAHUN {{$GLOBALS['tahun_access']-1}}</b></h2>


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

		var xhrReq = new XMLHttpRequest();
		
		xhrReq.addEventListener("progress", function(p){
			$(dom).find('.ppp_progres').html(`Downloaded ${p.loaded} of ${p.total} bytes`);

		});
		xhrReq.addEventListener("load", function(l){
			if(xhrReq.status==200){
				$(dom).html(xhrReq.response);

			}
		});
		xhrReq.addEventListener("error", function(e){
			console.log('error',e);
		});
		xhrReq.addEventListener("abort", function(ab){
			console.log('abort',ab);
		});

		xhrReq.open(method,route);
		xhrReq.setRequestHeader('Authorization', 'Bearer {{Auth::check()?Auth::User()->api_token:'x'}}');
		xhrReq.send();

		id_hrs[dom]=xhrReq;




	}

		


	setTimeout(function(){
		get_data('#def','{{route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'table'=>$data->table_view])}}');	
	},1000);

	 function exportExcelTable(dom,title){
       $(dom).tableExport({
        type:'xlsx',
        headings: true,                    
        fileName: title,  // (id, String), filename for the downloaded file
        bootstrap: true,  
        ignoreCSS:'.ignore-export',
        trimWhitespace:true                 // (Boolean), style buttons using bootstrap
    });
     }
</script>
@stop