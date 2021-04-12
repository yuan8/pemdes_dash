@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TABLE COLUMNS [{{$data->table}}]</h4>
<div class="btn-group">
<a href="javascript:void(0)" onclick="add_column()" class="btn btn-success">TAMBAH COLUMN MAP</a>
<a href="{{route('admin.tablemap.edit.view',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>HPV::slugify($data->name)])}}"  class="btn  btn-info"> <i class="fa fa-pen"></i> VIEW MAP</a>
</div>
@stop


@section('content')
<h4><b>{{$data->name}} ({{$data->key_view}})</b></h4>
<form action="{{route('admin.tablemap.update.columns',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
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
					<tr>
						<td>
							<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove(); add_remove('ID_{{$c->id}}') "><i class="fa fa-trash"></i></button>

						</td>
						<td>
							<small style="display: none;">{{$c->name}}</small>
							<input type="text" required="" class="form-control" name="columns[ID_{{$c->id}}][name]" value="{{$c->name}}"></td>
						<td>
							<small style="display: none;">{{$c->name_column}}</small>
							<select class="form-control" name="columns[ID_{{$c->id}}][name_column]" >
								@foreach($master_c as $key=>$mc)
									<option value="{{$key}}" {{$key==$c->name_column?'selected':''}}>{{$key}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<small style="display: none;">{{$c->satuan}}</small>
							<input type="text" required="" class="form-control" name="columns[ID_{{$c->id}}][satuan]" value="{{$c->satuan}}">

						</td>
						<td>
							{{-- <small style="display: none;">{{$c->tipe_data}}</small>
							<input type="text"  class="form-control" name="columns[ID_{{$c->id}}][tipe_data]" value="{{$c->tipe_data}}">
 --}}
						</td>
						<td>
							<small style="display: none;">{{$c->definisi}}</small>
							<textarea type="text" class="form-control" name="columns[ID_{{$c->id}}][definisi]" >{!!$c->definisi!!}</textarea>

						</td>
						<td>
							{{-- <textarea style="display: none;" type="hidden"  class="form-control" name="columns[ID_{{$c->id}}][interval_nilai]" id="interval_{{$c->id}}_interval_nilai">{!!$c->interval_nilai!!}</textarea>
							<button type="button" class="btn btn-xs btn-warning" onclick="inteval_edit(this)"  target="interval_{{$c->id}}">Edit Interval</button>
							<hr>
								<input type="hidden" id="interval_{{$c->id}}_type" name="columns[ID_{{$c->id}}][type_interval]">

							<div id="interval_{{$c->id}}">
									<div class="row">
										<div class="col-md-6 col-sm-6">
										  <input type="text" class="form-control option_val" placeholder="Recipient's username" aria-describedby="basic-addon2" value="{{$c->id}}">
										</div>
										
										<div class="col-md-6 col-sm-6">

										  <input type="text" class="form-control option_text" placeholder="Recipient's username" aria-describedby="basic-addon2" value="SATU">

										</div>

										
									</div>

							</div> --}}


						</td>
					{{-- 	<td>
							<textarea style="display: none;" type="hidden" class="form-control" name="columns[ID_{{$c->id}}][interval_nilai]" id="interval_{{$c->id}}_interval_nilai">{!!$c->interval_nilai!!}</textarea>
							<button type="button" class="btn btn-xs btn-warning" onclick="inteval_edit(this)"  target="interval_{{$c->id}}">Edit Interval</button>
							<hr>
								<input type="hidden" id="interval_{{$c->id}}_type" name="columns[ID_{{$c->id}}][type_interval]">

							<div id="interval_{{$c->id}}">
									<div class="row">
										<div class="col-md-6 col-sm-6">
										  <input type="text" class="form-control option_val" placeholder="Recipient's username" aria-describedby="basic-addon2" value="{{$c->id}}">
										</div>
										
										<div class="col-md-6 col-sm-6">

										  <input type="text" class="form-control option_text" placeholder="Recipient's username" aria-describedby="basic-addon2" value="SATU">

										</div>

										
									</div>

							</div>


						</td> --}}
						<td>
							<small style="display: none;">{{$c->aggregate_type}}</small>
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][aggregate_type]">
								@foreach(HPV::operator() as $op)
									<option class="" value="{{$op}}" {{$op==$c->aggregate_type?'selected':''}}>{{$op}}</option>
								@endforeach
								
								
							</select>
							</td>
						<td>
							<small style="display: none;">{{$c->auth?'PERLU LOGIN':'SEMUA DAPAT MELIHAT'}}</small>
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][auth]">
								<option class="" value="1" {{$c->auth?'selected':''}}>PERLU LOGIN</option>
								<option class="" value="0" {{!$c->auth?'selected':''}}>SEMUA DAPAT MELIHAT</option>

							</select>
							
						</td>
						<td>
						
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][validate]">
								<option class="" value="1" {{$c->validate?'selected':''}}>TAMPIL</option>
								<option class="" value="0" {{!$c->validate?'selected':''}}>TIDAK TAMPIL</option>

							</select>
							
						</td>
						<td>
							<select class="form-control" required="" name="columns[ID_{{$c->id}}][dashboard]">
								<option class="" value="1" {{$c->dashboard==1?'selected':''}}>TAMPIL</option>
								<option class="" value="0" {{$c->dashboard==0?'selected':''}}>TIDAK TAMPIL</option>

							</select>
							
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		<div id="remove" style="display: none"></div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">SIMPAN</button>
	</div>
