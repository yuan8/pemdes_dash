<ul class="nav navbar-nav">
     
    <li>
  <a href="{{route('index',['tahun'=>$GLOBALS['tahun_access']])}}" >
   
      <i class="fa fa-home"></i>  Halaman Depan
  </a> 
</li> 
<li>
  <a href="{{route('index',['tahun'=>$GLOBALS['tahun_access']])}}" >
   
        FaQ
  </a> 
</li> 
<li>
  <a href="{{route('chatter.home')}}" >
   
        Forum
  </a> 
</li> 
<li>
  <a href="{{route('public_tentang',['tahun'=>$GLOBALS['tahun_access']])}}"> Tentang </a>
</li> 
@if(Auth::check())
{{-- <li>
  <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown" aria-expanded="true" id="sso_front_list" >SSO</a>
  <ul class="dropdown-menu" id="sso_content_front_list">
    <li>
      <a href="">loading...</a>
    </li>
  </ul>
</li> --}}
@endif   

@if(Auth::check())
  
    <li>
  <a href="{{route('doc.api',['tahun'=>$GLOBALS['tahun_access']])}}" >
   
      <i class="fa fa-hash"></i>  API
  </a> 
</li> 
@endif   


<li>
    <a href="{{route('p.tahun',['tahun'=>$GLOBALS['tahun_access']])}}"  ><i class="fa fa-calendar"></i> Pindah Tahun</a>
  </li>
@if(Auth::check())
@if(config($CONF_THEM.'.right_sidebar') and (in_array(Auth::User()->role,[1,3])))
 
@endif

 <li class="dropdown user user-menu ">
    <a href="#" class="dropdown-toggle " data-toggle="dropdown" aria-expanded="true">
      <img src="{{asset('asset/user.png')}}" class="user-image" alt="User Image">
      <span class="hidden-xs">.</span>
    </a>
    <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header bg-{{config($CONF_THEM.'.skin', 'blue')}}">
        <img src="{{asset('asset/user.png')}}" class="img-circle" alt="User Image">

        <p>
          {{Auth::User()->name}}
          <small>{{Auth::User()->email}}</small>
        </p>
      </li>
      <li>
        <p style="font-size: 12px" class=" text-center text-uppercase"><b>Environment</b></p>
      </li>
      <!-- Menu Body -->
      <li class="user-body">
        <ul class="control-sidebar-menu">
          <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('index',['tahun'=>$GLOBALS['tahun_access']])}}">
              <i class="menu-icon ion ion-speedometer bg-primary"></i>
              <div class="menu-info" style="padding-top: 5px;">
                <h4 class="control-sidebar-subheading">DASHBOARD</h4>

              </div>
            </a>
          </li>
           <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('admin.index',['tahun'=>$GLOBALS['tahun_access']])}}">
              <i class="menu-icon fa fa-lock bg-red"></i>
              <div class="menu-info" style="padding-top: 5px;">
                <h4 class="control-sidebar-subheading">ADMIN</h4>

              </div>
            </a>
          </li>
        </ul>
        
        <!-- /.row -->
      </li>
      <!-- Menu Footer-->
      <li class="user-footer">
         <form id="logout-form" action="{{ url(config($CONF_THEM.'.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
            @if(config($CONF_THEM.'.logout_method'))
                {{ method_field(config($CONF_THEM.'.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
        <div class="pull-left">
          <a href="{{route('admin.users.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>Auth::User()->id])}}" class="btn btn-default btn-flat">Profile</a>
        </div>
        <div class="pull-right">
          <a href="javascript:void(0)"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
        </div>
      </li>
    </ul>
  </li>
  
@else
<li>
  <a href="{{url('login')}}" class="btn btn-warning btn-ov btn-sm" style="padding: 5px 20px 5px 20px; margin-top: 10px;">
    Masuk
      <i class="fa fa-sign-in-alt"></i> 
  </a> 
</li>

@endif

<script type="text/javascript">
  $('#sso_front_list').on('click',function(){

    get_data_sso('POST');

  });

  var id_ajax_sso=null;

  function get_data_sso(method='GET',data={}){

      if(id_ajax_sso!=null){
        id_ajax_sso.abort();

        id_ajax_sso=null;
      }

    $('#sso_content_front_list').html('<li class="text-center" id="test-load"><b>Loading...</b></li>');
    

    var sso_ajax=$.ajax({
      'url':'{{route('api.sso.list',['tahun'=>$GLOBALS['tahun_access']])}}',
       type: method,
        beforeSend: function(request) {
          request.setRequestHeader("Authorization", 'Bearer {{(Auth::check()?Auth::User()->api_token:'xx')}}');
        },
      'contentType': "application/json; charset=utf-8",
      'statusCode':{
        401:function(){
          // 
        },
        
      },
      success:function(res){
        $('#sso_content_front_list').html(res.data);
      },
      error: function (textStatus, errorThrown) {
          }

    });
  
    id_ajax_sso=sso_ajax;

  }

  var accessFormApi_ajax=[];
  function accessFormApi(route,size='lg',method='POST',data={}){

      if(accessFormApi_ajax[route]!=undefined){
        accessFormApi_ajax[route].abort();

        accessFormApi_ajax[route]=null;
        accessFormApi_ajax=accessFormApi_ajax.splice(route,1);

      }

    

    var sso_ajax=$.ajax({
      'url':route,
       type: method,
        beforeSend: function(request) {
          request.setRequestHeader("Authorization", 'Bearer {{(Auth::check()?Auth::User()->api_token:'xx')}}');
        },
      'contentType': "application/json; charset=utf-8",
      'statusCode':{
        401:function(){
          // 
        },
        
      },
      success:function(res){
        $('#modal_'+size+' .modal-content').html(res.data);
        $('#modal_'+size).modal();
      },
      error: function (textStatus, errorThrown) {
          }

    });
  
    accessFormApi_ajax[route]=sso_ajax;

  }


</script>