@extends('vendor.adminlte.dashboard')

@section('content_header')
	@include('partials.banner_head')

@stop


@section('content')
  <h2 class="text-center " style="padding: 10px;"><b>KEUANGAN DESA</b></h2>

<div class="container">
	<div class="form-group">
	<label>Data</label>
	<select class="form-control" onchange="getData(this.value)">
		@foreach($title as $t)
			<option value="{{$t['id']}}">{{$t['title']}}</option>
		@endforeach
	</select>
</div>

<div id="container_level_1"></div>

</div>
@stop


@section('js')
<script type="text/javascript">
	
	function getData(index){
			$('#container_level_1').html('<h5 class="text-center">Loading</h5>');

		$.get('{{route('d.keuangan_desa.show',['tahun'=>$GLOBALS['tahun_access']])}}/'+index,function(res){
			
			$('#container_level_1').html(res);

		});
	}


	getData(0);

	function exportExcelTable(dom,title){
	 	// $(dom).floatThead('destroy');
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