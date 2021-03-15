@extends('vendor.adminlte.dashboard')

@section('content_header')

@stop

@section('content')
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-solid">
				<div class="box-header text-center with-border">
			<h1><b>{{$broker['name']}}</b></h1>
					 
				</div>
		<div class="box-body text-center">
			<h2 class="" id="login-m">Waiting Response</h2>
			<p><b id="seconds"></b> Detik</p>
		</div>
	</div>
		</div>
	</div>
	<div id="res" style="overflow: hidden; height: 1px; width:1px; "></div>

@stop

@section('js')
<script type="text/javascript">
	var count_attemp=0;
	$(function(){
		countdown();
		attemp();
			
	});

	// function attemp(){
	// 	count_attemp+=1;
	// 	$.post('{{$broker['direct_login']}}',{'_sso_access':'{{$sso_token}}'},function(res){
	// 		res=JSON.parse(res);
	// 		console.log(res);
	// 		if(res.status==200){
	// 			window.location.href='{{$broker['home']}}';

	// 		}else{
	// 			if(count_attemp<4){
	// 				setTimeout(function(){
	// 				attemp();

	// 				},1000);				
	// 			}else{
	// 				window.close();

	// 			}
	// 		}
	// 	});
	// }

	function attemp(){
		count_attemp+=1;
		var data={'{{$broker['u']}}':'{{$data->email}}','{{$broker['p']}}':'{{$data->pass}}'};
		var add=<?= json_encode($broker['add']) ?>;
			// console.log(add);

		for(i in  add){
			// console.log(add[i]);
			data[i]=add[i];
		}
		// console.log(data);

		$.get('{{$broker['login']}}',data,function(res){

			$('#res').html(res);
			$('form').attr('action','{{$broker['login']}}');

			$('input[name="{{$broker['u']}}"]').val('{{$data->email}}');
			$('input[name="{{$broker['p']}}"]').val('{{$data->pass}}');
			$('button[type="submit"]').click();




		});
	

	}

	var cc=30;
	function countdown(){
		cc-=1;
		$('#seconds').html(cc);
		setTimeout(function(){
			if(cc==0){
				$('#login-m').html('Login Gagal, anda akan diarahkan menuju login manual');
				setTimeout(function(){
				window.location.href='{{$broker['home']}}';

				},3000);
			}else{
			countdown();

			}
		},1000);
	}



</script>
@stop