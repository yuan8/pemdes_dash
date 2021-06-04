<div class="row row">
	@foreach ($data as $element)
	<a href="{{route($element->jenis=='PEMDA'?'data.instansi_pemda':'data.instansi',['tahun'=>$GLOBALS['tahun_access'],'kode_daerah'=>$element->id])}}">
			<div class="col-md-2 col-sm-3 col-xs-4">
		<div class="box-solid box" style="height: 150px; overflow: hidden;">
			<div class="box-header background-img-box-red with-border">
				<img src="">
			</div>
			<div class="box-body">
				<p><b>{{$element->name}}</b></p>
			</div>
		</div>
	</div>
	</a>
@endforeach
</div>