@extends('vendor.adminlte.admin')
@section('content_header')
<h4>EDIT INSTANSI</h4>
@stop


@section('content')
<div class="box box-solid">
	<form method="post" enctype="multipart/form-data" action="{{route('admin.instansi.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}">
		@csrf
	<div class="box-hedaer with-border">
		
	</div>
	<div class="box-body " id="instansi">
		<div class="row">
			<div class="col-md-4 ">
				<div class="text-center">
					<img :src="image_path " style="max-width:100%; max-height: 100px;">
				</div>
				<div class="form-group">
					<hr>
					<label>Ubah Logo</label>
					<input type="file" class="form-control"  v-on:change="img_update" accept="image/*" name="image_path">
				</div>

			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label>Nama</label>
					<input type="text" required="" v-model="inst.name" class="form-control" name="name">
				</div>
				{{-- <div class="form-group">
					<label>Jenis Instansi</label>
					<select class="form-control" required="" id="jenis_instansi" v-model="inst.sub_type" name="sub_type">
						<option v-for="i in jenis_instansi" v-bind:value="i">@{{i}}</option>
					</select>
				</div> --}}
				<div class="form-group">
					<label>Deskripsi</label>
					<textarea class="form-control" v-model="inst.deskripsi" name="description"></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">UPDATE</button>
	</div>
	</form>
</div>
@stop

@section('js')
<script type="text/javascript">
	var instansi=new Vue({
		el:'#instansi',
		data:{
			inst:<?= json_encode($data)?>,
			jenis_instansi:[
				'PUSAT','PEMDA KOTA/KAB',
				
			],

			image_path:null,
			img_path_update:null,

		},
	
		methods:{
			init:function(){

				setTimeout(function(){
					window.instansi.image_path='{{url('')}}/'+window.instansi.inst.image_path;
					$('#jenis_instansi').select2();
				},100)
			},
			img_update:function(ev){

				const file = ev.target.files[0];
		      const reader = new FileReader();
		      reader.readAsDataURL(file);
		      reader.onload = function(e) {
		      	window.instansi.image_path= e.target.result
		      console.log(e.target.result);

		      }
		      
				
			}
		}
	});

	setTimeout(function(){
		instansi.init();
		
	},500);
</script>
@stop