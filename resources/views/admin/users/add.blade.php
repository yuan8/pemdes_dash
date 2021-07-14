@extends('vendor.adminlte.admin')
@section('content_header')
<h4 id="head-nativ">User @{{user.name}} / @{{user.email}}</h4>
<div class="btn-group">
</div>

@stop
@section('content')

<div class="row" id="data-user">
		<form  action="{{route('admin.users.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
				@csrf
			<div class="col-md-8">
				<div class="box box-solid ">
					<div v-bind:class="'box-header with-border '+(user.is_active?'':'bg-maroon')">
								<p><b>Profil User @{{user.name.toUpperCase()}} (@{{user.username}})</b></p>
					<input type="hidden" name="action_to" class="action_to" value="">

							</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Email</label>
									<input type="email" disabled="" name="m" required="" class="form-control" v-model="user.email">
									<input type="hidden" name="email" v-model="user.email">
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="text" v-bind:disabled="disabled_account" name="us" required="" class="form-control" v-model="user.username">
								</div>
								<input type="hidden" name="username" v-model="user.username">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="name" required="" class="form-control" v-model="user.name">
								</div>
								<div class="form-group">
									<label>NIK</label>
									<input type="text" name="nik" required="" class="form-control" v-model="user.nik">
								</div>
								<div class="form-group">
									<label>NIP</label>
									<input type="text" name="nip" required="" class="form-control" v-model="user.nip">
								</div>
								<div class="form-group">
									<label>JABATAN</label>
									<input type="text" name="jabatan" required="" class="form-control" v-model="user.jabatan">
								</div>

								
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nomer Telpon</label>
									<input type="text" min="11" name="nomer_telpon" required="" class="form-control" v-model="user.nomer_telpon">
								</div>
								<div class="form-group" v-if="user.nomer_telpon.length>=16" >
									<label>Status  Nomer Pada Aplikasi Whatsapp</label>
									<p><span>	<input type="checkbox" name="wa_number"  class="flat-red" name="wa_number" v-model="user.wa_number"></span> @{{user.wa_number?'Terdaftar':'Tidak Terdaftar'}}</p>
								</div>
								<input type="hidden" name="wa_notif" v-model="user.wa_notif">
								<div class="form-group" v-if="Boolean(user.wa_number)===true && user.role==4">
									<label>Status Wa Blash</label>
									<p><span>	<input type="checkbox" name=""  class="flat-green"  v-model="user.wa_notif"></span> @{{user.wa_notif?'Aktif':'Tidak Aktif'}}</p>
								</div>
								<div class="form-group">
									<label>Status User</label>
									<select class="form-control" required="" v-model="user.is_active" name="is_active">
										<option value="1" > ACTIVE </option>
										<option value="0" > UNACTIVE </option>
									</select>
								</div>
								<div class="form-group" v-if="user.role==4" >

									<label>Admin Derah</label>
									<p><span>	<input type="checkbox" name="main_daerah"  class="flat-red" v-model="user.main_daerah"></span> @{{user.main_daerah?'ADMIN DAERAH':'BUKAN ADMIN DAERAH'}}</p>
								</div>
								<div class="form-group" v-if="(Boolean(user.main_daerah)==false)&& user.role==4">
									<label>Role Walidata</label>
									<p><span>	<input type="checkbox" name="walidata"  class="flat-red"  v-model="user.walidata"></span> @{{user.walidata?'STATUS WALIDATA':'STATUS PRODUSEN DATA'}}</p>
								</div>
								
							@can('is_super')

								<div class="form-group">
									<label>Role</label>
									<select class="form-control" required="" v-model="user.role" name="role">
									@foreach(HPV::role_list() as $key=>$r)
										<option value="{{$r['val']}}">{{$r['text']}}</option>
									@endforeach
									</select>
								</div>
							@endcan
							<input type="hidden" name="role" v-model="user.role">

							<div class="form-group" >

									<label>Password</label>
									<input type="password" name="password"  class="form-control" required="" v-model="user.password" >
								</div>
								<div class="form-group" >
									<p class="text-red">@{{user.password_conf_status}}</p>
									<label>Password Konfirmasi</label>
									<input type="password" required="" name="password_confirmation"  class="form-control" v-model="user.password_conf" >
								</div>




							</div>
							

						</div>
					</div>
					<div class="box-footer">
						<div class="form-group">
							<button class="btn btn-primary" type="submit">SIMPAN</button>					
						</div>
					</div>
				
				</div>
				{{-- <div class="box" v-if="user.role!=1">
				  		<div class="box-body">
				  			 <div class="form-group">
				            	<label >Instansi Akses</label>
				            	<select id="instansi_akses" multiple="" class="form-control" name="instansi[]">
				            			@foreach ($instansi as $i)
					            		<option value="{{$i->id}}" {{in_array($i->id,$record_instansi)?'selected':''}}>{{$i->name}}</option>
					            		@endforeach
				            	</select>

				            </div>
				  		</div>
				  	</div> --}}
			</div>
			<div class="col-md-4">
				  <div class="box box-solid">
				    <div class="box-body">
				      <div class="form-group">
				        <label>JENIS AKSI UPDATE</label>
				        <select class="form-control" name="action_to" id="action_to">
				          <option value="UPDATE_AND_BACKTOFORM">Kembali Keform</option>
				          <option value="UPDATE_AND_BACKTOLIST">Kembali ke User List</option>
				        </select>
				      </div>
				    </div>
				  </div>


				  	<div class="row">
				      @csrf

				      <div class="col-md-12" v-if="user.role==3||user.role==4">
				        <div class="box box-solid">

				          <div class="box-header with-header">
				            <h5><b>AKSES DAERAH - 
				                 </b>  <small>@{{user.role==3?'REGIONAL':'	'}}</small></h5> 
				                <input type="hidden" name="action_to" class="action_to" value="">

				          </div>
				          <div class="box-body">
				 		 @can('is_super')

				            <div v-if="user.role==3" >
				            	<div class="form-group">

				              <select class="form-control" id="regional" name="role_group[]" multiple="">
				                @foreach($regional_list as $l)
				                <option value="{{$l->id}}" {{in_array($l->id,$regional_list_acc->toArray())?'selected':''}}>{{$l->name}}</option>
				                @endforeach
				              </select>
				             
				            </div>

				            </div>
				    @endcan
				    		@can('is_admin')
				    		<div class="form-group" v-if="parseInt(user.role)==4">
				    			<label>Level User</label>
				    			<select class="form-control" v-model="scope">
				    				<option v-for="i in list_scope" v-if=""  v-bind:value="i.id">@{{i.text}}</option>	
				    			</select>
				    		</div>
				    		@endcan

				    		@can('is_daerah')
				            <div class="form-group" v-if="parseInt(user.role)==4 && scope>=2">
				              <select class="form-control" id="daerah_akses" name="kode_daerah"  >
				              @if(Auth::User()->role==4)
				              	@foreach($list_daerah_access as $l)
					               		 <option value="{{$l->id}}">{{$l->text}}</option>
					             @endforeach
				             
				              @endif
				              </select>
				            </div>

				           @endcan

				            
				          </div>
				        
				         </div>
				        </div>




				  	</div>
				  	
			</div>
		</form>
