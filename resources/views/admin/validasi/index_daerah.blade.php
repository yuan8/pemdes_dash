@extends('vendor.adminlte.admin')
@section('content_header')
<h4>{{Auth::User()->can('is_only_daerah_verifikasi')?'VARIFIKASI':'VALIDASI'}} DATA  - {{$nama_daerah}}</h4>
@stop


@section('content')
	<form method="get" action="{{route('admin.validasi.data',['tahun'=>$GLOBALS['tahun_access']])}}">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">

				<label>DATA</label>

					<select class="form-control" name="data" id="data" required="">
						@foreach($table as $key=>$t)
							<option value="{{$t->id}}">{{$t->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					@php
						$last_elemet=null;
						$run_def=true;
					@endphp
					@foreach (['kdprovinsi','kdkabkota','kdkecamatan','kddesa'] as $element)
						@if($kodedaerah[$element])
							@php
								$last_elemet=$element;
							@endphp
							<input type="hidden" id="{{$element}}" name="{{$element}}" value="{{$kodedaerah[$element]}}">
						@else
						<div class="form-group">
							<label>{{strtoupper(str_replace('kd','', $element))}}</label>
							<select id="{{$element}}" name="{{$element}}"  class="form-control"></select>

							
							<script type="text/javascript">
							$(document).ready(function(){

							@if($run_def)
							@php
								$run_def=false
							@endphp
							$('#'.element).attr('required',true);
								setTimeout(function(){
									{{$last_elemet}}({{$kodedaerah[$last_elemet]}});
								console.log('{{$last_elemet}}({{$kodedaerah[$last_elemet]}})');
								},1000);
							@endif

							setTimeout(function(){
								$('#kdkabkota').on('change',function(){
									kdkabkota(this.value);
								});

								$('#kdkecamatan').on('change',function(){
									kdkecamatan(this.value);
								});
							$('#{{$element}}').select2();

						},500);
							});

								
							</script>
						</div>
						@endif
					@endforeach
					
				</div>
				<button class="btn btn-primary">SUBMIT</button>
				<script type="text/javascript">
					setTimeout(function(){
						$('#data').select2()
					},2000);
				</script>
			</div>

		</div>
	</form>
	@stop

	@section('js')

	<script type="text/javascript">
	var kodedaerah={!!json_encode($kodedaerah)!!};

	$(document).ready(function(){
		$('#kdprovinsi').on('change',function(){
			kdprovinsi(this.value);

		});


		$('#kdkabkota').on('change',function(){
			kdkabkota(this.value);
		});

		$('#kdkecamatan').on('change',function(){
			kdkecamatan(this.value);
		});

	});
	


	function kdprovinsi(kd){
		console.log('tp');
		$('#kdkabkota').val(null).trigger('change');
		$('#kdkabkota').html('').trigger('change');
		$('#kdkecamatan').val(null).trigger('change');
		$('#kdkecamatan').html('').trigger('change');


		$('#desa').val(null).trigger('change');
		$('#desa').html('').trigger('change');
		$('#kdkabkota').append('<option value="" selected >-</option>');
		$('#kota').trigger('change');


		if(kd){

			$.get('{{route('api.meta.kota')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#kdkabkota').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');
				}
				$('#kdkabkota').trigger('change');
				$('#kdkabkota').select2();
			});

			


		}

	}

	function kdkabkota(kd){

		$('#kdkecamatan').val(null)
		$('#kdkecamatan').html('');
		$('#kdkecamatan').val(null);
		$('#kdkecamatan').html('');

		$('#kdkecamatan').append('<option value="" selected >-</option>');
		$('#kdkecamatan').trigger('change');



		if(kd){
			$.get('{{route('api.meta.kecamatan')}}/'+kd,function(res){
				res=res.result;
				for(var i=0;i<res.length;i++){
					$('#kdkecamatan').append('<option value="'+res[i].id+'"  >'+res[i].text+'</option>');

				}
				$('#kdkecamatan').trigger('change');
				$('#kdkecamatan').select2();
			});
			
			

		}
		
		
	}

	function kdkecamatan(kd){

		$('#kddesa').val(null).trigger('change');
		$('#kddesa').html('');
		$('#kddesa').append('<option value="" selected >-</option>');
		$('#kddesa').trigger('change');

		
		if(kd){

			$.get('{{route('api.meta.desa')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#kddesa').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');

				}
				$('#kddesa').select2();

			});

		

		}
			

	}
	
	</script>
	@stop