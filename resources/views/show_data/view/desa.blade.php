<div class="row">
	<div class="col-md-4">
		<label>Provinsi</label>
		<select class="form-control" id="provinsi">
				@foreach(DB::table('master_provinsi')->get() as $key=>$t)
				<option value="{{$t->kdprovinsi}}">{{$t->nmprovinsi}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-4">
		<label>Kota/Kab</label>
		<select class="form-control" id="kota"></select>
	</div>
	<div class="col-md-4">
		<label>Kecamatan</label>
		<select class="form-control" id="kecamatan"></select>
	</div>
</div>


<script type="text/javascript">
	var id_hrs=[];
	var kdparent=0;
	

	$('#provinsi').select2();
	$('#data').select2();


	$('#provinsi').on('select2:select', function (e) {
		kdprovinsi(this.value);
		change_parent();	
	});

	$('#kota').on('select2:select', function (e) {
		kdkota(this.value);
		change_parent();	
	});

	$('#kecamatan').on('select2:select', function (e) {
		kdkecamatan(this.value);
		change_parent();	
	});



	function kdprovinsi(kd){
		$('#kota').val(null).trigger('change');
		$('#kota').html('').trigger('change');
		$('#kecamatan').val(null).trigger('change');
		$('#kecamatan').html('').trigger('change');


		$('#desa').val(null).trigger('change');
		$('#desa').html('').trigger('change');
		$('#kota').append('<option value="" selected >-</option>');
				$('#kota').trigger('change');


		if(kd){

			$.get('{{route('api.meta.kota')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#kota').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');
				}
				$('#kota').trigger('change');
				$('#kota').select2();
			});

			


		}

	}

	function kdkota(kd){

		$('#kecamatan').val(null)
		$('#kecamatan').html('');
		$('#desa').val(null);
		$('#desa').html('');

		$('#kecamatan').append('<option value="" selected >-</option>');
		$('#kecamatan').trigger('change');



		if(kd){
			$.get('{{route('api.meta.kecamatan')}}/'+kd,function(res){
				res=res.result;
				for(var i=0;i<res.length;i++){
					$('#kecamatan').append('<option value="'+res[i].id+'"  >'+res[i].text+'</option>');

				}
				$('#kecamatan').trigger('change');
				$('#kecamatan').select2();
			});
			
			

		}
		
		
	}

	function kdkecamatan(kd){

		$('#desa').val(null).trigger('change');
		$('#desa').html('');
		$('#desa').append('<option value="" selected >-</option>');
		$('#desa').trigger('change');

		
		if(kd){

			$.get('{{route('api.meta.desa')}}/'+kd,function(res){
				res=res.result;

				for(var i=0;i<res.length;i++){
					$('#desa').append('<option value="'+res[i].id+'" >'+res[i].text+'</option>');

				}
				$('#desa').select2();

			});

		

		}
			

	}


	function change_parent(){
		if($('#kecamatan').val()){
    		var c=$('#kecamatan').val();
    	}else if($('#kota').val()){
    		var c=$('#kota').val();
    	}else if($('#provinsi').val()){
    		var c=$('#provinsi').val();
    	}

    	if(kdparent!=c){
    		if(typeof get_data !== 'undefined' ){
    			kdparent=c;
    			get_data('#dom_l_2','{{route('vs.data.integrasi.desa',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}?kode_daerah='+kdparent);
    			}

    	}	
	}
		

	
	

	 function exportExcelTable(dom,title){
       $(dom).tableExport({
        type:'xlsx',
        headings: true, 
        exclude:".no-export",
        fileName: title,  // (id, String), filename for the downloaded file
        bootstrap: true,  
        ignoreCSS:'.ignore-export',
        trimWhitespace:true                 // (Boolean), style buttons using bootstrap
   	 });

		//  $(dom).floatThead({
		// 			'position':'absolute',
		// });

     }
</script>
