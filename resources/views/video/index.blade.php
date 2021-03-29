@extends('vendor.adminlte.dashboard')

@section('content_header')

@stop

@section('content')
<div >
	<style type="text/css">
		body,.content-wrapper{
			background: #222;
		}
	</style>
	
</div>
	<div class="container-fluid" style="background: #222; padding-top: 10px;" >
		<div style="width:100%; float: left; border-radius: 30px; margin-bottom: 10px; overflow: hidden; border: 1px solid #fa090a ">
                <div class="input-group" style="height:20px;">
                  <input type="text" class="form-control input-sm" name="q" placeholder="Cari Data,Tema,Instansi	" style="border: none; height:50px;" value="">
                  <span class="input-group-addon" style="background: #fff; border:none;">
                    <button class="btn btn-warning btn-sm btn-ov" type="submit">Cari <i class="fa fa-search"></i></button>
                  </span>
                </div>
              </div>

		<div class="row" style="background: #222; padding-top: 15px;" >
		<div class="col-md-8">
				@if($data)
						<video class=""  controls class="btn-ov" poster="{{asset($data->thumbnail)}}">
						 <source src="{{asset($data->path)}}" type="video/{{strtolower($data->extension)}}">
						
					</video>
			<h4 class="text-white"><b>{{$data->judul}}</b></h4>

					<p class="text-white">{{$data->deskripsi}}</p>
			<div class="box box-solid background-primary btn-ov">
				<div class="box-body">
					
				</div>
			</div>

				@endif
		</div>
		<div class="col-md-4">
			@foreach($list as $e)
			<a href="{{route('video.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$e->id])}}" class="organisasi-hover" style="width: 100%; min-height:100px; max-height: 200px; overflow: hidden; float: left; margin-bottom: 10px; position: relative;">
				<img class="point-hover" src="{{asset($e->thumbnail)}}" style="width: 100%; ">
				<div style="position: absolute; bottom:0; left:0; width: 100%; background: linear-gradient(0deg, rgba(34,34,34,1) 68%, rgba(38,37,33,0.7399334733893557) 88%, rgba(45,43,32,0.13209033613445376) 100%); padding: 5px;">
					<h5 class="text-white"><b>{{$e->judul}}</b></h5>
				</div>
			</a>
			@endforeach
			
			

			

		</div>
		
	</div>
	</div>
	<style type="text/css">
		video {
		  width: 100%;
		  height: auto;
		}
	</style>
@stop