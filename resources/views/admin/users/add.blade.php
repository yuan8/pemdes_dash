@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH USER</h4>
<div class="btn-group">
</div>

@stop
@section('content')
<form action="{{route('admin.users.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
	@csrf
	<div class="box box-solid ">
	<div class="box-header with-border">
		<p><b>Profil User</b></p>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="name" class="form-control" value="" required="">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" value="" required="">
				</div>
				<div class="form-group">
					<label>Role</label>
					<select class="form-control" name="role" required="">
						<option value="1"> SUPPERADMIN </option>
						<option value="1"> ADMIN REGIONAL </option>
						<option value="1"> ADMIN DAERAH </option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status User</label>
					<select class="form-control" name="is_active" required="">
						<option value="1"> ACTIVE </option>
						<option value="0"> UNACTIVE </option>
					</select>
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" value="" required="">
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn-primary btn">TAMBAH</button>
	</div>
	
</div>
</form>
@stop