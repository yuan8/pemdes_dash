@extends('vendor.adminlte.admin')
@section('content_header')
<h4>MANAJENMEN INSTANSI</h4>
<a href="{{route('admin.instansi.add',[$GLOBALS['tahun_access']])}}" class="btn btn-success">TAMBAH</a>
@stop


@section('content')
<div class="box box-solid">
	<div class="box-hedaer with-border">
		<form action="{{url()->full()}}" method="get">
			<input type="text" class="form-control" placeholder="Cari.."  name="q" value="{{isset($_GET['q'])?$_GET['q']:''}}">
		</form>
	</div>
	

	<div class="box-body">

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>AKSI</th>
						<th style="width:50px;">LOGO/FOTO</th>
						<th>NAMA</th>
						<th>JENIS</th>
						<th>DESKRIPSI</th>

					</tr>
				</thead>
				<tbody>
					@foreach ($data as $key=>$d)
					<tr>
						<td>
							<a href="{{route('admin.instansi.show',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>HPV::slugify($d->name)])}}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
							<button onclick="modal_vue.init({{$key}})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
						</td>
						<td class="text-center"><img style="width:20px;" src="{{asset($d->image_path)}}"></td>
						<td>{{$d->name}}</td>
						<td>{{$d->sub_type}}</td>
						<td><p class="one-line">{{$d->description}}</p></td>

					</tr>
					@endforeach
				</tbody>

			</table>
		</div>
		{{$data->links()}}
	</div>
</div>

<div class="modal" id="modal-hapus" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form :action="url" method="post">
    	@csrf
    	<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">KONDIFMASI PENHAPUSAN</h5>
        
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin menghapus instansi "@{{ins.name}}"</p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
    </form>
  </div>
</div>

@stop

@section('js')

	<script type="text/javascript">
		var data=<?=json_encode($data) ?>;

		var modal_vue=new Vue({
			el:"#modal-hapus",
			data:{
				ins:{
					id:null,
					name:null,
				},
				url:null

			},
			methods:{
				init:function(key){
						window.modal_vue.$data.ins=data[key];
						var url='{{route('admin.instansi.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>'xxxx'])}}';
						console.log(this.$data);
						url=url.replace(/xxxx/g,this.ins.id);
						this.url=url;

						$('#modal-hapus').modal();
				}
			}
		})
	</script>

@stop