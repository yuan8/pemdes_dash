<div class="banner-content p-10" style="position: relative; min-height: 80px; background: transparent;">

  <div class="row" >
  	<div style="max-width: 40%; overflow: hidden; position: absolute; bottom: 0px;  max-height: 80%; margin:auto; " class="text-center">
  	<img class="hidden-sm hidden-xs" src="{{asset('dist-web/img-banner.png')}}" style="max-height: 90%; max-width:80%; "  >
  	</div>
    <div class="col-md-5" style="margin-bottom: 0px;">

    </div>
    <div class="col-md-7" style="min-height: 40px; ">
     <div style="width: 90%; margin-left: 25px;">
     	 @if(!isset($hm))
      <p class="text-white" style="margin-bottom:5px; line-height: 14px;"><b>SELAMAT DATANG</b></p>
      @endif
      <h2 class="text-white" style="margin: 0px; line-height: 20px;"><b>DASHBOARD - {{$GLOBALS['tahun_access']}}</b></h2>
      <h3 class="text-white text-uppercase" style="margin: 5px 0px 5px 0px; line-height: 18px;">Bina Pemerintahan Desa</h3>
         @if(!isset($hm))
         <p class="text-white">Dashboard Bina Pemerintahan Desa Menyediakan Data Desa Yang Merupakan Himpunan data terkait potensi, tingkat perkembangan dan data dasar keluarga, dari pengumpulan data di sistem informasi yang berada di Direktorat Jendral Bina Pemerintahan Desa dan diverifikasi terlebih dahulu oelh Organisasi Peragkat Desa yang Berwenang. </p>
         @endif
     </div>
    <div style="left:0; padding: 0px; right: 0; margin:auto; height: 55px; width: 90%; margin-left:15px; position: absolute; bottom:{{!isset($hm)?'-60px;':'-60px;'}}">
    	 <div class="collapse navbar-collapse pull-left hidden-xs hidden-sm" id="navbar-collapse" style=" margin-top:5px; margin-left: 0px; color:#fff; margin-bottom: 5px;">
        <ul class="nav navbar-nav">
          @each('vendor.adminlte.partials.menu-item-top-nav', MENUS::dashboard()['top'], 'item')
        </ul>
     </div>
        <form action="{{route('query.data',['tahun'=>$GLOBALS['tahun_access']])}}" method="get">
          <div class="row">
            <div class="col-md-12" style="min-height: 40px;">
              <div style="width:100%; float: left; border-radius: 30px; overflow: hidden; border: 1px solid #fa090a ">
                <div class="input-group" style="height:20px;">
                  <input type="text" class="form-control input-sm" name="q" placeholder="Cari Data,Tema,Instansi	" style="border: none; height:50px;" value="{{isset($req)?$req->q:''}}">
                  <span class="input-group-addon" style="background: #fff; border:none;">
                    <button class="btn btn-warning btn-sm btn-ov" type="submit">Cari <i class="fa fa-search"></i></button>
                  </span>
                </div>
              </div>
            </div>

          </div>
        </form>

    </div>

    </div>
  </div>



</div>