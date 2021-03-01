@extends('vendor.adminlte.dashboard')

@section('content_header')
  <h2 class="text-center text-white" style="padding-bottom: 10px;"><b>{{$data->name}}</b></h2>
@stop


@section('content')

<div class="box-solid box">
	<div class="box-body">
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
	function get_data(dom,route){
    	scrollToDOM(dom);

		console.log(dom);
		$(dom).html('<h1 class="text-center"><b>Loading...</b></h1>');
		$.get(route,function(res){
			$(dom).html(res);
		});
	}


	setTimeout(function(){
		get_data('#def','{{route('visual.data.table',['tahun'=>2020,'table'=>$data->table_view])}}');	
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