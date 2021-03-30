@extends('vendor.adminlte.admin')
@section('content_header')
<h4>User {{$data->name}} / {{$data->email}}</h4>
<div class="btn-group">
</div>

@stop
@section('content')
<div class="row">
	<div class="col-md-8">
		<form action="{{route('admin.users.up_profile',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
			@csrf
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
							<input type="text" name="name" required="" class="form-control" value="{{$data->name}}">
						</div>
					@can('is_super')

						<div class="form-group">
							<label>Role</label>
							<select class="form-control" required="" name="role">
							@foreach(HPV::role_list() as $key=>$r)
								<option value="{{$r['val']}}" {{$r['val']==$data->role?'selected':''}}>{{$r['text']}}</option>
							@endforeach
							</select>
						</div>
					@endcan

					</div>
					@can('is_super')
					<div class="col-md-6">
						<div class="form-group">
							<label>Status User</label>
							<select class="form-control" required="" name="is_active">
								<option value="true" {{$data->is_active?'selected':''}}> ACTIVE </option>
								<option value="false" {{$data->is_active?'':'selected'}}> UNACTIVE </option>
							</select>
						</div>
						
					</div>

					@endcan
				</div>
			</div>
			<div class="box-footer">
				<div class="form-group">
							<button class="btn btn-primary" type="submit">UPDATE</button>					
						</div>
			</div>
			
		</div>
		</form>


		<form method="post" action="{{route('admin.users.up_pass',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}">
			@csrf
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
							<input min="8" type="password" name="password" required="" class="form-control" value="">
						</div>
					</div>
					@if(!Auth::User()->can('is_super'))
					<div class="col-md-8">
						<div class="form-group">
							<label>Password Konfirmasi</label>
							<input min="8" type="password" name="password_confirmation" required="" class="form-control" value="">
						</div>
					</div>
					@endif
					<div class="col-md-8">
						
					</div>
				</div>
			</div>
			<div class="box-footer">
		
							<button type="submit" class="btn-primary btn">UPDATE</button>
			</div>
		</div>
		</form>


		
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

					@can('is_super')

<div class="row">
	@if($data->role==2)
		<form method="post" action="{{route('admin.users.up_access',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}">

			@csrf
			<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-header">
					<h5><b>SKOP AKSES DAERAH</b></h5>
			<input type="hidden" name="action_to" class="action_to" value="">

				</div>
			<div class="box-body">
				<select class="form-control" id="regional" name="role_group[]" multiple="">
										@foreach($regional_list as $l)
											<option value="{{$l->id}}" {{in_array($l->id,$regional_list_acc->toArray())?'selected':''}}>{{$l->name}}</option>
										@endforeach
									</select>

						
					
			</div>
			<div class="box-footer">
				<button class="btn btn-primary" type="submit" >UPDATE</button>
			</div>
		</div>
		</div>
		<script type="text/javascript">
			$('#regional').select2();
		</script>
		</form>

	@elseif($data->role==3)

	@endif
	@endcan
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