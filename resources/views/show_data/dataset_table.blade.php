
@extends('vendor.adminlte.dashboard')

@section('content_header')
<div class="row">
	<div class="col-md-12">
	<ol class="breadcrumb text-left">
	    <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active text-capitalize">{{ strtolower((!empty($instansi)) ?str_replace('_',' ',str_replace('_', ' ', $instansi->type)).' - '.$instansi->name:(isset($title)?$title:'Cari Data'))}}</li>
	  </ol>
  </div>


</div>
	@include('partials.banner_head',['placeholder_search'=>'Cari Data '.(isset($instansi)?ucfirst(strtolower($instansi->type)).' '.ucfirst(strtolower($instansi->name)):', Instansi, Tema'),'route_search'=>route('query.data',['tahun'=>$GLOBALS['tahun_access']])])
@stop
@section('content')
<div class="box box-solid">
	<div class="box-header with-border">
		<h4 class="text-center" ><b>{{strtoupper($data->title)}} - {{$GLOBALS['tahun_access']}}</b></h4>
			<div class="box-solid box btn-ov " style="border: 1px solid #fa090a">
	  		<div class="box-body">
	  			<p>{!!nl2br($data->deskripsi)!!}</p>
	  		</div>
	  	</div>
	</div>
	<div class="box-body  ">
		 <ul class="nav nav-tabs" role="tablist">
		 	@foreach($table as $index=>$ta)
		 	  <li role="presentation" class="{{$index==0?'active':''}}"><a href="#tab-table-{{$index}}" aria-controls="home" role="tab" data-toggle="tab">{{$ta['title']}}</a></li>
		 	@endforeach

		 </ul>
		<div class="tab-content">
			@foreach($table as $index=>$ta)
		<div role="tabpanel" class="tab-pane {{$index==0?'active':''}}" id="tab-table-{{$index}}">
			<p class="text-center"><b>{{$ta['title']}}</b></p>
			<div class="table-responsive">
				<table class="table-bordered table">
					<thead>
						<tr>
						@foreach ($ta['header'] as $h)
							<th rowspan="{{$h['col']==1?2:1}}" colspan="{{$h['col']??1}}">{{$h['title']}}</th>
						@endforeach
						</tr>
						<tr>
						@foreach ($ta['header'] as $h)
							@if($h['col']==2)
							<th  >NILAI</th>
							<th  >SATUAN</th>
							@else
							@endif
						@endforeach
						</tr>

					</thead>
					<tbody>
						@foreach($ta['body'] as $d)
						<tr>
							@foreach ($d as $di)
								@if($di['head']['col']==1)
									<td colspan="">{{$di['value']}}</td>
								@else
									<td colspan="">{{$di['value']}}</td>
									<td colspan="">{{$di['head']['satuan']}}</td>


								@endif
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endforeach

		</div>
	</div>
</div>
@stop