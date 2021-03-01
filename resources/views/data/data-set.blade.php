@extends('vendor.adminlte.dashboard')


@section('content')
<div class="banner-content text-center p-10 p-b-50 background-blue" style="position: relative;  min-height: 100px; margin-bottom: 50px;">
	<ol class="breadcrumb text-left">
    <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=" text-capitalize"><a href="{{route('query.data.categorycal',['id'=>$instansi->id,'slug'=>'slug-test'])}}">{{ strtolower((!empty($instansi)) ?$instansi->type.' - '.$instansi->name:'')}}</a>  </li>
    <li class="text-capitalize">
    	{{strtolower($data->name)}}
    </li>
  </ol>

	<div  style="left:0; background: #fff; right: 0; border-radius: 5px; padding: 5px;  margin:auto; min-height: 55px; width: 90%; position: absolute; bottom:-30px; ">
		<h5>{{$data->name}}</h5>
	</div>

	</div>

	<div class="">
		<div class="box box-solid">
			<div class="box-body">
				<h5><b>Deskripsi</b></h5>
				<p>{!!nl2br($data->description)!!}</p>
				<hr>
				{{-- <h5><b>Meta Data</b></h5>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>JENIS</th>
							<th>EXTENSION</th>
							<th>SIZE (Mb)</th>
							<th>KEYWORDS</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$data->type}}</td>
							<td>{{$data->extension}}</td>
							<td>{{$data->size}}</td>
							<td>
								@php
									$keywords=json_decode($data->keywords??'[]',true)??[];
								@endphp
								@foreach($keywords as $k=>$keyw)
									<b>{{$keyw}}</b>
									@if(isset($keywords[$k+1]))
									,
									@endif
								@endforeach

							</td>

						</tr>
					</tbody>
				</table>
				<hr>
				<h5><b>Data</b></h5> --}}
				<div class="btn-group" style="">
					
				</div>
				@if(in_array(strtolower($data->extension), ['xlsx','xls','csv']))
				<div class="">
					@include('partials.show-table-data')
					
				</div>
				@elseif(in_array(strtolower($data->extension), ['pdf','png','jpg','jpeg']))
				<div class="">
					<iframe src="{{url($data->dokument_path)}}" style="width:100%; min-height:400px"></iframe>
				</div>
				@endif


				


			</div>
		</div>
	</div>

@stop