<div class="modal-content">
	<form action="{{route('sso.attemp',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
		@csrf
		<div class="modal-body">
		<div class="form-group">
			<label>AKSES LIST</label>
		<select class="form-control" name="app_broker" required="">
			@foreach($list_access as $key=>$l)
			<option value="{{$key}}">{{$l['name']}}</option>
			@endforeach
		</select>
		</div>
		<div class="form-group">
			<label>Email/User</label>
		<input type="text" class="form-control" name="mail" required="">
		</div>
		<div class="form-group">
			<label>Password</label>
		<input type="password" class="form-control" name="password" required="">
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-success" type="submit">Login</button>
	</div>
	</form>

</div>