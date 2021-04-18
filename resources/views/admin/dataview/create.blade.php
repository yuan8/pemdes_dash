@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH DATASET</h4>

@stop

@section('content')
	<form action="{{route('admin.dataview.store',['tahun'=>$GLOBALS['tahun_access']])}}" enctype='multipart/form-data' method="post">
		@csrf
		<div class="row">
		<div class="col-md-8">
			<div class="box box-primary">
		<div class="box-body">
			<div class="form-group">
				<label>Judul</label>
				<input type="text" required="" value="" name="name" class="form-control">
			</div>
			

			<div class="form-group">
				<label>Deksripsi</label>
				<textarea class="form-control" name="description"></textarea>
			</div>

			<div class="form-group">
				<label>Keywords</label>
				<select class="form-control" id="keywords" name="keywords[]" multiple="">
					
				</select>
				<script type="text/javascript">
					$('#keywords').select2({
						tags:true
					});
				</script>
			</div>

			<div class="form-group">
				<label>KEY TABLE MAP</label>
				<select class="form-control" name="table_view" id="table_view" required="">
					@foreach($tablemap as $k)
					
						<option value="{{$k->key_view}}" >{{$k->key_view}} - {{$k->name}}</option>
					@endforeach
				</select>
				<script type="text/javascript">
					$('#table_view').select2({
					});
				</script>
			</div>

		</div>
	</div>

		</div>
		<div class="col-md-4">
			<div class="box box-primary">
				<div class="box-header with-border">
					<button type="submit" class="btn btn-primary background-blue">TAMBAH</button>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Jenis Akses Data</label>
						<p><input type="radio" name="auth" value="1" > Dengan Login</p>
						
						<p><input type="radio" name="auth" value="0" checked=""> Tanpa  Login</p>

					</div>
					<div class="form-group">
						<label>INSTANSI</label>
						<select class="form-control" id="instansi"  name="id_instansi" required="">	
							
						</select>
					</div>
					<div class="form-group">
						<label>Ketegori</label>
						<select class="form-control" id="kategori"  name="category[]" multiple="">
						
						</select>
						<script type="text/javascript">
							$('#kategori').select2({
								'ajax':{
									url:'{{route('api.meta.kategori')}}',
									headers:{
										'Authorization':'Bearer {{Auth::User()->api_token}}',
										 "Content-Type" : "application/json",
									},
									data: function (term, page) {
							            return {
							                q: term.term
							            };
							        },
							        results: function (data, page) {
							            console.log(data);
							            return {
							                results: data.itemName,
							                more: more
							            };
							        }
								}
							});

							$('#instansi').select2({
								'ajax':{
									url:'{{route('api.meta.instansi')}}',
									headers:{
										'Authorization':'Bearer {{Auth::User()->api_token}}',
										 "Content-Type" : "application/json",
									},
									data: function (term, page) {
							            return {
							                q: term.term
							            };
							        },
							        results: function (data, page) {
							            console.log(data);
							            return {
							                results: data.itemName,
							                more: more
							            };
							        }
								}
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
@stop