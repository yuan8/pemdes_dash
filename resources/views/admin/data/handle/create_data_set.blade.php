@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH DATASET {{$jenis}}</h4>

@if($jenis=='VISUALISASI')
	<a href="{{url('dist-web/CONTOH_INPUT.xlsx')}}" download="" class="btn btn-success">Download Template Input</a>
@endif
@if($jenis=='TABLE')
	<a href="{{url('dist-web/CONTOH_TABLE.xlsx')}}" download="" class="btn btn-success">Download Template Input</a>
@endif
@stop

@section('content')
	<form action="{{route('admin.data.store',['tahun'=>$GLOBALS['tahun_access'],'jenis'=>$jenis])}}" enctype='multipart/form-data' method="post">
		@csrf

		<div class="row">
		<div class="col-md-8">
			<div class="box box-primary">
		<div class="box-body">
			<input type="hidden" name="delivery_type" value="DATASET">
			<div class="form-group">
				<label>Judul</label>
				<input type="text" required="" value="{{old('name')}}" name="name" class="form-control">
			</div>

			<div class="form-group">
				<label>Deksripsi</label>
				<textarea class="form-control"  name="description">{{old('description')}}</textarea>
			</div>

			<div class="form-group">
				<label>Keywords</label>
				<select class="form-control" id="keywords" name="keywords[]" multiple=""></select>
				<script type="text/javascript">
					
				</script>
			</div>

			@if(in_array($jenis,['TABLE','VISUALISASI']))
				<div class="form-group">
					<label>Dokumen (.xlsx,.xls)</label>
					<input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="file" class="form-control" required="">
				</div>
			@elseif(in_array($jenis,['INFOGRAFIS']))
				<div class="form-group">
					<label>Dokumen PDF / Gambar</label>
					<input type="file" accept="image/*, application/pdf " name="file" class="form-control" required="">
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
										<tr class="row-c">
											<td>
												<button onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-danger" type="button">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										@foreach($r as $rdd=> $d)
											<td colspan="{{4/count($r)}}">
												<select class="form-control" required="" name="view[{{$k}}][{{$in}}][{{$rdd}}][type]">
													<option value="map" {{$k>4?'disabled':''}} {{$d->type=="map"?'selected':''}}>MAP</option>
													<option value="bar" {{$d->type=="bar"?'selected':''}}>BAR CHART</option>
													<option value="column" {{$d->type=="column"?'selected':''}}>COLUMN CHART</option>
													<option value="line" {{$d->type=="line"?'selected':''}}>LINE CHART</option>
												
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
			@endforeach
			@endif
		</div>
	</div>
	


		</div>
		<div class="col-md-4">
			<div class="box box-primary">
				<div class="box-header with-border">
					<button type="submit" class="btn btn-primary background-blue">Tambah</button>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Publish Date</label>
						<input type="date" class="form-control" name="publish_date" required="">
					</div>
					<hr>
					<div class="form-group">
						<label>Dapat Dilakukan Percarian</label>
						<p><input type="radio" id="sc_true" checked="" class="c_sc" name="dashboard" value="1" > Tampil </p>
						<p><input type="radio" name="dashboard" class="c_sc" value="0" > Tidak </p>

					</div>
					<hr>
					<div class="form-group" id="auth_f">
						<label>Perlu Login</label>
						<p><input type="radio" name="auth" value="1" > Ya </p>
						<p><input type="radio" name="auth" checked="" value="0" > Tidak </p>

					</div>
					<hr>

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
						<p><b>{{HP::daerah_level(Auth::User()->kode_daerah)}}</b></p>
						<input type="hidden" name="id_instansi" required="" value="{{(Auth::User()->kode_daerah)}}">
					</div>
					@endif
					<hr>
					<div class="form-group">
						<label>Ketegori</label>
						<select class="form-control" id="kategori" required="" name="category[]" multiple="">
							
						</select>
						<script type="text/javascript">
							$(function(){
								setTimeout(function(){
									$('#kategori').select2({
								'ajax':{
									url:'{{route('api.meta.kategori',['tema'=>'TEMA_DATA_PENDUKUNG'])}}',
									headers:{
										'authorization':'Bearer {{Auth::User()->api_token}}',
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

							@if(Auth::User()->role<=3)

								$('#instansi').select2();
							@endif

							$('#keywords').select2({
								tags:true
							});
								},500);
							})


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
		if(level>4){
			tm=tm.replace(/xxxxx/g,'disabled');
		}


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