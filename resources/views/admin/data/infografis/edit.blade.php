@extends('vendor.adminlte.admin')
@section('content_header')
<h4>EDIT DATASET {{$jenis}} - {{$data->nama_daerah}} </h4>
@php
@endphp

@stop


@section('content')
	<div class="{{$data->status==0?"bg-maroon":($data->status==2?'bg-yellow':'bg-green')}}" style="padding: 10px; margin-bottom: 10px;">
		{{HP::status_verifikasi_dataset($data->status)}}
	</div>

	<form action="{{route('admin.infografis.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" enctype='multipart/form-data' method="post">
		@csrf
		@method('PUT')

		<div class="row">
			<div class="col-md-8">
				<div class="box box-primary">
					<div class="box-body">
						<input type="hidden" name="type" value="{{$jenis}}" >

						<div class="form-group">
							<label>Judul</label>
							<input type="text" required="" name="name" class="form-control" value="{{$data->title}}">
						</div>

						<div class="form-group">
							<label>Deksripsi</label>
							<textarea class="form-control "  name="description">{!!$data->deskripsi!!}</textarea>
						</div>

						<div class="form-group">
							<label>Keywords</label>
							<select class="form-control" id="keywords" name="keywords[]" multiple="">
								@foreach(json_decode($data->keywords??'[]',true)??[] as $k)
								<option value="{{$k}}" selected="">{{$k}}</option>
								@endforeach
							</select>
							<script type="text/javascript">
								
							</script>
						</div>
						<a style="margin-bottom: 10px;" href="{{url($data->path_file)}}"  download="" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download Data</a>
						<div class="form-group">
							<label>Update Dokumen (Dokumen PDF / Gambar)</label>
							<input type="file" accept="image/*, application/pdf " name="file" class="form-control" >
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
			<div class="box box-primary">
				<div class="box-header with-border">
					<div class="btn-group">
						<button type="submit" class="btn btn-primary background-blue">UPDATE</button>
						<a href="{{route('data.infograp.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>Str::slug($data->title),'preview'=>($data->status==1?false:true)])}}" class="btn btn-info ">{{$data->status==1?'VIEW':'PREVIEW'}}</a>
					</div>
				</div>
				<div class="box-body">
					
				<div class="form-group">
					<label>Publish Date</label>
						<input type="date" class="form-control" value="{{\Carbon\Carbon::parse($data->publish_date)->format('Y-m-d')}}" name="publish_date" required="">
				</div>
				

				@can('ac_super')
				<div class="form-group">
					<label>Status</label>
					<select class="form-control" name="status" required="">
						<option value="0" >BELUM DILAKUKAN PENILAIAN</option>

						<option value="1" {{$data->status==1?'selected':''}} >PUBLISH</option>
						<option value="2" {{$data->status==2?'selected':''}} >KORDINASI KEMBALI</option>
					</select>
				</div>

				@endcan

					<hr>
					<div class="form-group">
						<label>Dapat Dilakukan Percarian</label>
						<p><input type="radio" id="sc_true" checked="" class="c_sc" name="dashboard" value="1" > Tampil </p>
						<p><input type="radio" name="dashboard" class="c_sc" value="0" > Tidak </p>

					</div>
					<hr>
					<div class="form-group" id="auth_f">
						<label>Perlu Login</label>
						<p><input type="radio" {{$data->auth?'checked':''}}  name="auth" value="1" > Ya </p>
						<p><input type="radio" {{$data->auth?'':'checked'}}  name="auth" checked="" value="0" > Tidak </p>

					</div>

					<script type="text/javascript">
						$('.c_sc').on('change',function(){
							if($(this).prop('checked')){
								if(this.value==1){
									$('#auth_f').css('display','block');
								}else{
									$('#auth_f').css('display','none');
								}
							}
						});
					</script>
				@if(Auth::User()->role<=3)
					<div class="form-group">
						<label>Instansi</label>
						
						<select class="form-control" id="instansi"   required="">
							
							@can('ac_super')
								@foreach ($instansi??[] as $i)
									<option value="{{$i->id}}">{{$i->text}}</option>
								@endforeach	
							@endcan
							@can('ac_admin')
								@php
									$inp=Auth::User()->instansi_pusat()
								@endphp
								<option value="{{$inp?$inp->id:''}}">{{$inp?$inp->name:''}}</option>
							@endcan
						</select>
					</div>

					@else
					<div class="form-group">
						<label>Instansi</label>
						<p><b>{{HP::daerah_level($data->kode_daerah)}}</b></p>
						<input type="hidden" name="id_instansi" required="" value="{{(Auth::User()->kode_daerah)}}">
					</div>
					@endif
					<hr>
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
							setTimeout(function(){
									$('#keywords').select2({
						tags:true
					});
							$('#instansi').select2();
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

							},1000);
							
						</script>
					</div>
				</div>
			</div>
		</div>
		</div>



	</form>

@stop