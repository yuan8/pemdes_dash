@extends('vendor.adminlte.dashboard')


@section('content')
<div class="banner-content text-center p-10 p-b-50" style="position: relative; background:linear-gradient(163deg, rgba(146,146,232,1) 17%, rgba(51,122,183,1) 52%, rgba(42,67,111,1) 88%); min-height: 100px; margin-bottom: 50px;">
	<ol class="breadcrumb text-left">
    <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=" text-capitalize"><a href="{{route('query.data.categorycal',['tahun'=>$GLOBALS['tahun_access'],'id'=>$instansi->id,'slug'=>'slug-test'])}}">{{ strtolower((!empty($instansi)) ?$instansi->type.' - '.$instansi->name:'')}}</a>  </li>
    <li class="text-capitalize">
    	{{strtolower($data->name)}}
    </li>
  </ol>


	
	
	<div  style="left:0; background: #fff; right: 0; border-radius: 5px; padding: 5px;  margin:auto; min-height: 55px; width: 90%; position: absolute; bottom:-30px; ">
		<h5>{{$data->name}}</h5>
		
	</div>

	</div>

	<div class="container">
		<div class="box box-solid">
			<div class="box-body">
				<h5><b>Deskripsi</b></h5>
				<p>{!!nl2br($data->description)!!}</p>
				<h5><b>Meta Data</b></h5>
				<h5><b>Data</b></h5>
				@if(in_array(strtolower($data->extension), ['xlsx','xls','csv']))
					@include('partials.show-table-data')
				@endif

				


			</div>
		</div>
	</div>

@stop