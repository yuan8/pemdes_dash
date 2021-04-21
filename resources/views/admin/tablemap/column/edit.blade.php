@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TABLE COLUMNS [{{$data->table}}]</h4>
<div class="btn-group" >
<a href="javascript:void(0)" onclick="data_components.add_column()" class="btn btn-success">TAMBAH COLUMN MAP</a>
<a href="{{route('admin.tablemap.edit.view',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>HPV::slugify($data->name)])}}"  class="btn  btn-info"> <i class="fa fa-pen"></i> VIEW MAP</a>
	
</div>

@stop


@section('content')
<h4><b>{{$data->name}} ({{$data->key_view}})</b></h4>
<form id="form-column" action="{{route('admin.tablemap.update.columns',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
	@csrf
	@method('PUT')
	 {{-- this my component  --}}
	<div id="remove_components">
			<input v-for="r in items" class="form-control" type="hidden" name="remove[]" v-model="r.id">
			
			
	</div>

	<div class="box box-primary">
	<div class="box-header">
		<button class="btn btn-primary"  type="submit">SIMPAN</button>
	</div>
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
			<tbody id="data_components" >
					<tr v-for="item in items">
						<td>
							<button type="button" v-on:click="remove(item)" class="btn btn-xs btn-danger">
								<i class="fa fa-times"></i>
							</button>
						</td>
						<td>
							<input required="" type="text" v-model="item.name" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][name]'"  class="form-control"   value="">
						

						</td>
						<td>
							<select required=""  class="form-control" v-model="item.name_column"  v-model="item.name" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][name_column]'" >
								<option v-for="c in columns" v-bind:value="c.Field" >@{{c.Field}}</option>
							</select>
						</td>
						<td>
							<input type="text" v-model="item.satuan" v-model="item.name" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][satuan]'"   class="form-control"  >
							
						</td>
						<td>
							<select required=""  v-on:change="changeTipeData(item)" class="form-control" v-model="item.tipe_data" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][tipe_data]'"  >
									<option value="string">String</option>
									<option value="numeric">Numeric</option>

							</select>
							
						</td>
						<td>
							<textarea v-model="item.definisi" class="form-control"  v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][definisi]'"  ></textarea>
						</td>
						<td>
							<select multiple="" v-bind:id="'interval_nilai_'+item.id" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][interval_nilai][]'"   v-model="item.interval_nilai_computed"  class="form-control"></select>
						</td>
						<td>
							<select required=""  v-model="item.aggregate_type" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][aggregate_type]'"  v-bind:id="'tipe_aggregasi_'+item.id"   class="form-control">
								<option v-if="item.tipe_data=='string'" v-for="c in aggregasi_tipe_string" v-bind:value="c" >@{{c}} </option>
								<option v-if="item.tipe_data=='numeric'" v-for="c in aggregasi_tipe_numeric" v-bind:value="c" >@{{c}} </option>
							</select>
						</td>
						<td>
							<select required=""     v-model="item.auth" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][auth]'"  class="form-control">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>

							</select>
						</td>
						<td>
							<select required=""     v-model="item.validate" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][validate]'"   class="form-control">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>

							</select>
						</td>
						<td>
							<select  required=""  v-model="item.dashboard" v-model="item.validate" v-bind:name="'columns['+(item.stored?'ID_':'NEW_')+item.id+'][dashboard]'"   class="form-control">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>

							</select>
						</td>
					</tr>
			</tbody>
		</table>
	</div>
</div>
</form>
@stop
@section('js')
<script type="text/javascript">
	var aggregasi_tipe=['NONE','COUNT_YA','COUNT_TIDAK','COUNT_ADA','COUNT_TIDAK_DATA','SUM','MAX','MIN','COUNT','COUNT_DISTINCT','AVERAGE'];
	var aggregasi_tipe_string=['NONE','COUNT_YA','COUNT_TIDAK','COUNT_ADA','COUNT_TIDAK_DATA'];
	var aggregasi_tipe_numeric=['NONE','SUM','MAX','MIN','COUNT','COUNT_DISTINCT','AVERAGE'];

	var remove_components=new Vue({
		el:'#remove_components',
		data:{
			title:'dsdsds',
			items:[
				{
					id:34
				}
			],
			aggregasi_tipe_string:window.aggregasi_tipe_string,
			aggregasi_tipe_numeric:window.aggregasi_tipe_numeric,

		},
		methods:{
			addItem:function(key){
				return this.items.push(key);
			}
		}
	});

	var data_components= new Vue({
		el:"#data_components",
		data:{
			items:<?= json_encode($columns) ?>,
			columns:<?= json_encode($master_c)?>,
			new_column:0
		},
		methods:{
			changeTipeData:function(key){
				var val=key.tipe_data;
				console.log(key);
					if(val=='string'){
						
						if(window.aggregasi_tipe_string.includes(val)){

						}else{
							this.items[this.items.indexOf(key)].aggregate_type='NONE';

						}
					}else if(key.tipe_data=='numeric'){
							if(window.aggregasi_tipe_numeric.includes(val)){

							}else{
								this.items[this.items.indexOf(key)].aggregate_type='NONE';
							}

					}else{
							this.items[this.items.indexOf(key)].aggregate_type='NONE';
					}

					



			},
			init:function(key=null){
				if(key!=null){
					var ct=this.items[key];

					var interval_nilai=ct.interval_nilai??'';
					if(!Array.isArray(interval_nilai)){
						ct.interval_nilai_computed=interval_nilai.split('|;|');
						ct.interval_nilai=ct.interval_nilai_computed;
					}
					for (var o =0; o<ct.interval_nilai_computed.length; o++) {
						if(ct.interval_nilai_computed[o]){
							$('#interval_nilai_'+ct.id).append('<option value="'+ct.interval_nilai_computed[o]+'" selected>'+ct.interval_nilai_computed[o]+'</option>')
						}
						
					}
					setTimeout(function(){
						for(item in this.items){
							var ct=this.items[item];
							$('#interval_nilai_'+ct.id).select2({
								tags:true
							});
						}
					},100);

				}else{
					for(item in this.items){
						var ct=this.items[item];
							var interval_nilai=ct.interval_nilai??'';
							if(!Array.isArray(interval_nilai)){
								ct.interval_nilai_computed=interval_nilai.split('|;|');
							}
							for (var o =0; o<ct.interval_nilai_computed.length; o++) {
								if(ct.interval_nilai_computed[o]){
									$('#interval_nilai_'+ct.id).append('<option value="'+ct.interval_nilai_computed[o]+'" selected>'+ct.interval_nilai_computed[o]+'</option>')
								}
								
							}
							$('#interval_nilai_'+ct.id).select2({
									tags:true
							});

							console.log(item,this.items[item]);


					}

				}
					

			},
			remove:function(key){
				if(key.stored){
					window.remove_components.addItem(key);
				}
				this.items.splice(this.items.indexOf(key), 1);
			},
			add_column:function(){
				this.new_column+=1;
				this.items.unshift({
					id:'xx_'+this.new_column,
					"stored":false,
					"id_ms_table":1,
					"name":"",
					"name_column":"",
					"aggregate_type":"NONE",
					"satuan":"",
					"auth":0,
					"dashboard":1,
					"validate":1,
					"id_user":{{Auth::User()->id}},
					"created_at":null,
					"updated_at":null,
					"definisi":"",
					"tipe_data":"numeric",
					"interval_nilai":"",
					"interval_nilai_computed":[]

				});

				this.init(0);
			},
			simpan:function(){
				$('#form-column').submit();
			}
		},
		
	}) ;

	data_components.init();

	
	
</script>
@stop