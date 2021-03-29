@foreach($data as $d)
<li>
	<a target="_blank" href="{{route('sso.login',['tahun'=>$GLOBALS['tahun_access'],'id'=>MyHash::pass_encode($d->id.'//'.\Carbon\Carbon::now())])}}" >{{$d->app_meta['name']}} <i class="fa fa-sign-in-alt"></i></a>
</li>
@endforeach

<li>
	<button onclick="accessFormApi('{{route('api.sso.add',['tahun'=>$GLOBALS['tahun_access']])}}','sm')" class="btn btn-warning btn-xs text-dark col-md-12"><i class="fa fa-pen"></i><b>SSO Akses</b></button>
</li>