</div>
<hr>
<div class="row">
	<div class="col-md-8">


	</div>
</div>

		
		



@stop

@section('js')

<script type="text/javascript">
	function regional_select2(){


	}

	var them_phone='';
	var them_nik='';

var headVue=new Vue({
	el:'#head-nativ',
	data:{
		user:{
			name:null,
			username:null,
			email:null
		}
	}
});

	var vuser=new Vue({
		el:'#data-user',
		data:{
			user:{
				email:'{{old('email')}}',
				username:'{{old('username')}}',
				jabatan:'{{old('jabatan')}}',
				nik:'{{old('nik')}}',
				nip:'{{old('nip')}}',
				name:'{{old('name')}}',
				role:{{Auth::User()->role==4?4:old('role')??0}},
				daerah_selected:null,
				daerah_selected_regional:null,
				main_daerah:{!!old('main_daerah')?'true':'false'!!},
				kode_daerah:"{{old('kode_daerah')??(Auth::User()->role==4?Auth::User()->kode_daerah:"")}}",
				walidata:{!!old('walidata')?'true':'false'!!},
				nomer_telpon:'{{old('nomer_telpon')??'+62'}}',
				wa_number:{!!old('wa_number')?'true':'false'!!},
				wa_notif:{!!old('wa_notif')?'true':'false'!!},
				is_active:{!!old('is_active')?1:0!!},
				password:null,
				password_conf:null,
				password_conf_status:null,


			},
			disabled_account:false,
			listing_daerah:[],
			scope:{{strlen(Auth::User()->kode_daerah)}},
			list_scope:[

			
				{
					'text':'USER PROVINSI',
					'id':2
				},
				{
					'text':'USER KOTA/KAB',
					'id':4
				},
				{
					'text':'USER KECAMATAN',
					'id':6
				},
				{
					'text':'USER DESA/KEL',
					'id':10
				}
			],
		


		},
		methods:{
			password_check:function(){
				if(this.user.password==this.user.password_conf){
					this.user.password_conf_status=null;
				}else{
					this.user.password_conf_status='Password Tidak Sama';
				}
			},
			check_account(){
				if(this.user.role==4 && this.user.kode_daerah!=null){
					this.disabled_account=true;
					this.user.email=this.user.kode_daerah+"@"+"{{env('DOMAIN_MAIL')}}";
					this.user.username=this.user.kode_daerah;
						
				}else{
					this.disabled_account=false;
				}
				console.log(this.user.role,this.user.kode_daerah);
			},
			sr:function(val=this.user.role){
				
				if(val==2){
					setTimeout(function(){
					$('#instansi_akses').select2();

					},200);

				}else if(val==3 ){
					setTimeout(function(){
						$('#regional').select2();
						$('#instansi_akses').select2();


						},200);
				}else if(val==4){

					setTimeout(function(){
						if(({!!Auth::User()->role==4?'true':'false'!!}) && vuser.user.role==4){
							$('#daerah_akses').select2();
							$('#daerah_akses').trigger('change');
							window.get_change_daerah();

						}
						$('#instansi_akses').select2();

					},200);
					this.user.main_daerah=true;

				}

				this.check_account();
			},
			username_bind:function(){
				if(this.user.username){
					if(this.user.username!=window.username_them){
						this.user.username=this.user.username.replace(/ /g,'_');
						window.username_bindthem=this.user.username;
						headVue.user.username=this.user.username;
						this.user.email=this.user.username+'@'+'{{env('DOMAIN_MAIL')}}';
					}
				}
			},
			 phoneNumber:function(){
                if(this.user.nomer_telpon){
                    var val=this.user.nomer_telpon;
                        var char_phone='';
                        val=val.replace(/[-]/g,'');
                        val=val.replace('+62','0');
                        val=val.slice(0,13);
                        let arr_val=val.split('');
                        for(var i=0;i<arr_val.length;i++){
                            if((i==0) && (arr_val[0]!='+')){
                                char_phone='+62';
                            }else if((i==0) && (arr_val[0]=='+')){
                                char_phone='+';
                            }
                            if(i>0){
                                if(i%3==0){
                                    char_phone+='-';
                                }
                                if( !isNaN(parseInt(arr_val[i])) || (arr_val[i]=='-')){
                                    char_phone+=arr_val[i];
                                }

                            }


                        }
                        if(window.them_phone!=char_phone){
                            this.user.nomer_telpon=char_phone;
                            window.them_phone=char_phone;
                            


                        }else{
                            this.user.nomer_telpon=window.them_phone;

                            // this.bc();

                        }


                        if(this.user.nomer_telpon.length<16){
                        	this.user.wa_number=false;
                        	this.user.wa_notif=false;

                        }

                }

            },
            scope_change:function(){
            	var val=this.scope;
				@if(Auth::User()->role!=4)
					setTimeout(function(){

	            	y=window.build_daerah(val);
	            	if(vuser.user.daerah_selected){
	            		$('#daerah_akses').val(vuser.user.daerah_selected.id).trigger('change').text('ss');
	            		if(vuser.user.daerah_selected){
			      	 		var newOption = new Option(vuser.user.daerah_selected.text, vuser.user.daerah_selected.id, true, true);
    						$('#daerah_akses').append(newOption).trigger('change');
	            		}
	            	}
	            },500);

				@else
				$('#daerah_akses').select2();
				window.get_change_daerah();


				@endif


            },
            check_scope:function(){
            	switch((this.user.kode_daerah+'').length){
            		case 0:
            	       this.scope=0;
            	       break;
            	     case 2:
            	       this.scope=2;
            	       break;
            	    case 4:
            	       this.scope=4;
            	       break;
            	    case 6:
            	       this.scope=6;
            	       break;
            	    case 10:
            	       this.scope=10;
            	       break;
            	}

            	this.scope_change();
            	    
            	
            	
            },
             nikNumber:function(){
                if(this.user.nik!=them_nik){
                    var val=this.user.nik??'';
                        var char_phone='';
                        val=val.replace(/[-]/g,'');
                        val=val.slice(0,16);
                        let arr_val=val.split('');
                        for(var i=0;i<arr_val.length;i++){
                          
                                if(i%4==0 && i!=0){
                                    char_phone+='-';
                                }
                                if( !isNaN(parseInt(arr_val[i])) || (arr_val[i]=='-')){
                                    char_phone+=arr_val[i];
                                }

                            


                        }
                        if(window.them_nik!=char_phone){
                            this.user.nik=char_phone;
                            window.them_nik=char_phone;
                            


                        }else{
                            this.user.nik=window.them_nik;

                            // this.bc();

                        }

                }

            },


		},
		watch:{
			'user.name':function(){
				headVue.user.name=this.user.name;
			},
			'user.email':function(){
				headVue.user.email=this.user.email;
			},
			'user.role':'sr',
			'user.nomer_telpon':'phoneNumber',
			'user.nik':'nikNumber',
			'scope':'scope_change',
			'user.username':'username_bind',
			'user.password':'password_check',
			'user.password_conf':'password_check',
			'user.kode_daerah':'check_account'

		}
	});

		vuser.sr();
		vuser.phoneNumber();
		vuser.nikNumber();
		vuser.check_scope();
		vuser.username_bind();
		headVue.user=vuser.user;


	function action_to(){
		var val=$('#action_to').val();
		$('.action_to').val(val);
	}

	$('#action_to').on('change',function(){
		action_to();
	});

	$('#action_to').trigger('change');


	function build_daerah(val){
		console.log(val);
			var c=$('#daerah_akses').select2({
    		ajax:{
    			 headers: {
			        "Authorization" : "Bearer {{Auth::User()->api_token}}",
			        "Content-Type" : "application/json",
			    },
    			url:'{{route('api.list_access_daerah',['tahun'=>$GLOBALS['tahun_access']])}}',
    			data: function (params) {
			      var query = {
			        q: params.term,
			        scope: val
			      }

			      return query;
			    },
			    processResults: function (data) {
			      // Transforms the top-level key of the response object from 'items' to 'results'

			      

			      return {
			        results: data.items
			      };
			    },
			    cache: false,
			   

    		}
    	});

			get_change_daerah();
		

		return 'ss';
	}

	function get_change_daerah(){
		$('#daerah_akses').on('change',function(){
			vuser.user.kode_daerah=this.value;
			vuser.check_account();
		});
	}

</script>
@stop