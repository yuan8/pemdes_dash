@php
	$imax=0;
	$bg_array=['bg-aqua','bg-red','bg-green','bg-yellow'];
@endphp
<H4 class="text-center" ><b>{{$title}}</b></H4>
<div class="row">
	@foreach($max as $key=>$m)
	@if($imax<4)
	<div class="col-md-3">
		<div class="info-box {{$bg_array[$imax]}}">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{strtoupper(str_replace('_', ' ', $key))}}</span>
              <span class="info-box-number">{{number_format($m)}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              
            </div>
            <!-- /.info-box-content -->
          </div>
	</div>
	@php
	$imax+=1;
	@endphp
	@endif
@endforeach
</div>