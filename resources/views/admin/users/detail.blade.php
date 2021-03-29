@extends('vendor.adminlte.admin')
@section('content_header')
<h4>User {{$data->name}} / {{$data->email}}</h4>
<div class="btn-group">
</div>

@stop
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-solid ">
			<div class="box-header with-border">
						<p><b>Profil User</b></p>
			<input type="hidden" name="action_to" class="action_to" value="">

					</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="name" class="form-control" value="{{$data->name}}">
						</div>
						<div class="form-group">
							<label>Role</label>
							<select class="form-control" name="role">
							@foreach(HPV::role_list() as $key=>$r)
								<option value="{{$key}}" {{$key==$data->role?'selected':''}}>{{$r}}</option>
							@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Status User</label>
							<select class="form-control" name="role">
								<option value="1" {{$data->is_active?'selected':''}}> ACTIVE </option>
								<option value="0" {{$data->is_active?'':'selected'}}> UNACTIVE </option>
							</select>
						</div>
						<div class="form-group">
							<p style="height: 12px"></p>
							<button class="btn btn-primary">UPDATE</button>					
						</div>
					</div>
				</div>
			</div>
			
		</div>


		<div class="box  box-warning">
			<div class="box-header  with-border">
				<p><b>Ubah Password</b></p>
				</div>
			<input type="hidden" name="action_to" class="action_to" value="">
			<div class="box-body">
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" value="">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<p style="height: 12px;"></p>
							<button type="submit" class="btn-primary btn">UPDATE</button>
						</div>
					</div>
				</div>
			</div>
		</div>


		
	</div>
	<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-body">
					<div class="form-group">
						<label>JENIS AKSI UPDATE</label>
						<select class="form-control" name="action_to" id="action_to">
							<option value="UPDATE_AND_BACKTOFORM">Kembali Keform</option>
							<option value="UPDATE_AND_BACKTOLIST">Kembai ke User List</option>
						</select>
					</div>
				</div>
			</div>


<div class="row">
	@if($data->role==2)
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-header">
					<h5><b>SKOP AKSES DAERAH</b></h5>
			<input type="hidden" name="action_to" class="action_to" value="">

				</div>
			<div class="box-body">
				<table class="table table table-bordered" >
					<thead>
						<tr>
							<th>AKSI</th>
							<th>SKOP DAERAH</th>
						</tr>
					
					</thead>
					<tbody>
						@foreach($regional_list_acc as $a)
						<tr>
							<td>
								<div class="btn-group">
									<button class="btn btn-danger btn-xs">
										<i class="fa fa-trash"></i>
									</button>

								</div>
							</td>
							<td>
								
									<select class="form-control" name="role_group[]">
										@foreach($regional_list as $l)
											<option value="{{$l->id}}" {{$l->id==$a->id_regional?'selected':''}}>{{$l->name}}</option>
										@endforeach
									</select>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		</div>

	@elseif($data->role==3)

	@endif
</div>
		</div>
</div>
<div class="row">

	<div class="col-md-">

	</div>
</div>

@stop

@section('js')
<script type="text/javascript">
	function action_to(){
		var val=$('#action_to').val();
		$('.action_to').val(val);
	}

	$('#action_to').on('change',function(){
		action_to();
	});

	$('#action_to').trigger('change');


</script>
@stop