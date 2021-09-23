@extends('vendor.adminlte.dashboard')

@section('content_header')
	

@stop

@section('content')
	<div id="faq-con">

		<h4 class="text-center"><b>FAQ</b></h4>
	
	<div class="container">
			<div class="box-solid box">
				<div class="box-body">
					<div class="row">
			<div class="col-md-6">
				<label>Search</label>
				<input type="" v-model="search" class="form-control" name="">
			</div>
			<div class="col-md-6">
				<label>Kategory</label>
				<select class="form-control" v-model="cat">
					<option v-for="c in cat_list"  v-bind:value="c.id">@{{c.nama}}</option>
				</select>
			</div>

			</div>
				</div>
			</div>

			<p v-if="loading" class="text-center">Loading...</p>
			<p v-if="loading==false && category.length==0" class="text-center">Data Tidak Ditemukan</p>

		 <ul class="list-group">
		  <li  v-for="(item,key) in category" class="list-group-item text-capitalize">
		  	<b v-on:click="active(item.id)"><a href="javascript:void(0)">@{{item.nama}}</a>
		  		
		  	</b>
		  	<span class="badge">@{{item.questions.length}}</span>
		  	<ul class="list-group" v-if="key_active==item.id" style="margin-top: 10px;">
		  		<span v-for="(q,kq) in item.questions">
			  		<li  class="list-group-item text-capitalize ">
			  			<b v-on:click="active_q(q.id)"><a href="javascript:void(0)">@{{q.question}}</a></b>
			  			
			  		</li>
			  		<li v-if="quest_active==q.id" class="list-group-item text-capitalize bg-green">
			  			<p v-html="q.answer"></p>
			  		</li>
		  		</span>
		  	</ul>
		  </li>
		 
		</ul> 
		
	</div>
	</div>

@stop


@section('js')
<script type="text/javascript">
	window.ajax_data=null;
	var vfaq=new Vue({
		el:'#faq-con',
		data:{
			category:[],
			key_active:null,
			quest_active:null,
			search:'{{$req['q']??''}}',
			cat_list:<?=json_encode($category??'[]')?>,
			cat:{!!$req['category']??'""'!!},
			loading:true,

		},
		methods:{
			active:function(id){
				this.key_active=id;
				this.quest_active=null;
			},
			active_q:function(id){
				this.quest_active=id;
			},
			get_data:function(){
				if(window.ajax_data){
					window.ajax_data.abort();
				}
				this.loading=true;

				setTimeout(function(){
					window.ajax_data=$.ajax({
					url:'{{route('api.faq.data',['tahun'=>$GLOBALS['tahun_access']])}}',
					headers:{
						Autorization:'Bearer {{Auth::check()?Auth::User()->api_token:''}}'
					},
					 data: "q="+encodeURI(vfaq.search)+"&category="+(vfaq.cat??null),
					success:function(data){
						vfaq.category=data.category;
						vfaq.cat_list=data.cat_list;

					}
				});
				vfaq.loading=false;

				},1000);
			}
		},
		watch:{
			cat:'get_data',
			search:'get_data',

		}

	});

	vfaq.get_data();
</script>

@stop