<div class="banner-content p-10 p-b-50" style="position: relative; min-height: 80px; margin-bottom: 50px; background: transparent;">

	<div class="row">
		<div class="col-md-4" style="margin-bottom: 0px;">
			<p class="text-white"><b>SELAMAT DATANG DI DASHBOARD</b></p>
			<h3 class="text-white"><b>BINA PEMERINTAHAN DESA</b></h3>
			<p class="text-white text-uppercase">Kementerian Dalam Negeri</p>
		</div>
		<div class="col-md-8">
			
		</div>
	</div>

	<div  style="left:0; right: 0; margin:auto; height: 55px; width: 90%; position: absolute; bottom:40px; ">
		<form action="{{route('query.data',[])}}" method="get">
			
      	<div class="row">
      		<div class="col-md-9 col-md-offset-3">
      			<div  style="min-height: 50px;">
      				 <div class="collapse navbar-collapse pull-left" id="navbar-collapse" style=" margin-top:10px; color:#fff; margin-bottom: 10px;">
                        <ul class="nav navbar-nav">
                            @each('vendor.adminlte.partials.menu-item-top-nav', MENUS::dashboard()['top'], 'item')
                        </ul>
                  </div>
      			</div>
      			<div class="input-group" style="border: 2px solid #6db3ee; width:100%; border-radius: 30px; overflow: hidden; ">
      			<input type="text" class="form-control" name="q" placeholder="Cari Data,Tema,Instansi" style="height: 55px;">
      			<span class="input-group-btn">
        <button class="btn btn-primary background-blue" type="submit" style="height: 55px; min-width: 100px;"><i class="fa fa-search"></i></button>
      </span>
      			</div>
      	</div>
      
    </div>
		</form>

	</div>

</div>