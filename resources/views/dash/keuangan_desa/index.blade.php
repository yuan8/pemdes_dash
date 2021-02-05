@extends('vendor.adminlte.dashboard')

@section('content_header')
  <h2 class="text-center text-white" style="padding: 10px;"><b>KEUANGAN DESA</b></h2>
@stop


@section('content')
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

		$.get('{{url('v/keuangan-desa/data')}}/'+index,function(res){
			
			$('#container_level_1').html(res);

		});
	}


	getData(0);
</script>

@stop