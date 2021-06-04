@extends('vendor.adminlte.admin')
@section('content_header')
<h4>User {{$data->name}} / {{$data->email}}</h4>
<div class="btn-group">
</div>

@stop
@section('content')
<div class="row">
	<div class="col-md-8">
		<form method="post" action="{{route('admin.users.up_pass',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}">
			@csrf
			<div class="box  box-warning">
			<div class="box-header  with-border">
				<p><b>Ubah Password</b></p>
				</div>
			<input type="hidden" name="action_to" class="action_to" value="">
			<div class="box-body">
				<div class="row">

					<div class="col-md-8">
						<div class="form-group">
							<label>Password</label>
							<input min="8" type="password" name="password" required="" class="form-control" value="">
						</div>
					</div>
					@if(!Auth::User()->can('is_super'))
					<div class="col-md-8">
						<div class="form-group">
							<label>Password Konfirmasi</label>
							<input min="8" type="password" name="password_confirmation" required="" class="form-control" value="">
						</div>
					</div>
					@endif
					<div class="col-md-8">
						
					</div>
				</div>
			</div>
			<div class="box-footer">
		
				<button type="submit" class="btn-primary btn">UPDATE</button>
			</div>
		</div>
		</form>


	</div>
</div>
<hr>
<div class="row" id="data-user">
		<form  action="{{route('admin.users.up_profile',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
				@csrf
			<div class="col-md-8">
				<div class="box box-solid ">
					<div class="box-header with-border">
								<p><b>Profil User</b></p>
					<input type="hidden" name="action_to" class="action_to" value="">

							</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="name" required="" class="form-control" v-model="user.name">
								</div>
							@can('is_super')

								<div class="form-group">
									<label>Role</label>
									<select class="form-control" :disabled="user.is_active == 0" required="" v-model="user.role" name="role">
									@foreach(HPV::role_list() as $key=>$r)
										<option value="{{$r['val']}}" {{$r['val']==$data->role?'selected':''}}>{{$r['text']}}</option>
									@endforeach
									</select>
								</div>
							@endcan

							</div>
							@can('is_super')
							<div class="col-md-6">
								<div class="form-group">
									<label>Status User</label>
									<select class="form-control" required="" v-model="user.is_active" name="is_active">
										<option value="1" > ACTIVE </option>
										<option value="0" > UNACTIVE </option>
									</select>
								</div>
								
								
							</div>

							@endcan
						</div>
					</div>
					<div class="box-footer">
						<div class="form-group">
									<button class="btn btn-primary" type="submit">UPDATE</button>					
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
				          <option value="UPDATE_AND_BACKTOLIST">Kembai ke User List</option>
				        </select>
				      </div>
				    </div>
				  </div>

				  @can('is_super')

				  	<div class="row">
				      @csrf
				      <div class="col-md-12" v-if="user.role==3||user.role==4">
				        <div class="box box-solid">
				          <div class="box-header with-header">
				            <h5><b>AKSES DAERAH - 
				                 </b>  <small>@{{user.role==3?'REGIONAL':'KAB/KOTA'}}</small></h5> 
				                <input type="hidden" name="action_to" class="action_to" value="">
				               

				          </div>
				          <div class="box-body">
				            <div v-if="user.role==3" >
				            	<div class="form-group">

				              <select class="form-control" id="regional" name="role_group[]" multiple="">
				                @foreach($regional_list as $l)
				                <option value="{{$l->id}}" {{in_array($l->id,$regional_list_acc->toArray())?'selected':''}}>{{$l->name}}</option>
				                @endforeach
				              </select>
				             
				            </div>

				            </div>

				            <div class="form-group" v-if="user.role==4">
				              <select class="form-control" id="daerah_akses" name="daerah_akses" v-model="user.kode_daerah">
				              	@foreach($daerah_ac as $l)
					               		 <option value="{{$l->id}}"   >{{$l->text}}</option>
					                @endforeach
				              </select>
				            </div>

				            
				          </div>
				        
				         </div>
				        </div>




				  	</div>
				  	
				    @endcan
			</div>
		</form>
</div>


		
		



@stop

@section('js')

<script type="text/javascript">
	function regional_select2(){


	}

	var vuser=new Vue({
		el:'#data-user',
		data:{
			user:<?= json_encode($data)?>,

		},
		methods:{
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
						$('#daerah_akses').select2();
						$('#instansi_akses').select2();


						},200);

				}
			}
		},
		watch:{
			'user.role':'sr'
		}
	});

		vuser.sr()

	function action_to(){
		var val=$('#action_to').val();
		$('.action_to').val(val);
	}

	$('#action_to').on('change',function(){
		action_to();
	});

	$('#action_to').trigger('change');


</script>
@stop