</div>
</form>

<div style="display: none">
			<table  >
				<tbody id="themp-tr">
					<tr>
					<td>
				<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></button>

			</td>
			<td>
				<small style="display: none;" ></small>
				<input type="text" required="" onchange="$(this).parent().find('small').html(this.value)" class="form-control" name="columns[NEW_XXXX][name]" value=""></td>
			<td>
				<small style="display: none;"></small>
				<select class="form-control"  name="columns[NEW_XXXX][name_column]"  onchange="$(this).parent().find('small').html(this.value)">
					@foreach($master_c as $key=>$mc)
						<option value="{{$key}}" >{{$key}}</option>
					@endforeach
				</select>
			</td>
			<td>
				<small style="display: none;"></small>
				<input type="text" required="" class="form-control" name="columns[NEW_XXXX][satuan]" value="">

			</td>
			<td>
				{{-- <small style="display: none;"></small>
				<input type="text" class="form-control" name="columns[NEW_XXXX][tipe_data]" value=""> --}}

			</td>
			<td>
				{{-- <textarea type="text"  class="form-control" name="columns[NEW_XXXX]][definisi]" ></textarea> --}}

			</td>
			<td>
				{{-- <textarea  style="display:none;" type="text" class="form-control" name="columns[NEW_XXXX]][interval_nilai]" >{"type":"text","data":[{"val":"","text":""}]}</textarea>
				<button type="button" class="btn btn-xs btn-warning" onclick="inteval_edit(this)"  target="interval_NEW_XXXX">Edit Interval</button>
				<hr>
				<input type="hidden" id="interval_NEW_XXXX_type" value="text">
				<div id="interval_NEW_XXXX">
					<P></P>
				</div> --}}


			</td>
			<td>
				<small style="display: none;"></small>
				<select class="form-control" required="" name="columns[NEW_XXXX][aggregate_type]">
						@foreach(HPV::operator() as $op)
									<option class="" value="{{$op}}" >{{$op}}</option>
								@endforeach
				</select>
				</td>
			<td>
				<small style="display: none;">SEMUA DAPAT MELIHAT</small>
				<select class="form-control" required="" name="columns[NEW_XXXX][auth]">
					<option class="" value="1"  >PERLU LOGIN</option>
					<option class="" value="0" >SEMUA DAPAT MELIHAT</option>

				</select>
				
			</td>
				<td>
						
					<select class="form-control" required="" name="columns[NEW_XXXX][validate]">
						<option class="" value="1" >TAMPIL</option>
						<option class="" value="0" >TIDAK TAMPIL</option>

					</select>
					
				</td>
						<td>
						
							<select class="form-control" required="" name="columns[NEW_XXXX][dashboard]">
								<option class="" value="1" >TAMPIL</option>
								<option class="" value="0" >TIDAK TAMPIL</option>

							</select>
							
						</td>

				</tr>
				</tbody>
			</table>
	
</div>

<div class="modal fade" id="modal_interval">
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<div class="form-group">
				<label>Tipe Interval Nilai</label>
				<select class="form-control" id="modal_type_interval" >
					<option value="text_">Keterangan Text</option>
					<option value="list_">List</option>
					<option value="number_">Input Number 0 - Takterhingga</option>
				</select>
				<div style="margin-top: 15px;">
					<div id="cc_interval"></div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="button-modal-interval" >SAVE</button>
		</div>
	</div>
</div>
</div>

@stop

