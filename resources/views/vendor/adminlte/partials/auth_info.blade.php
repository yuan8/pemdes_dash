<ul class="nav navbar-nav">
                      

@if(Auth::check())
@if(config($CONF_THEM.'.right_sidebar') and (in_array(Auth::User()->role,[1,3])))
    <li>
      <a href="#" data-toggle="control-sidebar" ><i class="fa fa-link"></i> URUSAN</a>
    </li>
@endif
 <li class="dropdown user user-menu ">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
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
        <p style="font-size: 12px" class=" text-center text-uppercase"><b>environment</b></p>
      </li>
      <!-- Menu Body -->
      <li class="user-body">
        <ul class="control-sidebar-menu">
          <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('index',['tahun'=>$GLOBALS['tahun_access']])}}">
              <i class="menu-icon ion ion-speedometer bg-primary"></i>
              <div class="menu-info" style="padding-top: 5px;">
                <h4 class="control-sidebar-subheading">PORTAL</h4>

              </div>
            </a>
          </li>
           <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('admin.index',['tahun'=>$GLOBALS['tahun_access']])}}">
              <i class="menu-icon ion ion-speedometer bg-primary"></i>
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
          <a href="#" class="btn btn-default btn-flat">Profile</a>
        </div>
        <div class="pull-right">
          <a href="javascript:void(0)"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
        </div>
      </li>
    </ul>
  </li>
  
@else
<li>
  <a href="{{url('login')}}">
      <i class="fa fa-user-circle"></i> Login
  </a> 
</li>

@endif