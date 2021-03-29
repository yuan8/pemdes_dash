@extends('vendor.adminlte.admin')
@section('content_header')
<h4>VIEW DATA TABLE [{{$data->table}}]</h4>
<div class="btn-group">

@stop


@section('content')

	<form action="{{route('admin.tablemap.update.view',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="POST">
		@csrf
		@method('PUT')
		<div class="btn-group" style="margin-bottom: 10px;">
			<button class="btn btn-primary" type="submit">SIMPAN</button>
		</div>
		@foreach($view as $k=>$level)
	<div class="box box-primary">
		<div class="box-header with-border">
			<h4><b>{{$level['head']}}</b></h4>

		</div>
		<div class="box-body">
			<table class="table table-bordered">
				<tr>
					<td style="width: 250px">
						<div class="input-group">
						<select class="form-control" placeholder="COLUMN">
							<option value="1">1 KOLOM</option>
							<option value="2">2 KOLOM</option>
							<option value="4">4 KOLOM</option>
						</select>
						<span class="input-group-btn">
						<button type="button" class="btn btn-primary" onclick="add_row('#content_view_{{$k}}',$(this).parent().parent().find('select').val(),{{$k}})">Tambah Row</button>
							
						</span>

					</div>
					</td>
					<td>
						<table class="table table-bordered column-row"  >
							<thead>
								<tr>
									<th>HAPUS</th>
									<th>COLUM 1</th>
									<th>COLUM 2</th>
									<th>COLUM 3</th>
									<th>COLUM 4</th>
								</tr>

							</thead>
							<tbody id="content_view_{{$k}}">
								@foreach($level['map'] as $in=>  $r)
									@if(count($r))
										<tr class="row-c">
											<td>
												<button onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-danger" type="button">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										@foreach($r as $rdd=> $d)
											<td colspan="{{4/count($r)}}">
												<select class="form-control" required="" name="view[{{$k}}][{{$in}}][{{$rdd}}][type]">
													<option value="map" {{$d->type=="map"?'selected':''}}>MAP</option>
													<option value="bar" {{$d->type=="bar"?'selected':''}}>BAR CHART</option>
													<option value="column" {{$d->type=="column"?'selected':''}}>COLUMN CHART</option>
													<option value="line" {{$d->type=="line"?'selected':''}}>LINE CHART</option>
													<option value="table" {{$d->type=="table"?'selected':''}}>TABLE</option>
													<option value="max"  {{$d->type=="max"?'selected':''}}>(4) DATA NILAI TERTINGGI</option>
													<option value="pie"  {{$d->type=="pie"?'selected':''}}>PIE (4) DATA NILAI TERTINGGI </option>

											</td>
										@endforeach
									</tr>
									@endif
								@endforeach
							</tbody>
						</table>
						
					</td>
				</tr>
			</table>
			<div class="row">
				<div class="col-md-4">

					
				</div>
			</div>
		</div>
	</div>
	@endforeach

	</form>
	<div id="template" style="display: none">
		<div id="view_chose" class="">
			<div class=" bg-success"  >
				<select class="form-control" required="" name="view[XXXLEVEL][XXXROW][XXXRODATA][type]">
				<option value="map">MAP</option>
				<option value="bar">BAR CHART</option>
				<option value="column">COLUMN CHART</option>
				<option value="line">LINE CHART</option>
				<option value="table">TABLE</option>
				<option value="max">(4) DATA NILAI TERTINGGI</option>
					<option value="pie"  >PIE (4) DATA NILAI TERTINGGI </option>


			</select>
			</div>
		</div>



	</div>

@stop

@section('js')
<script type="text/javascript">
	function add_row(dom,c,level){
		var c_l=$(dom+' .row-c').length;

		if(c_l<3){
			var col=12;
			 var colspan=4;

		switch(parseInt(c)){
			case 1:
			 col=12;
			 colspan=4;
			break;
			case 2:
			 col=6;
			 colspan=2;
			break;
			case 4:
			 colspan=1;
			 col=3;
			break;
		}

		var tm=$('#view_chose').html();
		tm=tm.replace(/XXXCOL/g,col);

		tm=tm.replace(/XXXLEVEL/g,level);
		tm=tm.replace(/XXXROW/g,new Date().getTime());


		var tm_f='<tr class="row-c"><td><button onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash"></i></button></td>';
		for (var i = 0;i<c;i++){
				var tmf=tm.replace(/XXXRODATA/g,i);
				tm_f+='<td colspan="'+colspan+'">'+tmf+'</td>';
		}
		tm_f+='<tr>'
		

		$(dom).append(tm_f);

	}else{
		alert('JUMLAH ROW MELEBIHI 3');
	}



	}	
</script>

@stop