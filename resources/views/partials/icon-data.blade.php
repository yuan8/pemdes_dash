
@if($type=='FILE')
<i class="fa fa-file hover-point"></i>
@elseif($type=='CONTROLLER')
<i class="fa fa-file hover-point"></i>
@elseif($type=='DATASET')
<i class="fa fa-file hover-point"></i>
@elseif($type=='INFOGRAFIS')
<i class="fa fa-image hover-point"></i>
@elseif($type=='VISUALISASI')
<i class="fa fa-chart-bar hover-point"></i>
@elseif($type=='AUTOMATION')
<i class="fa fa-chart-line hover-point"></i>
@else
<i class="fa fa-times hover-point">{{$type}}</i>

@endif

