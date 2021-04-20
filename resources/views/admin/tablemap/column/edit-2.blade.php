@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TABLE COLUMNS [{{$data->table}}]</h4>
<div class="btn-group">
<a href="javascript:void(0)" onclick="add_column()" class="btn btn-success">TAMBAH COLUMN MAP</a>
<a href="{{route('admin.tablemap.edit.view',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>HPV::slugify($data->name)])}}"  class="btn  btn-info"> <i class="fa fa-pen"></i> VIEW MAP</a>
<button class="btn btn-primary">SIMPAN</button>
</div>

@stop


@section('content')
<h4><b>{{$data->name}} ({{$data->key_view}})</b></h4>
<form id="form-column" action="{{route('admin.tablemap.update.columns',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
	@csrf
	@method('PUT')
	<div class="box box-primary">
	<div class="box-body table-responsive">
		<table class="table table-bordered" id="table-columns" style="min-width: 110%";>
			<thead>
				<tr>
					<th>AKSI </th>
					<th style="min-width:350px;">NAMA </th>
					<th  style="min-width: 250px;">NAMA KOLOM</th>
					<th  style="min-width: 150px;">SATUAN</th>
					<th  style="min-width: 150px;">TIPE DATA</th>
					<th style="min-width: 250px;">DEFINISI/KONSEP</th>
					<th style="min-width: 350px;">INTERVAL NILAI</th>
					<th style="min-width: 150px;">TIPE AGREGASI</th>
					<th  style="min-width: 150px;">VIEW DATA AUTH</th>
					<th  style="min-width: 150px;">VIEW DATA VALIDASI</th>
					<th  style="min-width: 150px;">VIEW DATA DASHBOARD</th>
				</tr>
			</thead>
			<tbody>
				@foreach($columns??[] as $keyC=>$c)
					<tr id="column_record_{{$c->id}}">
						<td>
							<button type="button"  class="btn btn-xs btn-danger">
								<i class="fa fa-times"></i>
							</button>
						</td>
						<td>
							<input type="text" v-model="name"  class="form-control"  name="columns[ID_{{$c->id}}][name]" value="">

						</td>
						<td>
							<select class="form-control" v-model="name_column"  name="columns[ID_{{$c->id}}][name_column]">
								@foreach($master_c as $key=>$mc)
									<option value="{{$key}}" {{$key==$c->name_column?'selected':''}}>{{$key}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<input type="text" v-model="satuan"  class="form-control"  name="columns[ID_{{$c->id}}][satuan]">
							
						</td>
						<td>
							<select class="form-control" v-model="tipe_data"  name="columns[ID_{{$c->id}}][tipe_data]">
									<option value="string">String</option>
									<option value="numeric">Numeric</option>

							</select>
							
						</td>
						<td>
							<textarea v-model="definisi" class="form-control" name="columns[ID_{{$c->id}}][definisi]" ></textarea>
						</td>
						<td>
							<select multiple="" name="columns[ID_{{$c->id}}][interval_nilai][]"  v-model="interval_nilai_computed" id="interval_nilai_{{$c->id}}"   class="form-control"></select>
						</td>
						<td>
							<select  name="columns[ID_{{$c->id}}][aggregate_type]"  v-model="aggregate_type" id="tipe_aggregasi_{{$c->id}}"   class="form-control"></select>
						</td>
						<td>
							<select  name="columns[ID_{{$c->id}}][auth]"  v-model="auth"   class="form-control">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>

							</select>
						</td>
						<td>
							<select  name="columns[ID_{{$c->id}}][validate]"  v-model="validate"   class="form-control">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>

							</select>
						</td>
						<td>
							<select  name="columns[ID_{{$c->id}}][dashboard]"  v-model="dashboard"   class="form-control">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>

							</select>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</form>
@stop
@section('js')
<script type="text/javascript">
	var aggregasi_tipe=['NONE','COUNT_YA','COUNT_TIDAK','COUNT_ADA','COUNT_TIDAK_DATA','SUM','MAX','MIN','COUNT','COUNT_DISTINCT','AVERAGE'];
	var column_record=<?=json_encode($columns??[])?>;
		var vue_data=[];
		for(var i=0;i<column_record.length;i++){
			column_record[i]['interval_nilai_computed']=[];
			vue_data.push( new Vue({
				el:'#column_record_'+column_record[i].id,
				data:column_record[i],
				methods:{
					init:function(){
						var interval_nilai=this.interval_nilai;
						this.interval_nilai_computed=interval_nilai.split('|;|');
						$('#interval_nilai_'+column_record[i].id).select2({
								tags:true
						});
						for (var o =0; o<this.interval_nilai_computed.length; o++) {
							$('#interval_nilai_'+column_record[i].id).append('<option value="'+this.interval_nilai_computed[o]+'" selected>'+this.interval_nilai_computed[o]+'</option>')
						}
						for (var o =0; o<window.aggregasi_tipe.length; o++) {
							$('#tipe_aggregasi_'+column_record[i].id).append('<option value="'+window.aggregasi_tipe[o]+'" selected>'+window.aggregasi_tipe[o]+'</option>')
						}

						
					},
					simpan:function(){
						$('#form-column').submit();
					}
				},
				watch:{
					interval_nilai_computed:function(val,oldVal){
					},
					tipe_data:function(val){
						console.log(val);
						if(val=='string'){
							console.log(['NONE','COUNT_YA','COUNT_TIDAK','COUNT_ADA','COUNT_TIDAK_DATA'].includes(val));
							if(['NONE','COUNT_YA','COUNT_TIDAK','COUNT_ADA','COUNT_TIDAK_DATA'].includes(val)){

							}else{
								this.aggregate_type='NONE';

							}
						}else if(this.tipe_data=='numeric'){
								if(['NONE','SUM','MAX','MIN','COUNT','COUNT_DISTINCT','AVERAGE'].includes(val)){

								}else{
									this.aggregate_type='NONE';
								}

						}else{
								this.aggregate_type='NONE';
							
						}

					},
					tipe_aggregasi:function(val,oldVal){
						if(val!=oldVal){
							if(this.tipe_data=='string'){
								if(['NONE','COUNT_YA','COUNT_TIDAK','COUNT_ADA','COUNT_TIDAK_DATA'].includes(val)){

								}else{
									this.aggregate_type='NONE';

								}
							}else if(this.tipe_data=='numeric'){
								if(['NONE','SUM','MAX','MIN','COUNT','COUNT_DISTINCT','AVERAGE'].includes(val)){

								}else{
									this.aggregate_type='NONE';
								}

							}else{
									this.aggregate_type='NONE';

							}
						}
					}
				}
			}));
			vue_data[i].init();
		}
	
</script>
@stop