@extends('vendor.adminlte.admin')
@section('content_header')
<h4>BERITA ACARA {{$table['data_name']}} </h4>
@stop

@section('content')
	<div class="box box-warning">
		<div class="box-body" id="berita_acara">
			@if($head)
				<h5><b>DATA BERITA ACARA TELAH TERSEDIA</b></h5>
				<p><small>DIIKUTI OLEH {{HPV::nformat($head['rekap_desa']['melapor'])}} / {{HPV::nformat($head['rekap_desa']['total'])}} DESA TERDAFTAR, YANG BERSUMBER DARI {{HPV::nformat($head['rekap_kecamatan']['melapor'])}} / {{HPV::nformat($head['rekap_kecamatan']['total'])}} KECAMATAN DI {{$head['daerah']}}</small></p>
				<hr>
			@endif
			<div class="row row-no-gutters">
				<div class="col-md-9" style="height: 500px; overflow: scroll;">
					<form enctype="multipart/form-data" action="{{route('a.b.r.save',['tahun'=>$GLOBALS['tahun_access'],'kode_daerah'=>$kode_daerah,'id_data'=>$id_data])}}" method="post">
						@csrf
						<div class="" v-if="context_menu=='berita_acara'">
						<p><b>DATA BERITA ACARA</b></p>
						<hr>
						<iframe v-bind:src="path_berita_acara" style="width:100%; height:480px; "></iframe>
					</div>
					<div class="" v-if="context_menu=='penandatanganan'">
						<p><b>PESERTA DATA</b></p>
						<hr>
						<button type="button" class="btn btn-xs btn-primary" v-on:click="add_peseta()">
							<i class="fa fa-plus"></i> Tambah Peserta
						</button>
						<table class="table table-bordered" style="margin-top: 10px;">
							<thead class="" >
								<tr class="" style="background: yellow!important;">
									<th>NO</th>
									<th>JABATAN</th>
									<th>NIP</th>
									<th>NAMA</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item,index) in peserta">
									<td>
										@{{index+1}}
									</td>
									<td>
										<input v-model="item.head" type="text" class="form-control" v-bind:name="'peserta['+index+'][head]'">
									</td>
									<td>
										<input type="text" v-model="item.nip" class="form-control" v-bind:name="'peserta['+index+'][nip]'">
									</td>
									<td>
										<input v-model="item.name" type="text" class="form-control" v-bind:name="'peserta['+index+'][name]'">
									</td>
								</tr>
							</tbody>
						</table>
						
					
					</div>
					<div class="" v-if="context_menu=='berkas_ttd'">
						<p><b>BERKAS PENGESAHAN</b></p>
						<hr>
						<div class="form-group">
							<label>UPLOAD FILE PENGESAHAN BERTANDA TANGGAN</label>
							 <div class="input-group">
						      <input type="file" id="file-pengesahan-ttd" accept="application/pdf" v-on:change="file_change($event)"   name="file_pengesahan" class="form-control">
						      <span class="input-group-btn">
						        <button class="btn btn-danger" v-on:click="file_clear()" type="button"><i class="fa fa-trash"></i> Kosongkan</button>
						        <a class="btn btn-primary" v-bind:href="path_ttd_them" download type="button"><i class="fa fa-download"></i> Themplate </a>
						      </span>
						    </div>
							
						</div>
						<iframe v-bind:src="path_ttd_rendered" style="width:100%; height:480px; "></iframe>
					</div>
					<div>
						<hr>
						<button type="submit" class="btn btn-primary">SIMPAN</button>
					</div>
					</form>
				</div>
				<div class="col-md-3" style="height: 500px; overflow: scroll; background:#222; padding:10px;">
					 <ul class="list-group">
					  <li v-bind:class="'list-group-item '+(context_menu=='berita_acara'?'':'{{ $data['path_berita_acara']?'bg-yellow':'' }}')" >{!! $data['path_berita_acara']?'<i class="fa fa-check"></i>':'' !!} <span v-on:click="active('berita_acara')">BERKAS DATA</span></li>
					  <li v-bind:class="'list-group-item '+(context_menu=='penandatanganan'?'':'{{ $data['penanda_tangan']!=[]?'bg-yellow':'' }}')">{!! $data['penanda_tangan']!=[]?'<i class="fa fa-check"></i>':'' !!} <span v-on:click="active('penandatanganan')">PESERTA DATA</span></li>
					  <li v-bind:class="'list-group-item '+(context_menu=='berkas_ttd'?'':'{{ $data['path_ttd']?'bg-yellow':'' }}')"><span v-on:click="active('berkas_ttd')">{!! $data['path_ttd']?'<i class="fa fa-check"></i>':'' !!} BERKAS PENGESAAHAN</span></li>
					</ul> 
				</div>
			</div>
		</div>
		
	</div>
	@php
	@endphp
@stop

@section('js')
<script type="text/javascript">
	var d=new Vue({
		el:"#berita_acara",
		data:{
			'path_berita_acara':'{{$data['path_berita_acara']}}',
			'path_ttd':'{{$data['path_ttd']}}',
			'path_ttd_rendered':'{{$data['path_ttd']}}',
			'path_ttd_them':'{{$data['path_ttd_them']}}',

			'peserta':<?=($data['penanda_tangan'])?json_encode($data['penanda_tangan']):'[]'?>,
			'context_menu':'berita_acara'
		},
		methods:{
			active:function(ac){
				this.context_menu=ac;
			},
			file_change:function(e){
				var file = e.target.files[0]??null;
				if(file){
					if(file.type == "application/pdf"){
						this.path_ttd_rendered=(URL.createObjectURL(file));
					}
				}else{
					this.path_ttd_rendered=this.path_ttd;
				}
				

			},
			file_clear:function(){
				$('#file-pengesahan-ttd').val(null);
				this.path_ttd_rendered=this.path_ttd;
			},
			add_peseta:function(){
				this.peserta.push({
					'head':null,
					'name':null,
					'nip':null,
				});
			}
		}
	});
</script>

@stop