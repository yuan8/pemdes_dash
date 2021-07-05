@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH TABLE MAP</h4>

@stop


@section('content')
<form action="{{route('admin.tablemap.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
	@csrf
	<div class="box box-primary" id="table-create">
		<div class="box-body">
			<div class="form-group">
				<label>Table</label>
				<select class="form-control" id="table-select" name="table">
					@foreach ($tables as $t)
						<option value="{{$t}}">{{strtoupper(str_replace('_',' ',$t))}}</option>
						{{-- expr --}}
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Nama</label>
				<input type="text" v-model="name" class="form-control" name="name" required="">
			</div>
			<div class="form-group">
				<label>Gunakan Sebagai Format Data Validasi</label>
				<p><input type="radio" value="1"  name="format_validasi" > Ya</p>
				<p><input type="radio" value="0"  name="format_validasi" checked=""> Tidak</p>
			</div>
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary">TAMBAH</button>
		</div>
	</div>
</form>

@stop

@section('js')
<script type="text/javascript">
	var tableVue=new Vue({
		el:'#table-create',
		data:{
			table:null,
			name:null
		},
		methods:{
			select_table:function(){
				var name=this.table.toUpperCase();
				name=name.replace(/_/g,' ');
				name=name.replace(/DASH/g,'MAP');
				this.name=name.toUpperCase();

			},
			init:function(){
				$('#table-select').select2();
				$('#table-select').on('change',function(){
					tableVue.table=this.value;
					tableVue.select_table();

				});

				$('#table-select').trigger('change');


			}
		}

	});

	tableVue.init();
</script>
@stop