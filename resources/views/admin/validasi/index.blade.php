@extends('vendor.adminlte.admin')
@section('content_header')
<h4>VALIDASI DATA</h4>

@stop


@section('content')

	<form method="get" action="{{route('admin.validasi.data',['tahun'=>$GLOBALS['tahun_access']])}}">
		<div class="row">
			<div class="col-md-6">
<div class="form-group">

				<label>DATA</label>

				<select class="form-control" name="data" id="data" required="">
					@foreach($table as $key=>$t)
						<option value="{{$key}}">{{$t['name']}}</option>
					@endforeach
				</select>
			</div>

<div class="form-group">

				<label>PROVINSI</label>
				<select class="form-control" name="kdprovinsi" id='provinsi' required="">
					@foreach($provinsi as $key=>$t)
						<option value="{{$t->kdprovinsi}}">{{$t->nmprovinsi}}</option>
					@endforeach
				</select>
			</div>

<div class="form-group">

				<label>KOTA</label>
				<select class="form-control" id="kota" name="kdkota" >
					
				</select>
			</div>
<div class="form-group">


				<label>KECAMATAN</label>
				<select class="form-control" id="kecamatan" name="kdkecamatan">
					
				</select>
			</div>

<div class="form-group">

				<label>DESA</label>
				<select class="form-control" id="desa" name="kddesa" >
					
				</select>
			</div>
			</div>

		</div>
		<div class="btn-group">
			<button class="btn btn-primary background-blue" type="submit">SUBMIT</button>
		</div>
	</form>
</div>


@stop

@section('js')

<script type="text/javascript">
	var kodedaerah={!!json_encode($kodedaerah)!!};
	
	$('#provinsi').select2();
	$('#data').select2();

	

	$('#provinsi').on('change',function(){
		kdprovinsi(this.value);
	});

	$('#provinsi').trigger('change');

	$('#kota').on('change',function(){
		kdkota(this.value);
	});

	$('#kecamatan').on('change',function(){
		kdkecamatan(this.value);
	});


	


	function kdprovinsi(kd){
		console.log('tp');
		$('#kota').val(null).trigger('change');
		$('#kota').html('').trigger('change');
		$('#kecamatan').val(null).trigger('change');
		$('#kecamatan').html('').trigger('change');


		$('#desa').val(null).trigger('change');
		$('#desa').html('').trigger('change');
		$('#kota').append('<option value="" selected >-</option>');
				$('#kota').trigger('change');


		if(kd){

			$.get('{{route('api.meta.kota')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#kota').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');
				}
				$('#kota').trigger('change');
				$('#kota').select2();
			});

			


		}

	}

	function kdkota(kd){
		console.log('tk');

		$('#kecamatan').val(null)
		$('#kecamatan').html('');
		$('#desa').val(null);
		$('#desa').html('');

		$('#kecamatan').append('<option value="" selected >-</option>');
		$('#kecamatan').trigger('change');



		if(kd){
			$.get('{{route('api.meta.kecamatan')}}/'+kd,function(res){
				res=res.result;
				for(var i=0;i<res.length;i++){
					$('#kecamatan').append('<option value="'+res[i].id+'"  >'+res[i].text+'</option>');

				}
				$('#kecamatan').trigger('change');
				$('#kecamatan').select2();
			});
			
			

		}
		
		
	}

	function kdkecamatan(kd){

		$('#desa').val(null).trigger('change');
		$('#desa').html('');
		$('#desa').append('<option value="" selected >-</option>');
		$('#desa').trigger('change');

		
		if(kd){

			$.get('{{route('api.meta.desa')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#desa').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');

				}
				$('#desa').select2();

			});

		

		}
			

	}
		
	
</script>
@stop