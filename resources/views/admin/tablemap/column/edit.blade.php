@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TABLE COLUMNS [{{$data->table}}]</h4>
<div class="btn-group">
<a href="javascript:void(0)" onclick="add_column()" class="btn btn-success">TAMBAH COLUMN MAP</a>
</div>
@stop


@section('content')
<h4><b>{{$data->name}} ({{$data->key_view}})</b></h4>
<form action="{{route('admin.tablemap.update.columns',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
	@csrf
	@method('PUT')
	<div class="box box-primary">
	<div class="box-body box-responsive">
		<table class="table table-bordered" id="table-columns">
			<thead>
				<tr>
					<th>AKSI </th>
					<th>NAMA </th>
					<th>NAMA KOLOM</th>
					<th>SATUAN</th>
					<th>TIPE AGREGASI</th>
					<th>VIEW DATA AUTH</th>
					<th>VIEW DATA VALIDASI</th>
					<th>VIEW DATA DASHBOARD</th>


				</tr>
			</thead>
			<tbody>
				@foreach($columns??[] as $keyC=>$c)
					<tr>
						<td>
							<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove(); add_remove('ID_{{$c->id}}') "><i class="fa fa-trash"></i></button>

						</td>
						<td>
							<small style="display: none;">{{$c->name}}</small>
							<input type="text" required="" class="form-control" name="columns[ID_{{$c->id}}][name]" value="{{$c->name}}"></td>
						<td>
							<small style="display: none;">{{$c->name_column}}</small>
							<select class="form-control" name="columns[ID_{{$c->id}}][name_column]" >
								@foreach($master_c as $key=>$mc)
									<option value="{{$key}}" {{$key==$c->name_column?'selected':''}}>{{$key}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<small style="display: none;">{{$c->satuan}}</small>
							<input type="text" required="" class="form-control" name="columns[ID_{{$c->id}}][satuan]" value="{{$c->satuan}}">

						</td>
						<td>
							<small style="display: none;">{{$c->aggregate_type}}</small>
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][aggregate_type]">
								@foreach(HPV::operator() as $op)
									<option class="" value="{{$op}}" {{$op==$c->aggregate_type?'selected':''}}>{{$op}}</option>
								@endforeach
								
								
							</select>
							</td>
						<td>
							<small style="display: none;">{{$c->auth?'PERLU LOGIN':'SEMUA DAPAT MELIHAT'}}</small>
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][auth]">
								<option class="" value="1" {{$c->auth?'selected':''}}>PERLU LOGIN</option>
								<option class="" value="0" {{!$c->auth?'selected':''}}>SEMUA DAPAT MELIHAT</option>

							</select>
							
						</td>
						<td>
						
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][validate]">
								<option class="" value="1" {{$c->validate?'selected':''}}>TAMPIL</option>
								<option class="" value="0" {{!$c->validate?'selected':''}}>TIDAK TAMPIL</option>

							</select>
							
						</td>
						<td>
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][dashboard]">
								<option class="" value="1" {{$c->dashboard==1?'selected':''}}>TAMPIL</option>
								<option class="" value="0" {{$c->dashboard==0?'selected':''}}>TIDAK TAMPIL</option>

							</select>
							
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		<div id="remove" style="display: none"></div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">SIMPAN</button>
	</div>
</div>
</form>

<div style="display: none">
			<table  >
				<tbody id="themp-tr">
					<tr>
					<td>
				<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></button>

			</td>
			<td>
				<small style="display: none;" ></small>
				<input type="text" required="" onchange="$(this).parent().find('small').html(this.value)" class="form-control" name="columns[NEW_XXXX][name]" value=""></td>
			<td>
				<small style="display: none;"></small>
				<select class="form-control"  name="columns[NEW_XXXX][name_column]"  onchange="$(this).parent().find('small').html(this.value)">
					@foreach($master_c as $key=>$mc)
						<option value="{{$key}}" >{{$key}}</option>
					@endforeach
				</select>
			</td>
			<td>
				<small style="display: none;"></small>
				<input type="text" required="" class="form-control" name="columns[NEW_XXXX][satuan]" value="">

			</td>
			<td>
				<small style="display: none;"></small>
				<select class="form-control" required="" name="columns[NEW_XXXX][aggregate_type]">
						@foreach(HPV::operator() as $op)
									<option class="" value="{{$op}}" >{{$op}}</option>
								@endforeach
				</select>
				</td>
			<td>
				<small style="display: none;">SEMUA DAPAT MELIHAT</small>
				<select class="form-control" required="" name="columns[NEW_XXXX][auth]">
					<option class="" value="1"  >PERLU LOGIN</option>
					<option class="" value="0" >SEMUA DAPAT MELIHAT</option>

				</select>
				
			</td>
				<td>
						
					<select class="form-control" required="" name="columns[NEW_XXXX][validate]">
						<option class="" value="1" >TAMPIL</option>
						<option class="" value="0" >TIDAK TAMPIL</option>

					</select>
					
				</td>
						<td>
						
							<select class="form-control" required="" name="columns[NEW_XXXX][dashboard]">
								<option class="" value="1" >TAMPIL</option>
								<option class="" value="0" >TIDAK TAMPIL</option>

							</select>
							
						</td>

				</tr>
				</tbody>
			</table>
	
</div>
@stop

@section('js')
	<script type="text/javascript">
		var key_column={{count($columns)}};
		function add_remove(id){
			$('#remove').append('<input type="hidden" name="remove[]" value="'+id+'">');
		}
		function add_column(){
			var tm=$('#themp-tr').html();
			console.log(tm);
			tm=tm.replace(/XXXX/g,key_column+1);
			key_column+=1;
			$('#table-columns tbody').prepend(tm);
		}
	</script>
@stop