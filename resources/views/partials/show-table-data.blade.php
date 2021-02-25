<?php
	
	$data_table=HPV::data_set((array) $data);
	$fd=false;
?>


@if($data_table)
<ul class="nav nav-tabs">
  
@foreach($data_table as $key=>$tb)
<li class="{{$fd==false?'active':''}}"><a data-toggle="tab" href="#sheet_{{str_replace(' ', '_', strtolower($key))}}"><b>{{$key}}</b></a></li>
<?php
	$fd=true;
?>
@endforeach
</ul>
<?php
	$fd=false;
?>


<div class="tab-content">
@foreach($data_table as $key=>$tb)
<div id="sheet_{{str_replace(' ', '_', strtolower($key))}}" class=" table-responsive tab-pane fade in {{$fd==false?'active':''}}">
	<?php
	$fd=true;
?>
<h5 class="text-center"><b>{{$key}}</b></h5>
<hr>
<table class="table-bordered table" style="background: #ddd">
	<tbody>
		@foreach($tb as $d)
		<tr>
		@foreach($d as $x)
		<td>{{HPV::nformat($x)}}</td>
		@endforeach
		</tr>

		@endforeach
	</tbody>
</table>
</div>

@endforeach
</div>

@endif