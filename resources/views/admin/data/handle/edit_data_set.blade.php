@extends('vendor.adminlte.admin')
@section('content_header')
<h4>UPDATE DATASET {{$jenis}}</h4>

{{-- @if($jenis=='VISUALISASI')
	<a href="{{url('dist-web/CONTOH_INPUT.xlsx')}}" download="" class="btn btn-success">Download Themplate Input</a>
@endif --}}
@stop

@section('content')
<div class="{{$data->status==0?"bg-maroon":($data->status==2?'bg-yellow':'bg-green')}}" style="padding: 10px; margin-bottom: 10px;">
		{{HP::status_verifikasi_dataset($data->status)}}
	</div>
	<form action="{{route('admin.dataset.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" enctype='multipart/form-data' method="post">
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

			@if(in_array($jenis,['TABLE','VISUALISASI']))
			<hr>
			<a href="{{url($data->path_file)}}" download="" class="btn btn-primary">Download File</a>
			<hr>
				<div class="form-group">
					<label>Dokumen (.xlsx,.xls)</label>
					<input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="file" class="form-control" >
				</div>
			@elseif(in_array($jenis,['INFOGRAFIS']))
				<div class="form-group">
					<label>Dokumen PDF / Gambar</label>
					<input type="file" accept="image/*, application/pdf " name="file" class="form-control" >
				</div>

			@endif
			@if(in_array($jenis, ['VISUALISASI']))
			<h4><b>VISUALISASI DATA</b></h4>
			<hr>
			@foreach($view as $k=>$level)
			<table class="table table-bordered">
			<tr>
				<td colspan="2"><b>{{$level['head']}}</b></td>
			</tr>
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
									@php
									@endphp
										<tr class="row-c">
											<td>
												<button onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-danger" type="button">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										@foreach($r as $rdd=> $d)
											@php
											$d=(array)$d;
											@endphp

											<td colspan="{{4/count($r)}}">
												<select class="form-control" required="" name="view[{{$k}}][{{$in}}][{{$rdd}}][type]">
													<option value="map" {{$k>4?'disabled':''}} {{$d['type']=="map"?'selected':''}}>MAP </option>
													<option value="bar" {{$d['type']=="bar"?'selected':''}}>BAR CHART</option>
													<option value="column" {{$d['type']=="column"?'selected':''}}>COLUMN CHART</option>
													<option value="line" {{$d['type']=="line"?'selected':''}}>LINE CHART</option>
												
													<option value="max"  {{$d['type']=="max"?'selected':''}}>(4) DATA NILAI TERTINGGI</option>
													<option value="pie"  {{$d['type']=="pie"?'selected':''}}>PIE (4) DATA NILAI TERTINGGI </option>

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
			@endforeach
			@endif
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
						<label>Publish Date</label>
						<input type="date" class="form-control" value="{{\Carbon\Carbon::parse($data->publish_date)->format('Y-m-d')}}" name="publish_date" required="">
					</div>
						@can('is_wali_daerah_kab')
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
						
						<select class="form-control" id="instansi"   name="id_instansi" required="">
							
							@foreach ($instansi??[] as $i)
								<option value="{{$i->id}}">{{$i->text}}</option>
							@endforeach	
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
	<div id="template" style="display: none">
		<div id="view_chose" class="">
			<div class=" bg-success"  >
				<select class="form-control" required="" name="view[XXXLEVEL][XXXROW][XXXRODATA][type]">
				<option value="map" xxxxx>MAP</option>
				<option value="bar">BAR CHART</option>
				<option value="column">COLUMN CHART</option>
				<option value="line">LINE CHART</option>
				<option value="max">(4) DATA NILAI TERTINGGI</option>
					<option value="pie"  >PIE (4) DATA NILAI TERTINGGI </option>
				</select>
			</div>
		</div>



	</div>
	@php
	// dd($view);
	@endphp
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

		if(level>4){
			tm=tm.replace(/xxxxx/g,'disabled');
		}
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