@section('js')


	<script type="text/javascript">

		var data_glob_interval={};

		function add_column(){
			var tm=$('#themp-tr').html();
			tm=tm.replace(/XXXX/g,key_column+1);
			key_column+=1;
			$('#table-columns tbody').prepend(tm);
		}

		

		// function inteval_edit(dom,no_mo=false){
		// 	var target=$(dom).attr('target');
		// 	var dom_interval=$('#'+target).html();
		// 	var type=$('#'+target+'_type').val();
		// 	$('#modal_interval #cc_interval').html('');
			
		// 	if(no_mo==false){


		// 		if(!type){
		// 			type='list_';
		// 		}

		// 		$('#modal_interval').modal();
		// 		$('#modal_type_interval option').attr('target',dom);


		// 	}

		// 	$('#button-modal-interval').attr('onclick','save_interval("'+target+'","'+type+'")');

		// 	$('#modal_interval #modal_type_interval option').removeAttr('selected');
		// 	$('#modal_interval #modal_type_interval option[value="'+type+'"]').attr('selected','true');
			
		// 	if(type=='list_'){
		// 		$('#modal_interval #cc_interval').html('<button style="margin-bottom:10px;" onclick="add_list()" class="btn btn-primary btnxs"><i class="fa fa-plus"></i> Tambah List</button>'+
		// 		'<table class="table table-bordered"><thead><tr><th>AKSI</th><th>NILAI</th><th>TEXT</th></tr></thead><tbody id="modal-interval-body"></tbody></table>');

		// 		var data_list=[];
		// 		$('#'+target+' .option_val').each(function(i,d){
		// 			if(data_list[i]==undefined){
		// 				data_list.push({
		// 					'val':$(d).val(),
		// 					'text':'',
		// 				});
		// 			}
		// 		});
		// 		$('#'+target+' .option_text').each(function(i,d){
		// 				data_list[i].text=$(d).val();
		// 		});

		// 		var data_interval=({
		// 			'type':type,
		// 			'data':data_list
		// 		});

		// 		$('#modal-interval-body').html('');

		// 		for(var i = 0; i < data_list.length ; i++){
		// 			var ii='<tr>'+
		// 			'<td><button onclick="$(this).parent().parent().remove()" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></button></td>'+
		// 				'<td class="col-md-6 col-sm-6">'+
		// 				  '<input type="text" class="form-control option_val" placeholder="" aria-describedby="basic-addon2" value="'+data_list[i].val+'">'+
		// 				'</td>'+
		// 				'<td class="col-md-6 col-sm-6">'+
		// 				  '<input type="text" class="form-control option_text" placeholder="Text" aria-describedby="basic-addon2" value="'+data_list[i].text+'">'+
		// 				'</td>'+
		// 				'</tr>';
		// 				$('#modal-interval-body').append(ii);

		// 		}






		// 	}else {
		// 		var text=$(dom+'_interval_nilai').html()??'{"type":"text","data":[{"val":"..","text":"'+type+'"}]}';
		// 		var json=JSON.parse(text);
		// 		$('#cc_interval').html('<textarea id="modal-interval-body" class="form-control"><textarea>');

		// 		var data_interval={
		// 			'type':type,
		// 			'data':[{'val':'..','text':type}]
		// 		};

		// 		$('#cc_interval #modal-interval-body').html()

		// 	}

		// 	$('#modal_type_interval').on('change',function(){
		// 			inteval_edit($(this).attr('target'),true);
		// 	});

			


		// }

		// function add_list(){
		// 	var d='<tr><td><button onclick="$(this).parent().parent().remove()" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></button></td>'+
		// 				'<td class="col-md-6 col-sm-6">'+
		// 				  '<input type="text" class="form-control option_val" placeholder="" aria-describedby="basic-addon2" value="">'+
		// 				'</td>'+
		// 				'<td class="col-md-6 col-sm-6">'+
		// 				  '<input type="text" class="form-control option_text" placeholder="Text" aria-describedby="basic-addon2" value="">'+
		// 				'</td>'+
		// 				'</tr>';

		// 		$('#modal-interval-body').append(d);
		// }


		// function save_interval(target,type){
	
		// 	var ii='';

			

			
		// 	var moda_data='modal-interval-body';

		// 	if(type=='list_'){
		// 		var data_list=[];
		// 		$('#'+moda_data+' .option_val').each(function(i,d){
		// 			if(data_list[i]==undefined){
		// 				data_list.push({
		// 					'val':$(d).val(),
		// 					'text':''
		// 				});
		// 			}
		// 		});
		// 		$('#'+moda_data+' .option_text').each(function(i,d){
		// 				data_list[i].text=$(d).val();
		// 		});


		// 		for(var i = 0; i < data_list.length ; i++){
		// 			ii+='<tr>'+
		// 			''+
		// 				'<td class="col-md-6 col-sm-6">'+
		// 				  '<input type="text" class="form-control option_val" placeholder="" aria-describedby="basic-addon2" value="'+data_list[i].val+'">'+
		// 				'</td>'+
		// 				'<td class="col-md-6 col-sm-6">'+
		// 				  '<input type="text" class="form-control option_text" placeholder="Text" aria-describedby="basic-addon2" value="'+data_list[i].text+'">'+
		// 				'</td>'+
		// 				'</tr>';

		// 		}

		// 		var data_interval=({
		// 			'type':$('#modal_type_interval').val(),
		// 			'data':data_list
		// 		});
		// 	}else{
		// 		var data_interval=({
		// 			'type':$('#modal_type_interval').val(),
		// 			'data':['type':type,'data':[{'val':$('#modal-interval-body').val(),'text':type}]];
		// 		});

		// 		$('#'+target).html('<textarea class="form-control" id="'+target+'_interval_nilai_nya'+'"></textarea>');
		// 		$('#'+target+'_interval_nilai_nya').html('')


		// 	}
			

		// 	$('#'+target).html(ii);
		// 	$('#modal_interval').modal('toggle');
		// 	$('#'+target+'_interval_nilai').html(JSON.stringify(data_interval));



		// }

		var key_column={{count($columns)}};
		function add_remove(id){
			$('#remove').append('<input type="hidden" name="remove[]" value="'+id+'">');
		}
		
	</script>
@stop