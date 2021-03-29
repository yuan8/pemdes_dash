@extends('vendor.adminlte.admin')
@section('content_header')
<h4>EDIT DATA VIEW</h4>
@stop

@section('content')
	<form action="{{route('admin.dataview.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" enctype='multipart/form-data' method="post">
		@csrf
		@method('PUT')
		<div class="row">
		<div class="col-md-8">
			<div class="box box-primary">
		<div class="box-body">
			<div class="form-group">
				<label>Judul</label>
				<input type="text" required="" value="{{$data->name}}" name="name" class="form-control">
			</div>
			

			<div class="form-group">
				<label>Deksripsi</label>
				<textarea class="form-control" name="description">{!!$data->description!!}</textarea>
			</div>

			<div class="form-group">
				<label>Keywords</label>
				<select class="form-control" id="keywords" name="keywords[]" multiple="">
					@foreach(json_decode($data->keywords??'[]') as $k)
						<option value="{{$k}}" selected="">{{$k}}</option>
					@endforeach
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
					
						<option value="{{$k->key_view}}" {{$data->table_view==$k->key_view?"selected":''}}>{{$k->key_view}} - {{$k->name}}</option>
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
					<button type="submit" class="btn btn-primary background-blue">UPDATE</button>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Jenis Akses Data</label>
						<p><input type="radio" name="auth" value="1" {{$data->auth==true?'checked':''}}> Dengan Login</p>
						
						<p><input type="radio" name="auth" value="0"  {{$data->auth==false?'checked':''}}> Tanpa  Login</p>

					</div>
					<div class="form-group">
						<label>INSTANSI</label>
						<select class="form-control" id="instansi"  name="id_instansi" required="">	
							@php
								$instansi=explode('|||',$data->instansi);
							@endphp
							<option value="{{$instansi[0]}}" selected="">INSTANSI {{$instansi[1]}}</option>
						</select>
					</div>
					<div class="form-group">
						<label>Ketegori</label>
						<select class="form-control" id="kategori"  name="category[]" multiple="">
							@foreach(explode('------',$data->category ) as $c )
								@if($c!='')
								@php
									
									$c=explode('|||',$c);
								@endphp
								<option value="{{$c[0]}}" selected="">{{$c[1]}} - {{$c[2]}}</option>
								@endif
							@endforeach
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