@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH PUBLIKASI</h4>

@stop

@section('content')
	<form action="{{route('admin.publikasi.store',['tahun'=>$GLOBALS['tahun_access']])}}" enctype='multipart/form-data' method="post">
		@csrf

		<div class="row">
		<div class="col-md-8">
			<div class="box box-primary">
		<div class="box-body">
			<div class="form-group">
				<label>Judul</label>
				<input type="text" required="" value="{{old('title')}}" name="title" class="form-control">
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

			
			<div class="form-group">
				<label>Dokumen PDF</label>
				<input type="file" accept="application/pdf " name="file" class="form-control" required="">
			</div>

			
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
						<input type="hidden" name="kode_daerah" required="" value="{{(Auth::User()->kode_daerah)}}">
					</div>
					@endif
					<hr>
					<div class="form-group">
						<label>Ketegori</label>
						<select class="form-control" id="kategori"  name="category[]" multiple="">
							
						</select>
						<script type="text/javascript">
							$(function(){
								setTimeout(function(){
									
									$('#kategori').select2();

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