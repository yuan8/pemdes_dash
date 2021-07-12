@extends('vendor.adminlte.admin')
@section('content_header')
<h4>FORM PENAMBAHAN INSTANSI PUSAT</h4>
@stop


@section('content')
<div class="box box-solid">
	<form method="post" enctype="multipart/form-data" action="{{route('admin.instansi.store',['tahun'=>$GLOBALS['tahun_access']])}}">
		@csrf
	<div class="box-hedaer with-border">
		
	</div>
	<div class="box-body " id="instansi">
		<div class="row">
			<div class="col-md-4 ">
				<div class="text-center">
					<img :src="image_path" onerror="errImg(this)" style="max-width:100%; max-height: 100px;">
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
				<div class="form-group" v-if="inst.type=='PEMDA KOTA/KAB'">
					<label>KAB KOTA</label>
					<select class="form-control" name="kode_daerah" id="kode_daerah" required=""></select>
				</div>
				{{-- <div class="form-group">
					<label>Jenis Instansi</label>
					<select class="form-control" required="" id="jenis_instansi" v-model="inst.type" name="sub_type">
						<option v-for="i in jenis_instansi" v-bind:value="i">@{{i}}</option>
					</select>
				</div> --}}
				<div class="form-group">
					<label>Deskripsi</label>
					<textarea class="form-control" v-model="inst.description" name="description"></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">TAMBAH</button>
	</div>
	</form>
</div>
@stop

@section('js')
<script type="text/javascript">
	function errImg(){
		d.src='{{url('logo.png')}}';
	}
	var instansi=new Vue({
		el:'#instansi',
		data:{
			inst:{
				id:null,
				name:null,
				description:null,
				type:null,
				image_path:'logo.png',
			},
			jenis_instansi:[
				'PUSAT','PEMDA KOTA/KAB',
			],

			image_path:null,
			img_path_update:null,

		},
		watch:{
			'inst.type':function(val){
				if(val=='PEMDA KOTA/KAB'){
					setTimeout(function(){
						$('#kode_daerah').html('');
						$.get('{{route('api.meta.kota')}}/',function(res){
						res=res.result;

						for(var i=0;i<res.length;i++){
							$('#kode_daerah').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');
						}
						$('#kode_daerah').trigger('change');
						$('#kode_daerah').select2();
					});
					},500);
				}
			}
		},
	
		methods:{
			init:function(){

				setTimeout(function(){
					window.instansi.image_path='{{url('')}}/'+window.instansi.inst.image_path;
					// $('#jenis_instansi').select2();

				},100);

				
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