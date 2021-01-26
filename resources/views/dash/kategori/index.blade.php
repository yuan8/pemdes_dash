@extends('vendor.adminlte.dashboard')

@section('content_header')
  <h2 class="text-center text-white" style="padding-bottom: 10px;"><b>{{$data->name}}</b></h2>
@stop


@section('content')

<div class="row">

	<div class="col-md-3">
		
		@if(isset($data))
		<div class="box-solid box c-fix"  data-spy="affix" data-offset-top="200">
			<div class="box-header text-center">
				<img style="max-height: 200px;" src="{{asset($data->image_path)}}" class="img-thumbnail img-responsive">
			</div>
			<div class="box-body">
				<h3><b>KATEGORI {{$data->name}}</b></h3>
				<p>{{$data->description}}</p>
			</div>
		</div>

	@endif
	</div>
		<div class="col-md-9">
		@foreach($data->sub as $d)
			<div class="info-box ">
            <span class="info-box-icon background-primary text-white">
            	<img src="{{asset($d->image_path)}}" style="width:90%;">
            </span>
            <div class="info-box-content">
              <span class="info-box-text">
              	<a href="{{route($d->route,['id'=>$d->id,'slug'=>$d->slug])}}">{{$d->name}}</a>
              </span>
             
              <span class="progress-description text-muted">
                  </span>
                   <div class="progress">
              	<div class="progress"></div>
              </div>
                   {{$d->description}}

                  
            </div>
            <!-- /.info-box-content -->
          </div>
			
		@endforeach

		@if(count($data->sub)<1)
			<h5 class="text-center"><b>BELUM TERDAPAT DATA</b></h5>
		@endif
	</div>
</div>

@stop